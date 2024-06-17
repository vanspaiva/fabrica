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
    </style>

    <body class="bg-light text-dark">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
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
                                        <span class="text-muted text-small"><?php echo $_SESSION["userperm"]; ?></span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <?php
                    if ($_SESSION["userperm"] == 'Colaborador(a)') {
                    ?>

                        <?php include_once "botoes_colaborador.php"; ?>

                    <?php
                    }
                    ?>
                </div>

                <?php
                if (($_SESSION["userperm"] == 'Gestor(a)') || ($_SESSION["userperm"] == 'Administrador')) {
                ?>
                    <div class="row mb-4">
                        <!-- Módulo Ordem Produção -->
                        <div class="col-sm my-2">
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
                        <div class="col-sm my-2">
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
                        <div class="col-sm my-2">
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
                    </div>

                <?php
                }
                ?>

                <?php
                if ($_SESSION["userperm"] == 'Colaborador(a)') {
                ?>

                    <?php include_once "etapas_colaborador.php"; ?>

                <?php
                }
                ?>



                <div class="row d-flex justify-content-around align-items-start">
                    <?php
                    if (($_SESSION["userperm"] == 'Gestor(a)') || ($_SESSION["userperm"] == 'Administrador')) {

                        $contagemCriado = 0;
                        $contagemAndamento = 0;
                        $contagemPausado = 0;
                        $contagemConcluido = 0;
                        $contagemAbertas = 0;

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='CRIADO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemCriado++;
                        }

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='EM ANDAMENTO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemAndamento++;
                        }

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='PAUSADO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemPausado++;
                        }

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='CONCLUÍDO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemConcluido++;
                        }

                        $contagemAbertas = $contagemCriado + $contagemAndamento + $contagemPausado;

                    ?>
                        <!-- KPI's OP -->
                        <div class="col-sm my-1">
                            <div class="card border-left-primary shadow h-100 py-2 d-flex justify-content-center">
                                <div class="card-header">
                                    <span class="text-muted">KPI's OP</span>
                                    <!-- <small class="text-muted">(Mês: <?php echo $monthName = getMonthName($conn, getMonthNumber($conn, hoje()));  ?>)</small> -->
                                </div>
                                <div class="card-body d-flex justify-content-center" style="flex-direction: column;">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                CONCLUÍDOS</div>
                                            <div class="flex-dashed-line text-success"></div>
                                            <div class="h5 mb-0 font-weight-bold text-success"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                RETRABALHO</div>
                                            <div class="flex-dashed-line text-info"></div>
                                            <div class="h5 mb-0 font-weight-bold text-info"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                ATRASADOS</div>
                                            <div class="flex-dashed-line text-warning"></div>
                                            <div class="h5 mb-0 font-weight-bold text-warning"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                PAUSADOS</div>
                                            <div class="flex-dashed-line text-danger"></div>
                                            <div class="h5 mb-0 font-weight-bold text-danger"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- KPI's OM -->
                        <div class="col-sm my-1">
                            <div class="card border-left-primary shadow h-100 py-2 d-flex justify-content-center">
                                <div class="card-header">
                                    <span class="text-muted">KPI's OM</span>
                                    <!-- <small class="text-muted">(Mês: <?php echo $monthName = getMonthName($conn, getMonthNumber($conn, hoje()));  ?>)</small> -->
                                </div>
                                <div class="card-body d-flex justify-content-center" style="flex-direction: column;">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                CONCLUÍDOS</div>
                                            <div class="flex-dashed-line text-success"></div>
                                            <div class="h5 mb-0 font-weight-bold text-success"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                RETRABALHO</div>
                                            <div class="flex-dashed-line text-info"></div>
                                            <div class="h5 mb-0 font-weight-bold text-info"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                ATRASADOS</div>
                                            <div class="flex-dashed-line text-warning"></div>
                                            <div class="h5 mb-0 font-weight-bold text-warning"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                PAUSADOS</div>
                                            <div class="flex-dashed-line text-danger"></div>
                                            <div class="h5 mb-0 font-weight-bold text-danger"><?php echo "x"; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- KPI's OS -->
                        <div class="col-sm my-1">
                            <div class="card border-left-primary shadow py-2 d-flex justify-content-center">
                                <div class="card-header">
                                    <span class="text-muted">KPI's OS</span>
                                    <!-- <small class="text-muted">(Mês: <?php echo $monthName = getMonthName($conn, getMonthNumber($conn, hoje()));  ?>)</small> -->
                                </div>
                                <div class="card-body d-flex justify-content-center" style="flex-direction: column;">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                CONCLUÍDAS</div>
                                            <div class="flex-dashed-line text-success"></div>
                                            <div class="h5 mb-0 font-weight-bold text-success"><?php echo $contagemConcluido; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                ABERTAS</div>
                                            <div class="flex-dashed-line text-info"></div>
                                            <div class="h5 mb-0 font-weight-bold text-info"><?php echo $contagemCriado; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                FAZENDO</div>
                                            <div class="flex-dashed-line text-warning"></div>
                                            <div class="h5 mb-0 font-weight-bold text-warning"><?php echo $contagemAndamento; ?></div>
                                        </div>
                                    </div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2 d-flex justify-content-around align-items-center">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                PAUSADAS</div>
                                            <div class="flex-dashed-line text-danger"></div>
                                            <div class="h5 mb-0 font-weight-bold text-danger"><?php echo $contagemPausado; ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                </div>
            </div>




            <hr style="border-bottom: 1px solid #fff;">

        <?php
                    }
        ?>




    <?php

} else {
    header("location: login");
    exit();
}

    ?>