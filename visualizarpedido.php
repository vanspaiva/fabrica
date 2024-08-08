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

        $pedidoId = $_GET['id'];

        $sql = "SELECT p.pedido AS pedido, 
        p.lote AS lote, 
        p.fluxo AS fluxo, 
        p.diasparaproduzir AS diasparaproduzir, 
        p.cdgprod AS cdgprod, 
        p.qtds AS qtds, 
        p.descricao AS descricao, 
        p.dt AS dt,
        p.dataEntrega AS dataEntrega, 
        p.dr AS dr,
        p.pac  AS pac,
        p.produto  AS produto,
        fx.nome AS NomeFluxo 
        FROM pedidos AS p 
        JOIN fluxo fx ON p.fluxo = fx.id 
        WHERE p.id='" . $pedidoId . "';";

        $ret = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($ret)) {
            $numPed = $row['pedido'];
            $fluxo = $row['fluxo'];
            $NomeFluxo = $row['NomeFluxo'];
            $lote = $row["lote"];
            $diasparaproduzir = $row["diasparaproduzir"];
            $cdgprod = $row["cdgprod"];
            $qtds = $row["qtds"];
            $descricao = $row["descricao"];

            $dataOriginal = $row['dt'];
            $dataFormatada = new DateTime($dataOriginal);
            $dataFormatada = $dataFormatada->format('d-m-Y');

            // 2. Obter a Duração Total das Etapas para o Fluxo
            if ($fluxo) {
                $duracaoQuery = "
                SELECT SUM(duracao) AS duracaoTotal
                FROM etapa_fluxo
                WHERE idfluxo = '$fluxo'
            ";
                $duracaoResult = mysqli_query($conn, $duracaoQuery);
                $duracaoData = mysqli_fetch_assoc($duracaoResult);

                if ($duracaoData) {
                    $duracaoHoras = $duracaoData['duracaoTotal'];

                    $horasPorDia = 9;
                    $diasInteiros = floor($duracaoHoras / $horasPorDia);
                    $horasRestantes = $duracaoHoras % $horasPorDia;

                    $timestampPedido = strtotime($dataFormatada);
                    $diasUteisAdicionados = 0;

                    // Adicionar dias úteis
                    while ($diasUteisAdicionados < $diasInteiros) {
                        $timestampPedido += 24 * 3600;
                        $diaDaSemana = date('N', $timestampPedido);
                        if ($diaDaSemana < 6) { // Segunda a sexta
                            $diasUteisAdicionados++;
                        }
                    }

                    // Adicionar as horas restantes
                    $horaAtual = date('G', $timestampPedido); // Hora atual no dia
                    $horaFinal = $horaAtual + $horasRestantes;

                    if ($horaFinal > 18) { // Se ultrapassar 18h, mover para o próximo dia útil
                        $horaFinal -= 18; // Subtrai 18h para ajustar as horas restantes
                        do {
                            $timestampPedido += 24 * 3600;
                        } while (date('N', $timestampPedido) >= 6); // Pula fins de semana
                        $timestampPedido += $horaFinal * 3600; // Adiciona horas restantes do próximo dia
                    } else {
                        $timestampPedido += $horasRestantes * 3600; // Adiciona horas restantes ao mesmo dia
                    }

                    $dataProducao = date('Y-m-d', $timestampPedido);
                    $dataProducaoFormatada = date('d/m/Y', strtotime($dataProducao));

                    // Obter a data atual
                    $hoje = new DateTime();
                    $hojeFormatado = $hoje->format('Y-m-d');

                    // Calcular os dias restantes
                    $dataProducaoObj = new DateTime($dataProducao);
                    $intervalo = $hoje->diff($dataProducaoObj);
                    $diasRestantes = $intervalo->days;
                    $statusPrevio = ($hoje > $dataProducaoObj) ? "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>" : "<span class='badge badge-secondary'><b> NORMAL </b></span>";

                    echo "Dias Restantes para Produção: " . $diasRestantes . "<br>";
                    echo "Status: " . $statusPrevio;
                    echo "Data do Pedido: " . date('d/m/Y', strtotime($dataFormatada)) . "<br>";
                    echo "Duração Total para Produzir: " . $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas<br>";
                    echo "Data Prevista para Produção Completa: " . $dataProducaoFormatada;
                } else {
                    echo "Nenhuma duração encontrada para o fluxo especificado.";
                }
            }

            if ($diasInteiros < $dataProducaoFormatada) {
                $statusPrevio = "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>";
            } else {
                $statusPrevio = "<span class='badge badge-secondary'><b> NORMAL </b></span>";
            }

            if ($diasRestantes <= 0) {
                $diasRestantes = '<b class="text-danger"> Data de entrega excedida! </b>';
            } else {
                $diasRestantes = $diasRestantes . ' dias';
            }
            /*
        $diasFuturosNumber = diasDentroFluxo($conn, $fluxo);
        $diasFuturos = diasDentroFluxo($conn, $fluxo) . " dias"; */
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
                                                                                <small><?php echo $row['NomeFluxo']; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Data do Pedido</b></label>
                                                                                <small><?php echo $dataFormatada; ?></small>
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
                                                                                <label for=""><b>Data Prevista</b></label>
                                                                                <small><?php echo $dataProducaoFormatada ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Dias para Entrega</b></label>
                                                                                <small><?php echo $diasRestantes; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Tempo de Produção</b></label>
                                                                                <small><?php echo  $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas<br>"; ?></small>
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
                                                        $sql = "SELECT 
                                                        r.id AS idRealizacaoProducao,
                                                        r.numOrdem AS ordem,
                                                        r.dataRealizacao AS dt,
                                                        r.idEtapa AS idEtapa,
                                                        e.nome AS nomeEtapa,
                                                        s.nome AS nomeStatus,
                                                        s.id AS idStatus,
                                                        s.cor AS corStatus
                                                        FROM pedidos AS pd 
                                                        RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                        RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                        RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                        WHERE pd.id = $pedidoId ORDER BY r.numOrdem ASC;";

                                                        $ret = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            $idRealizacaoProducao = $row["idRealizacaoProducao"];
                                                            $ordem = $row["ordem"];
                                                            $nomeEtapa = $row["nomeEtapa"];
                                                            $idEtapa = $row["idEtapa"];
                                                            $nomeStatus = $row["nomeStatus"];
                                                            $idStatus = $row["idStatus"];
                                                            $corStatus = $row["corStatus"];
                                                            $dtRef = $row["dt"];
                                                            $dt = dateFormatByHifen($row["dt"]);
                                                            $status = "";

                                                            $hoje = new DateTime(); // Inicializando a data atual
                                                            $hojeDate = clone $hoje; // Clonando para usar mais tarde
                                                            $hojeMaisUm = clone $hoje;
                                                            $hojeMaisUm->modify('+1 day');

                                                            $dtRefDate = new DateTime($dtRef);

                                                            if (($dtRefDate == $hoje) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                                $color = "text-orange";
                                                                $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                            } elseif (($dtRefDate < $hoje) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                                $color = "text-danger";
                                                                $i = '';
                                                            } elseif ($dtRefDate == $hojeMaisUm) {
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
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=play&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-info btn-sm"><i class="fas fa-play fa-1x"></i> </a>
                                                                        <?php } ?>
                                                                        <?php if (($idStatus == 2) || ($idStatus == 8)) { ?>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a>
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
                                                            <!--  <td class="<?php echo $color; ?>"><b><?php echo $dt . $i; ?></b></td>
                                                            <td class="text-center" style="color: <?php echo $corStatus; ?>;"><b><?php echo $nomeStatus; ?></b></td> -->
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