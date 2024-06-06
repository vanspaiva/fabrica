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

            // $diasFaltantes = diasFaltandoParaData($row['dataEntrega']);
            $diasFaltantes = diasFaltandoParaData('2024-06-28');
            if ($diasFaltantes <= 0) {
                $diasFaltantes = '<b class="text-danger"> Atrasado! </b>';
            } else {
                $diasFaltantes = $diasFaltantes . ' dias';
            }

            $diasFuturos = diasDentroFluxo($conn, $fluxo) . " dias";

            if ($diasFuturos >= $diasFaltantes) {
                $statusPrevio = "<span class='alert alert-danger'><b class='text-danger'> ATRASADO </b></span>";
            } else {
                if ($diasFaltantes < 21) {
                    $statusPrevio = "<span class='alert alert-warning'><b class='text-warning'> POSSÍVEL ATRASO </b></span>";
                } else {
                    $statusPrevio = "<span class='alert alert-success'><b class='text-success'> DENTRO DO PRAZO </b></span>";
                }
            }

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
                                    <div class="col-5">
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
                                                                            <label for=""><b>Representante</b></label>
                                                                            <small><?php echo $row['rep']; ?></small>
                                                                        </div>
                                                                        <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                            <label for=""><b>Projetista</b></label>
                                                                            <small><?php echo $row['projetista']; ?></small>
                                                                        </div>
                                                                        <div class="col d-flex" style="flex-direction: column;">
                                                                            <label for=""><b>Produto</b></label>
                                                                            <small><?php echo $row['produto']; ?></small>
                                                                        </div>
                                                                    </div>
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
                                                                            <label for=""><b>Dias no Fluxo</b></label>
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
                                                                    <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updateos.inc.php" method="POST">
                                                                        <div class="form-row" hidden>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="pedidoId">ID</label>
                                                                                <input type="number" class="form-control" id="pedidoId" name="pedidoId" value="<?php echo $row['id']; ?>" required readonly>
                                                                                <small class="text-muted">ID não é editável</small>
                                                                            </div>
                                                                            <div class="form-group col-md">
                                                                                <label class="form-label text-black" for="user">User Responsável</label>
                                                                                <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                                            </div>
                                                                        </div>

                                                                        <div class="form-row">
                                                                            <div class="col form-group m-2">
                                                                                <label class="form-label text-black" for="fluxo">Fluxo (Pré definido)</label>
                                                                                <select class='form-control' name='fluxo' id='fluxo' required>
                                                                                    <option value="0">Escolha um fluxo</option>
                                                                                    <?php
                                                                                    $retStatus = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");
                                                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) { ?>
                                                                                        <option value="<?php echo $rowStatus['id']; ?>" <?php if ($fluxo == $rowStatus['id']) echo ' selected="selected"'; ?>><?php echo $rowStatus['nome']; ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                </select>
                                                                            </div>

                                                                            <div class="col form-group m-2">
                                                                                <label class="form-label text-black" for="entrega">Entrega Estimada</label>
                                                                                <input type="date" class="form-control" value="<?php echo $row['dataEntrega']; ?>">
                                                                            </div>

                                                                        </div>


                                                                        <div class="d-flex justify-content-end pt-4">
                                                                            <button type="submit" name="update" id="update" class="btn btn-fab btn-sm">Enviar</button>
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