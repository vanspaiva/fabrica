<?php

if (isset($_SESSION["useruid"])) {

    require_once("includes/functions.inc.php");
?>
    <style>
        .flex-dashed-line {
            flex-grow: 1;
            border-bottom: 2px dashed;
            height: 1px;
            margin: 0 8px;
        }
        .disabled-button {
            pointer-events: none;
            opacity: 0.5;        
        }
    </style>

    <body class="bg-light text-dark">

        <?php
            include_once 'php/navbar.php';
            include_once 'php/lateral-nav.php';

            if(($_SESSION['userperm']) == "Colaborador(a)" ) {
                $classe_css = "disabled-button";
            }
            else {
                $classe_css = null;
            }
            
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

        <div id="main">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm mt-2">
                        <div class="card shadow rounded p-4 h-100" style="border-top: #007A5A 7px solid;">
                            <!-- <h5 class="text-fab"><b>DASHBOARD</b></h5> -->
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <h5 class="txt-ciano-agiliza" style="font-weight: 400;">😄 Olá, <?php echo $_SESSION["userfirstname"]; ?>! Bem-vindo a <b style="font-weight: 700;">sua Dashboard </b></h5>

                                        <span class="text-muted text-small"><?php echo $_SESSION["userperm"] . " - " . $_SESSION["usernomedep"]; ?></span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Produção')) {
                    ?>

                        <?php include_once "botoes_colaborador.php"; ?>

                    <?php
                    }
                    ?>

<?php
                    if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Qualidade')) {
                    ?>

                        <?php include_once "botoes_colaborador_qualidade.php"; ?>

                    <?php
                    }
                    ?>

                </div>

                <?php
                if (($_SESSION["userperm"] == 'Gestor(a)') || ($_SESSION["userperm"] == 'Administrador')) {
                ?>
                    <div class="row mb-4">
                        <!-- Módulo Ordem Produção -->
                        <div class="col-md-6 my-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <h6 class=""><b>Módulo Ordem Produção</b></h6>
                                    </div>
                                    <hr>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="novaos?t=op" class="btn btn-info mx-1"><i class="fas fa-plus"></i> Nova OP </a>
                                            <a href="pcp" class="btn btn-outline-info mx-1" style="border-top: 6px #129aaf solid;"><i class="fas fa-users-cog"></i> PCP </a>
                                            <a href="opetapas" class="btn btn-outline-info mx-1" style="border-top: 6px #129aaf solid;"> <i class="fas fa-th-large"></i> Etapas</a>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">

                                            <a href="opplanejamento" class="btn btn-outline-info mx-1" style="border-top: 6px #129aaf solid;"> <i class="fas fa-th-list"></i> Planejamento da Produção</a>

                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <a href="acompanhamenetoetapas" class="btn btn-outline-info mx-1" style="border-top: 6px #129aaf solid;"> <i class="fas fa-stream"></i> Acompanhamento</a>
                                    </div>
                                </div>
                            </div>
                    </div>

                        <!-- Módulo Ordem Manutenção -->
                        <div class="col-md-6 my-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <h6 class=""><b>Módulo Ordem Manutenção</b></h6>
                                    </div>
                                    <hr>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="novaos?t=om" class="btn btn-success mx-1"><i class="fas fa-plus"></i> Nova OM </a>
                                            <a href="lista-om" class="btn btn-outline-success mx-1" style="border-top: 6px #28a745 solid;"> <i class="fas fa-list"></i> Lista de OM</a>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="atividades-om" class="btn btn-outline-success mx-1" style="border-top: 6px #28a745 solid;"> <i class="fas fa-thumbtack"></i> Quadro de Atividades</a>

                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="acompanhamentoom" class="btn btn-success mx-1"><i class="fas fa-users-cog"></i> Acompanhamento OM </a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Módulo Ordem Serviço -->
                        <div class="col-md-6 my-2">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <h6 class=""><b>Módulo Ordem Serviço</b></h6>
                                    </div>
                                    <hr>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="novaos?t=os" class="btn btn-fab mx-1"><i class="fas fa-plus"></i> Nova OS </a>
                                            <a href="lista-os" class="btn btn-outline-fab mx-1" style="border-top: 6px #007A5A solid;"> <i class="fas fa-list"></i> Lista de OS</a>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="atividades" class="btn btn-outline-fab mx-1" style="border-top: 6px #007A5A solid;"> <i class="fas fa-thumbtack"></i> Quadro de Atividades</a>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center my-1 py-1">
                                        <div class="d-flex justify-content-between px-2">
                                            <a href="acompanhamentoos" class="btn btn-outline-fab mx-1" style="border-top: 6px #007A5A solid;"><i class="fas fa-users-cog"></i> Acompanhamento OS </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                }
                ?>

                    <?= $_SESSION["userperm"] == 'Colaborador(a)' ? "<div class='row'>" : '' ?>
                    
                        <div class="col-md-6 my-2">
                                <div class="card border-left-primary shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <h6 class=""><b>Módulo Registros de Limpeza</b></h6>
                                        </div>
                                        <hr>
                                        <div class="row d-flex justify-content-center my-1 py-1">
                                            <div class="d-flex justify-content-between px-2">
                                                <a href="novoRegistro003" class="btn btn-info mx-1"><i class="fas fa-plus"></i> Nova RL </a>
                                                <a href="showForm003.php" class="btn btn-outline-info mx-1" style="border-top: 6px #129aaf solid;"> <i class="fas fa-list"></i> Lista de Registros</a>
                                            </div>
                                        </div>
                                        <div class="row d-flex justify-content-center my-1 py-1">
                                            <div class="d-flex justify-content-between px-2">
                                            <a href="showForm003Pendentes.php" class="btn btn-outline-info mx-1 <?php echo $classe_css; ?>" style="border-top: 6px #129aaf solid;">Registros Pendentes</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Módulo Manutenção e Limpeza Ar-condicionado -->
                                <div class="col-md-6 my-2">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body">
                                            <div class="row no-gutters align-items-center">
                                                <h6 class=""><b>Módulo Registro Manutenção e Limpeza Ar-condicionado</b></h6>
                                            </div>
                                            <hr>
                                            <div class="row d-flex justify-content-center my-1 py-1">
                                                <div class="d-flex justify-content-between px-2">
                                                    <a href="frm_inf_004" class="btn btn-success mx-1"><i class="fas fa-plus"></i> Novo ML</a>
                                                    <a href="lista-frm" class="btn btn-outline-success mx-1" style="border-top: 6px #28a745  solid;"> <i class="fas fa-list"></i> Lista de Registros</a>
                                                </div>
                                            </div>
                                            <div class="row d-flex justify-content-center my-1 py-1">
                                                <div class="d-flex justify-content-between px-2">
                                                    <a href="pendencia_frm" class="btn btn-outline-success mx-1" style="border-top: 6px #28a745  solid;"><i class="fas fa-users-cog"></i> Registros Pendentes</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                     <?= $_SESSION["userperm"] == 'Colaborador(a)' ? "</div>" : '' ?>
                     
                <?php
                if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Produção')) {
                ?>

                    <?php include_once "etapas_colaborador.php"; ?>

                <?php
                }
                ?>

                <?php
                if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Qualidade')) {
                ?>

                    <?php include_once "dash_colaborador_qualidade.php"; ?>

                <?php
                }
                ?>



                
            </div>


            



    <?php

} else {
    header("location: login");
    exit();
}

    ?>
 