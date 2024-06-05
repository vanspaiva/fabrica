<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Caso editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Caso foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>Configurações de Cadastro</b></h5>
                                <small class="text-muted">Configurações gerais do sistema</small>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md container-fluid">

                                            <!-- Etapas -->
                                            <div class="row w-100 p-3 rounded my-1 d-flex justify-content-center">
                                                <div class="col-6">
                                                    <div class="btn btn-light d-flex justify-content-between p-2 align-items-center shadow border">
                                                        <h5 class="text-fab"><b>Etapas OP</b></h5>
                                                        <a href="config_etapas" class="btn btn-fab"> > </a>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Fluxo -->
                                            <div class="row w-100 p-3 rounded my-1 d-flex justify-content-center">
                                                <div class="col-6">
                                                    <div class="btn btn-light d-flex justify-content-between p-2 align-items-center shadow border">
                                                        <h5 class="text-fab"><b>Fluxo OP</b></h5>
                                                        <a href="config_fluxo" class="btn btn-fab"> > </a>
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

            </div>
        </div>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>