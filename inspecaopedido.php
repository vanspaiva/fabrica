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


            if ($diasparaproduzir < 20) {
                $statusPrevio = "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>";
            } else {
                $statusPrevio = "<span class='badge badge-secondary'><b> NORMAL </b></span>";
            }
            $diasFaltantes = diasFaltandoParaData($row['dataEntrega']);
            $diasFaltantesNumber = diasFaltandoParaData($row['dataEntrega']);

            if ($diasFaltantes <= 0) {
                $diasFaltantes = '<b class="text-danger"> Data de entrega excedida! </b>';
            } else {
                $diasFaltantes = $diasFaltantes . ' dias';
            }

            $diasFuturosNumber = diasDentroFluxo($conn, $fluxo);
            $diasFuturos = diasDentroFluxo($conn, $fluxo) . " dias";

            $hoje = hoje();
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
                                                                                <small><?php echo $row['produto']; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Dias p/ Produzir</b></label>
                                                                                <small><?php echo $row['diasparaproduzir']; ?> dias </small>
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
                                                                                <small><?php echo dateFormatByHifen($row['dataEntrega']); ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                                <label for=""><b>Dias para Entrega</b></label>
                                                                                <small><?php echo $diasFaltantes; ?></small>
                                                                            </div>
                                                                            <div class="col d-flex" style="flex-direction: column;">
                                                                                <label for=""><b>Duração do Modalidade</b></label>
                                                                                <small><?php echo $diasFuturos; ?></small>
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
                                                        WHERE pd.id = $pedidoId 
                                                        AND r.idEtapa IN (31,33,35,51)
                                                        ORDER BY r.numOrdem ASC;";

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

                                                            // $hoje = '2024-06-23';
                                                            $dtRefDate = new DateTime($dtRef);
                                                            $hojeDate = new DateTime($hoje);
                                                            // Adiciona um dia à data de hoje
                                                            $hojeMaisUm = clone $hojeDate;
                                                            $hojeMaisUm->modify('+1 day');


                                                            if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                                $color = "text-orange";
                                                                $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                            } elseif (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
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
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=aprov&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="fas fa-thumbs-up fa-1x"></i></a>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=reprov&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-danger btn-sm"><i class="fas fa-thumbs-down fa-1x"></i></a>
                                                                            <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                            <!-- <a href="atvd?idPed=<?php echo $pedidoId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a> -->
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