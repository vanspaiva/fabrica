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
<hr style="border-bottom: 1px solid #fff;">

<?php
    }
?>