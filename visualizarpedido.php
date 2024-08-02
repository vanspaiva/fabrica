<?php
session_start();

if (isset($_SESSION["useruid"])) {

    include("php/head_updateprop.php");
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';
    $user = $_SESSION["useruid"];


?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        function adicionarHorasUteis($dataInicio, $horas)
        {
            $data = new DateTime($dataInicio);
            $horasPorDia = 9; // Horário de expediente: 8h às 18h com 1h de almoço

            while ($horas > 0) {
                $horaAtual = (int)$data->format('H');
                $minutoAtual = (int)$data->format('i');
                $horasRestantesNoDia = 18 - $horaAtual;
                if ($horaAtual < 8) $horasRestantesNoDia = 10; // Se for antes das 8h

                if ($horas <= $horasRestantesNoDia) {
                    $data->modify("+$horas hours");
                    $horas = 0;
                } else {
                    $horas -= $horasRestantesNoDia;
                    $data->modify('+1 day');
                    if ($data->format('N') >= 6) {
                        // Pular fins de semana
                        $data->modify('+2 days');
                    }
                    $data->setTime(8, 0); // Início do expediente no novo dia
                }
            }

            return $data->format('d-m-Y H:i');
        }

        function calcularDiasNoFluxo($conn, $fluxo)
        {
            $sqlEtapas = "SELECT duracao FROM fluxo_setor WHERE idfluxo='$fluxo';";
            $retEtapas = mysqli_query($conn, $sqlEtapas);

            $totalHoras = 0;
            while ($rowEtapa = mysqli_fetch_assoc($retEtapas)) {
                $totalHoras += $rowEtapa['duracao'];
            }

            $horasPorDia = 9; // 8h às 18h com 1h de almoço
            $dias = floor($totalHoras / $horasPorDia);
            $horasRestantes = $totalHoras % $horasPorDia;

            return [
                'dias' => $dias,
                'horas' => $horasRestantes
            ];
        }

        function adicionarDiasUteis($dataInicio, $dias, $horas)
        {
            $data = new DateTime($dataInicio);
            $diasAdicionados = 0;

            while ($diasAdicionados < $dias) {
                $data->modify('+1 day');
                if ($data->format('N') < 6) { // 1 = Segunda-feira, ..., 7 = Domingo
                    $diasAdicionados++;
                }
            }

            // Adicionar horas restantes
            $data->modify("+$horas hours");

            return $data->format('d-m-Y');
        }

        function calcularDataConclusao($dataPedido, $diasNoFluxo)
        {
            $dataPedido = new DateTime($dataPedido);
            $dias = $diasNoFluxo['dias'];
            $horas = $diasNoFluxo['horas'];

            // Adicionar dias úteis e horas restantes
            $dataConclusao = adicionarDiasUteis($dataPedido->format('d-m-Y'), $dias, $horas);

            return $dataConclusao;
        }

        function calcularDiasFaltantes($dataConclusao)
        {
            $hoje = new DateTime();
            $dataConclusao = new DateTime($dataConclusao);

            $interval = $hoje->diff($dataConclusao);
            $diasFaltantes = $interval->days;

            if ($hoje > $dataConclusao) {
                $diasFaltantes = -$diasFaltantes;
            }

            return $diasFaltantes;
        }



        $pedidoId = $_GET['id'];
        $sql = "
            SELECT 
                        p.pedido AS pedido, 
                        p.lote AS lote, 
                        p.fluxo AS fluxo, 
                        p.cdgprod AS cdgprod, 
                        p.qtds AS qtds, 
                        p.dr AS dr,
                        p.pac AS pac,
                        p.descricao AS descricao, 
                        p.dt AS dataPedido, 
                        fx.nome AS NomeFluxo,
                          GROUP_CONCAT(CONCAT(s.ordem, ':', s.idsetor, ':', s.duracao) ORDER BY s.ordem ASC SEPARATOR ';') AS etapas
            FROM pedidos AS p
            JOIN fluxo fx ON p.fluxo = fx.id
            LEFT JOIN fluxo_setor s ON p.fluxo = s.idfluxo
            WHERE p.id='" . mysqli_real_escape_string($conn, $pedidoId) . "'
            GROUP BY p.pedido;
        ";

        $ret = mysqli_query($conn, $sql);

        if ($row = mysqli_fetch_array($ret)) {
            $numPed = $row['pedido'];
            $fluxo = $row['fluxo'];
            $NomeFluxo = $row['NomeFluxo'];
            $lote = $row["lote"];
            $cdgprod = $row["cdgprod"];
            $qtds = $row["qtds"];
            $descricao = $row["descricao"];
            $dataPedido = $row['dataPedido'];

            // Calcular os dias e horas no fluxo
            $diasFuturos = calcularDiasNoFluxo($conn, $fluxo);
            $dataConclusao = calcularDataConclusao($dataPedido, $diasFuturos);

            // Calcular os dias faltantes
            $diasFaltantes = calcularDiasFaltantes($dataConclusao);

            // Status baseado em dias para produzir
            $diasparaproduzir = $diasFuturos['dias'];

            if ($diasparaproduzir < $diasFaltantes) {
                $statusPrevio = "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>";
            } else {
                $statusPrevio = "<span class='badge badge-secondary'><b> NORMAL </b></span>";
            }

            $statusEntrega = $diasFaltantes <= 0 ? '<b class="text-danger"> Data de entrega excedida! </b>' : $diasFaltantes . ' dias faltantes';
            $diasNoFluxo = $diasFuturos['dias'] . " dias e " . $diasFuturos['horas'] . " horas";

            // Processar as etapas
            $etapas = explode(';', $row['etapas']);
            $etapasProcessadas = [];
            foreach ($etapas as $etapa) {
                list($ordem, $idetapa, $duracao) = explode(':', $etapa);
                $etapasProcessadas[] = [
                    'ordem' => $ordem,
                    'idetapa' => $idetapa,
                    'duracao' => $duracao
                ];
            }

            $hoje = date('d/m/Y');

  /*           // Exibir as informações no HTML
            echo "<h3>Pedido: $numPed</h3>";
            echo "<p>Fluxo: {$row['NomeFluxo']} ($fluxo)</p>";
            echo "<p>Lote: $lote</p>";
            echo "<p>Código do Produto: $cdgprod</p>";
            echo "<p>Quantidade: $qtds</p>";
            echo "<p>Descrição: $descricao</p>";
            echo "<p>Status: $statusPrevio</p>";
            echo "<p>Dias Faltantes: $statusEntrega</p>";
            echo "<p>Dias no Fluxo: $diasNoFluxo</p>";
            echo "<p>Data de Entrega: $dataConclusao</p>";
            echo "<p>Hoje: $hoje</p>";
            echo "<p>Data Pedido: $dataPedido</p>";

            // Exibir etapas
            echo "<h4>Etapas do Fluxo</h4>";
            echo "<ul>";
            foreach ($etapasProcessadas as $etapa) {
                echo "<li>Ordem: " . $etapa['ordem'] . " - Etapa ID: " . $etapa['idetapa'] . " - Duração: " . $etapa['duracao'] . " horas</li>";
            } */
            echo "</ul>";
        ?>

            <div id="main">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        }
                    }
                    ?>
                </div>

                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm" id="titulo-pag">
                            <div class="d-flex">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <a class='button-back button-back-dark p-0 m-0 pt-2' href="opplanejamento"><i class='fas fa-chevron-left fa-2x'></i></a>
                                    </div>
                                </div>
                                <div class="col-sm-8 pt-2 row-padding-2">
                                    <div class="row px-3" style="color: #fff">
                                        <h2>Modalidade: <?php echo $NomeFluxo ?> - Ped: <?php echo $numPed; ?></h2>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="row">
                                <div class="col div">
                                    <div class="row my-2">
                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="text-muted">Dados do Pedido</h6>
                                                </div>
                                                <div class="card-body">
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md">
                                                                    <div class="content-panel">
                                                                        <div class="row py-2">
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Nº Ped</b></label>
                                                                                <small><?php echo $row['pedido']; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Dr(a)</b></label>
                                                                                <small><?php echo $row['dr']; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Pac</b></label>
                                                                                <small><?php echo $row['pac']; ?></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row py-2">
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Lote</b></label>
                                                                                <small><?php echo $row['lote']; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Produto</b></label>
                                                                                <small><?php echo $NomeFluxo; ?></small> <!-- Aqui exibimos o nome do fluxo -->
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Dias p/ Produzir</b></label>
                                                                                <small> <?php echo $diasNoFluxo ?> dias </small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h6 class="text-muted">Datas Importantes</h6>
                                                </div>
                                                <div class="card-body">
                                                    <section id="main-content">
                                                        <section class="wrapper">
                                                            <div class="row">
                                                                <div class="col-md">
                                                                    <div class="content-panel">
                                                                        <div class="row py-2">
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Dt Entrega (Após Aceite)</b></label>
                                                                                <small><?php echo $dataConclusao; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Dias para Entrega</b></label>
                                                                                <small><?php echo $diasFaltantes; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Duração do Modalidade</b></label>
                                                                                <small> <?php echo $diasNoFluxo ?></small>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row py-2">
                                                                            <div class="col d-flex justify-content-center">
                                                                                <?php echo $statusPrevio; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </section>
                                                    </section>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="content-panel">
                                                <table id="tablePedido" class="table table-striped table-advance table-hover">

                                                    <thead>
                                                        <tr class="bg-secondary text-white">
                                                            <th><b>#</b></th>
                                                            <th><b>Etapa</b></th>
                                                            <th><b>Dt Produção</b></th>
                                                            <th class="text-center"><b>Status</b></th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    

                                                        <?php
                                                        $sql = "
                                                        SELECT 
                                                            ef.id AS idEtapaFluxo,
                                                            ef.ordem AS ordem,
                                                            e.id AS idEtapa,
                                                            e.nome AS nomeEtapa,
                                                            s.nome AS nomeStatus,
                                                            s.id AS idStatus,
                                                            s.cor AS corStatus,
                                                            ef.duracao AS duracaoEtapa
                                                        FROM etapa_fluxo AS ef
                                                        JOIN etapa AS e ON ef.idetapa = e.id
                                                        LEFT JOIN statusetapa AS s ON ef.idetapa = s.id
                                                        WHERE ef.idfluxo = $fluxo
                                                        ORDER BY ef.ordem ASC;
                                                    ";

                                                        $ret = mysqli_query($conn, $sql);

                                                        // Inicializa a data de produção a partir da data do pedido
                                                        $pedidoSql = "SELECT dt FROM pedidos WHERE id = $pedidoId";
                                                        $pedidoRet = mysqli_query($conn, $pedidoSql);
                                                        $pedidoRow = mysqli_fetch_array($pedidoRet);
                                                        $dataPedido = new DateTime($pedidoRow['dt']);

                                                        // Variável para armazenar a data de conclusão da etapa anterior
                                                        $dataConclusaoAnterior = clone $dataPedido;

                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $idEtapaFluxo = $row["idEtapaFluxo"];
                                                            $ordem = $row["ordem"];
                                                            $nomeEtapa = $row["nomeEtapa"];
                                                            $idEtapa = $row["idEtapa"];
                                                            $nomeStatus = $row["nomeStatus"];
                                                            $idStatus = $row["idStatus"];
                                                            $corStatus = $row["corStatus"];
                                                            $duracaoEtapa = $row["duracaoEtapa"];

                                                            // Define a data de referência para a etapa
                                                            $dataConclusao = clone $dataConclusaoAnterior;

                                                            // Adiciona a duração da etapa considerando o horário de expediente
                                                            $horasRestantes = $duracaoEtapa;
                                                            while ($horasRestantes > 0) {
                                                                $horaAtual = (int)$dataConclusao->format('H');
                                                                $minutoAtual = (int)$dataConclusao->format('i');
                                                                $horasPorDia = 10 - $horaAtual; // 8h às 18h, 1h de almoço

                                                                if ($horaAtual < 8) {
                                                                    $horasPorDia = 10;
                                                                }

                                                                if ($horasRestantes <= $horasPorDia) {
                                                                    $dataConclusao->modify("+$horasRestantes hours");
                                                                    $horasRestantes = 0;
                                                                } else {
                                                                    $horasRestantes -= $horasPorDia;
                                                                    $dataConclusao->modify('+1 day');
                                                                    if ($dataConclusao->format('N') >= 6) {
                                                                        // Pular fins de semana
                                                                        $dataConclusao->modify('+2 days');
                                                                    }
                                                                    $dataConclusao->setTime(8, 0); // Início do expediente no novo dia
                                                                }
                                                            }

                                                            // Atualiza a data de conclusão da etapa anterior
                                                            $dataConclusaoAnterior = clone $dataConclusao;

                                                            $dt = $dataConclusao->format('d-m-Y');
                                                            $status = "";

                                                            $hojeDate = new DateTime();
                                                            $hojeMaisUm = clone $hojeDate;
                                                            $hojeMaisUm->modify('+1 day');

                                                            if (($hojeDate->format('d-m-Y') == $dataConclusao->format('d-m-Y')) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                                $color = "text-orange";
                                                                $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                            } elseif (($hojeDate > $dataConclusao) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                                $color = "text-danger";
                                                                $i = '';
                                                            } elseif ($hojeMaisUm->format('d-m-Y') == $dataConclusao->format('d-m-Y')) {
                                                                $color = "text-warning";
                                                                $i = '<span class="badge bg-warning text-dark mx-2">Amanhã!</span>';
                                                            } elseif (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) {
                                                                $color = "text-success";
                                                                $i = '';
                                                            } else {
                                                                $color = "";
                                                                $i = '';
                                                            }   
                                                        ?>
                                                             <tr>
                                                                <td><?php echo $ordem; ?></td>
                                                                <td><?php echo $nomeEtapa; ?></td>
                                                                <td class="<?php echo $color; ?>"><b><?php echo $dt . $i; ?></b></td>
                                                                <td class="text-center" style="color: <?php echo $corStatus; ?>;"><b><?php echo $nomeStatus; ?></b></td>

                                                                <td class="text-center">
                                                                    <div class="d-flex justify-content-center">

                                                                        <?php if (($idStatus == 1) || ($idStatus == 7) || ($idStatus == 3) || ($idStatus == 9)) { ?>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idEtapaFluxo; ?>&a=play&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-info btn-sm"><i class="fas fa-play fa-1x"></i> </a>
                                                                        <?php } ?>

                                                                        <?php if (($idStatus == 2) || ($idStatus == 8)) { ?>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idEtapaFluxo; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idEtapaFluxo; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a>
                                                                        <?php } ?>

                                                                        <?php if (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) { ?>
                                                                            <a href="#" class="btn text-success btn-sm"><i class="fas fa-check-square fa-1x"></i></a>
                                                                        <?php } ?>

                                                                        <?php if (($idStatus == 6)) { ?>
                                                                            <a href="#" class="btn text-danger btn-sm"><i class="fas fa-times-circle fa-1x"></i></a>
                                                                        <?php } ?>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
    <?php
            include_once 'php/footer_updateprop.php';
        }
    } else {

        header("location: ../index");
        exit();
    }
    ?>