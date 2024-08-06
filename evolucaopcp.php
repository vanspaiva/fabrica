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
        $ret = mysqli_query($conn, "SELECT * FROM pedidos WHERE id='" . $pedidoId . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $numPed = $row['pedido'];
            $fluxo = $row['fluxo'];
            $lote = $row["lote"];
            $cdgprod = $row["cdgprod"];
            $qtds = $row["qtds"];
            $descricao = $row["descricao"];
            $dataPedido = $row['dt'];
            $sqlDuracao = "SELECT SUM(e.duracao) AS total_duracao
                   FROM etapa_fluxo e
                   WHERE e.idfluxo = $fluxo;";
            $retDuracao = mysqli_query($conn, $sqlDuracao);
            $rowDuracao = mysqli_fetch_assoc($retDuracao);
            $totalDuracaoHoras = isset($rowDuracao['total_duracao']) ? $rowDuracao['total_duracao'] : 0;
            // Converte duração em dias
            $totalDuracaoDias = floor($totalDuracaoHoras / 24);
            $dataAtual = date('d-m-Y');
            $dataEntregaFormatada = adicionarHorasUteis($dataAtual, $totalDuracaoHoras);
            $diasFuturos = calcularDiasNoFluxo($conn, $fluxo);
            $dataConclusao = calcularDataConclusao($dataPedido, $diasFuturos);
            // Calcular os dias faltantes
            $diasFaltantes = calcularDiasFaltantes($dataConclusao);
            // Status baseado em dias para produzir
            $diasparaproduzir = $diasFuturos['dias'];
            $statusEntrega = $diasFaltantes <= 0 ? '<b class="text-danger"> Data de entrega excedida! </b>' : $diasFaltantes . ' dias faltantes';
            $diasNoFluxo = $diasFuturos['dias'] . " dias e " . $diasFuturos['horas'] . " horas";

            if ($diasparaproduzir < $diasFaltantes) {
                $statusPrevio = "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>";
            } else {
                $statusPrevio = "<span class='badge badge-secondary'><b> NORMAL </b></span>";
            }
            $retDuracao = mysqli_query($conn, "SELECT COALESCE(SUM(e.duracao), 0) AS total_duracao FROM etapa_fluxo e WHERE e.idfluxo = $fluxo;");
            if ($rowDuracao = mysqli_fetch_array($retDuracao)) {
                $totalDuracaoHoras = $rowDuracao["total_duracao"];
            }
            if ($diasFaltantes <= 0) {
                $diasFaltantes = '<b class="text-danger"> Data de entrega excedida! </b>';
            } else {
                $diasFaltantes = $diasFaltantes . ' dias';
            }

            // if (($diasFuturosNumber >= $diasFaltantesNumber)){
            //     $statusPrevio = "<span class='alert alert-danger'><b class='text-danger'> ATRASADO </b></span>";
            // } else {
            //     if ($diasFaltantes < 21) {
            //         $statusPrevio = "<span class='alert alert-warning'><b class='text-warning'> POSSÍVEL ATRASO </b></span>";
            //     } else {
            //         $statusPrevio = "<span class='alert alert-success'><b class='text-success'> DENTRO DO PRAZO </b></span>";
            //     }
            // }
            $listaCdgs = explode("*", $cdgprod);
            $listaQtds = explode("*", $qtds);
            $listaDescricao = explode("*", $descricao);
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
                                        <button class='button-back button-back-dark p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-8 pt-2 row-padding-2">
                                    <div class="row px-3" style="color: #fff">
                                        <h2>Informações do Pedido - <?php echo $numPed; ?> </h2>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="div">
                                <div class="row">
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
                                                                            <?php
                                                                            // Consulta ao banco de dados para obter os fluxos ordenados por nome
                                                                            $retStatus = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");
                                                                            // Verifique se a consulta retornou resultados
                                                                            if ($retStatus) {
                                                                                while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                    $idFluxo = $rowStatus['id'];
                                                                                    $nomeFluxo = $rowStatus['nome'];
                                                                            ?>
                                                                                    <!-- Exibindo o nome do fluxo com base no ID -->
                                                                                    <small>
                                                                                        <value="<?php echo $idFluxo; ?>">
                                                                                            <?php if ($fluxo == $idFluxo) {
                                                                                                echo htmlspecialchars($nomeFluxo);
                                                                                            } ?>
                                                                                            </value>
                                                                                    </small>
                                                                            <?php
                                                                                }
                                                                            } else {
                                                                                echo "Erro na consulta: " . mysqli_error($conn);
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                        <div class="col d-flex" style="flex-direction: column;">
                                                                            <label for=""><b>Dias p/ Produzir</b></label>
                                                                            <small><?php echo $diasNoFluxo ?>
                                                                            </small>
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
                                                                            <label for=""><b>Dt Entrega (Após
                                                                                    Aceite)</b></label>
                                                                            <small><?php echo $dataEntregaFormatada; ?></small>
                                                                        </div>
                                                                        <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                            <label for=""><b>Dias para Entrega</b></label>
                                                                            <small><?php echo $diasFaltantes; ?></small>
                                                                        </div>
                                                                        <div class="col d-flex" style="flex-direction: column;">
                                                                            <label for=""><b>Duração do Modalidade</b></label>
                                                                            <small><?php echo $diasNoFluxo ?></small>
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
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-header">
                                                <h6 class="text-muted">Evolução para produção</h6>
                                            </div>
                                            <div class="card-body">
                                                <section id="main-content">
                                                    <section class="wrapper">
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="content-panel">
                                                                    <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/pcp.inc.php" method="POST">
                                                                        <div class="form-row" hidden>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="pedidoId">ID</label>
                                                                                <input type="number" class="form-control" id="pedidoId" name="pedidoId" value="<?php echo $row['id']; ?>" required readonly>
                                                                                <small class="text-muted">ID não é
                                                                                    editável</small>
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="user">User Responsável</label>
                                                                                <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-row">
                                                                            <div class="col form-group m-2">
                                                                                <label class="form-label text-black" for="fluxo">Modalidade</label>
                                                                                <select class='form-control' name='fluxo' id='fluxo' required>
                                                                                    <option value="">Escolha uma Modalidade
                                                                                    </option>
                                                                                    <?php
                                                                                    $retStatus = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");
                                                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) { ?>
                                                                                        <option value="<?php echo $rowStatus['id']; ?>" <?php if ($fluxo == $rowStatus['id']) echo ' selected="selected"'; ?>>
                                                                                            <?php echo $rowStatus['nome']; ?>
                                                                                        </option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col form-group m-2">
                                                                                <label class="form-label text-black" for="lote">Lote</label>
                                                                                <input type="text" class="form-control" id="lote" name="lote" value="<?php echo $row['lote']; ?>" required>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="form-row">
                                                                            <div class="col form-group m-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="radio" name="nacinter" id="nacinter1" value="nacional" required>
                                                                                    <label class="form-check-label" for="nacinter1">
                                                                                        Nacional
                                                                                    </label>
                                                                                </div>
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="radio" name="nacinter" id="nacinter2" value="internacional" required>
                                                                                    <label class="form-check-label" for="nacinter2">
                                                                                        Internacional
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col form-group m-2">
                                                                                <div class="form-check">
                                                                                    <input class="form-check-input" type="checkbox" value="1" id="taxa_extra" name="taxa_extra">
                                                                                    <label class="form-check-label" for="taxa_extra">
                                                                                        Taxa extra
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="d-flex justify-content-end pt-4">
                                                                            <button type="submit" name="update" id="update" class="btn btn-fab btn-sm">Gerar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </section>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--                                 <div class="row p-4">
                                    <div class="col p-2">
                                        <h5 class="alert alert-light text-center shadow">Produtos detalhados</h5>
                                        <div class="d-flex justify-content-center align-items-center">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th><b>CDG</b></th>
                                                        <th><b>DESCRIÇÃO</b></th>
                                                        <th><b>QTD</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($listaCdgs as $key => $cdg) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $listaCdgs[$key]; ?></td>
                                                            <td><?php echo $listaDescricao[$key]; ?></td>
                                                            <td><?php echo $listaQtds[$key]; ?></td>
                                                        </tr>
                                                    <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                            </div>-->
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