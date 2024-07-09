<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
    $user = $_SESSION["useruid"];
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    $qtdAtrasados = countEtapasAtrasadas($conn);
    $qtdHoje = countEtapasHoje($conn);
    $qtdAmanha = countEtapasAmanha($conn);
    $qtdFazendo = countEtapasFazendo($conn);
    $qtdPausado = countEtapasPausado($conn);

?>
    <style>
        .hidden {
            display: none;
        }

        .active {
            display: block;
        }
    </style>


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
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Ordem de Serviço foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço foi criada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Ordem de Serviço!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>OP - Acompanhamento</b></h5>
                                <small class="text-muted">Acompanhamento das Atividades os Colaboradores</small>
                            </div>
                            <div class="col-sm d-flex justify-content-around">
                                <span class="badge badge-light border shadow-sm px-2"><h6 style="color: #d54e5b;"><b>Atrasados</b>: <?php echo $qtdAtrasados; ?></h6></span>
                                <span class="badge badge-light border shadow-sm px-2"><h6 class="text-fab"> <b>Hoje </b>: <?php echo $qtdHoje; ?></h6></span>
                                <span class="badge badge-light border shadow-sm px-2"><h6 class="text-info"><b> Próximos </b>:<?php echo $qtdAmanha; ?></h6></span>
                                <span class="badge badge-light border shadow-sm px-2"><h6 class="text-warning"><b> Fazendo </b>:<?php echo $qtdFazendo; ?></h6></span>
                                <span class="badge badge-light border shadow-sm px-2"><h6 class="text-orange"><b> Pausado </b>:<?php echo $qtdPausado; ?></h6></span>
                            </div>
                        </div>
                        <hr>
                        <div class="content-panel">
                            <div class="row">
                                <!-- Coluna Tarefas -->
                                <div class="col-12 col-sm">
                                    <div class="row" style="overflow-x: scroll;">
                                        <div class="col">
                                            <div class="">
                                                <h6 style="color: #d54e5b;"><b>Atrasados</b> (<?php echo $qtdAtrasados; ?>)</h6>
                                                <a href="exportlista?l=atrasados"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> baixar lista</button></a>
                                            </div>
                                            <div class="card-body">
                                                <?php $arrayEtapasAtrasadas = arrayEtapasAtrasadas($conn); ?>
                                                <table id="tAtrasado" class="table table-striped table-hover">
                                                    <thead class="text-white" style="background-color: #d54e5b;">
                                                        <tr>
                                                            <th><b>Num Pedido</b></th>
                                                            <th><b>Modalidade</b></th>
                                                            <th><b>Etapa</b></th>
                                                            <th><b>Status</b></th>
                                                            <th><b>Dt</b></th>
                                                            <th><b>Dias em Atraso</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        foreach ($arrayEtapasAtrasadas as $key => $value) {

                                                            $value = intval($value);

                                                            $sql = "SELECT 
                                                                    r.id AS idRealizacaoProducao,
                                                                    r.numOrdem AS ordem,
                                                                    r.dataRealizacao AS dt,
                                                                    r.idEtapa AS idEtapa,
                                                                    e.nome AS nomeEtapa,
                                                                    s.nome AS nomeStatus,
                                                                    s.id AS idStatus,
                                                                    s.cor AS corStatus,
                                                                    pd.pedido AS numPed,
                                                                    pd.id AS idPed,
                                                                    f.nome AS nomeFluxo
                                                                    FROM pedidos AS pd 
                                                                    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                                    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                                    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                                    RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                                                                    WHERE r.id = $value;";

                                                            // echo $sql;
                                                            // exit();

                                                            $ret = mysqli_query($conn, $sql);
                                                            if ($ret) {
                                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                                    $numPed = $row["numPed"];
                                                                    $pedId = $row["idPed"];
                                                                    $nomeFluxo = $row["nomeFluxo"];
                                                                    $nomeEtapa = $row["nomeEtapa"];
                                                                    $nomeStatus = $row["nomeStatus"];
                                                                    $corStatus = $row["corStatus"];
                                                                    $data = dateFormatByHifen($row["dt"]);
                                                                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);
                                                        ?>
                                                                    <tr>
                                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                                        <td class="text-center" style="font-size:  0.8rem;"><?php echo $diasEmAtraso; ?></td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row" style="overflow-x: scroll;">
                                        <div class="col">
                                            <div class="">
                                                
                                                <h6 class="text-fab"> <b>Hoje </b> (<?php echo $qtdHoje; ?>)</h6>
                                                <a href="exportlista?l=hoje"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> baixar lista</button></a>
                                            </div>
                                            <div class="card-body">
                                                <?php $arrayEtapasHoje = arrayEtapasHoje($conn); ?>
                                                <table id="tHoje" class="table table-striped table-hover">
                                                    <thead class="bg-fab text-white">
                                                        <tr>
                                                            <th><b>Num Pedido</b></th>
                                                            <th><b>Modalidade</b></th>
                                                            <th><b>Etapa</b></th>
                                                            <th><b>Status</b></th>
                                                            <th><b>Dt</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        foreach ($arrayEtapasHoje as $key => $value) {

                                                            $value = intval($value);

                                                            $sql = "SELECT 
                                                                    r.id AS idRealizacaoProducao,
                                                                    r.numOrdem AS ordem,
                                                                    r.dataRealizacao AS dt,
                                                                    r.idEtapa AS idEtapa,
                                                                    e.nome AS nomeEtapa,
                                                                    s.nome AS nomeStatus,
                                                                    s.id AS idStatus,
                                                                    s.cor AS corStatus,
                                                                    pd.pedido AS numPed,
                                                                    pd.id AS idPed,
                                                                    f.nome AS nomeFluxo
                                                                    FROM pedidos AS pd 
                                                                    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                                    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                                    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                                    RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                                                                    WHERE r.id = $value;";

                                                            // echo $sql;
                                                            // exit();

                                                            $ret = mysqli_query($conn, $sql);
                                                            if ($ret) {
                                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                                    $numPed = $row["numPed"];
                                                                    $pedId = $row["idPed"];
                                                                    $nomeFluxo = $row["nomeFluxo"];
                                                                    $nomeEtapa = $row["nomeEtapa"];
                                                                    $nomeStatus = $row["nomeStatus"];
                                                                    $corStatus = $row["corStatus"];
                                                                    $data = dateFormatByHifen($row["dt"]);
                                                        ?>
                                                                    <tr>
                                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                    <hr>
                                    <div class="row" style="overflow-x: scroll;">
                                        <div class="col">
                                            <div class="">
                                                
                                                <h6 class="text-info"><b> Próximos </b> (<?php echo $qtdAmanha; ?>)</h6>
                                                <a href="exportlista?l=amanha"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> baixar lista</button></a>
                                            </div>
                                            <div class="card-body">
                                                <?php $arrayEtapasAmanha = arrayEtapasAmanha($conn); ?>
                                                <table id="tProximo" class="table table-striped table-hover">
                                                    <thead class="bg-info text-white">
                                                        <tr>
                                                            <th><b>Num Pedido</b></th>
                                                            <th><b>Modalidade</b></th>
                                                            <th><b>Etapa</b></th>
                                                            <th><b>Status</b></th>
                                                            <th><b>Dt</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        <?php
                                                        foreach ($arrayEtapasAmanha as $key => $value) {

                                                            $value = intval($value);

                                                            $sql = "SELECT 
                                                                    r.id AS idRealizacaoProducao,
                                                                    r.numOrdem AS ordem,
                                                                    r.dataRealizacao AS dt,
                                                                    r.idEtapa AS idEtapa,
                                                                    e.nome AS nomeEtapa,
                                                                    s.nome AS nomeStatus,
                                                                    s.id AS idStatus,
                                                                    s.cor AS corStatus,
                                                                    pd.pedido AS numPed,
                                                                    pd.id AS idPed,
                                                                    f.nome AS nomeFluxo
                                                                    FROM pedidos AS pd 
                                                                    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                                    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                                    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                                    RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                                                                    WHERE r.id = $value;";

                                                            // echo $sql;
                                                            // exit();

                                                            $ret = mysqli_query($conn, $sql);
                                                            if ($ret) {
                                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                                    $numPed = $row["numPed"];
                                                                    $pedId = $row["idPed"];
                                                                    $nomeFluxo = $row["nomeFluxo"];
                                                                    $nomeEtapa = $row["nomeEtapa"];
                                                                    $nomeStatus = $row["nomeStatus"];
                                                                    $corStatus = $row["corStatus"];
                                                                    $data = dateFormatByHifen($row["dt"]);
                                                        ?>
                                                                    <tr>
                                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }
                                                        ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>

                                </div>

                                <!-- Coluna Graficos -->
                                <div class="col-12 col-sm">
                                    <div class="row py-3" style="overflow-x: scroll;">
                                        <div class="">
                                            <h6 class="text-warning"><b> Fazendo </b> (<?php echo $qtdFazendo; ?>)</h6>
                                            <!-- <a href="exportlista?l=fazendo"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> baixar lista</button></a> -->
                                        </div>
                                        <div class="card-body">
                                            <?php $arrayEtapasFazendo = arrayEtapasFazendo($conn); ?>
                                            <table id="tFazendo" class="table table-striped table-hover">
                                                <thead class="bg-warning text-white">
                                                    <tr>
                                                        <th><b>Num Pedido</b></th>
                                                        <th><b>Etapa</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($arrayEtapasFazendo as $key => $value) {

                                                        $value = intval($value);

                                                        $sql = "SELECT 
                                                                    r.id AS idRealizacaoProducao,
                                                                    r.numOrdem AS ordem,
                                                                    r.dataRealizacao AS dt,
                                                                    r.idEtapa AS idEtapa,
                                                                    e.nome AS nomeEtapa,
                                                                    s.nome AS nomeStatus,
                                                                    s.id AS idStatus,
                                                                    s.cor AS corStatus,
                                                                    pd.pedido AS numPed,
                                                                    pd.id AS idPed,
                                                                    f.nome AS nomeFluxo
                                                                    FROM pedidos AS pd 
                                                                    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                                    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                                    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                                    RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                                                                    WHERE r.id = $value;";

                                                        // echo $sql;
                                                        // exit();

                                                        $ret = mysqli_query($conn, $sql);
                                                        if ($ret) {
                                                            while ($row = mysqli_fetch_assoc($ret)) {
                                                                $numPed = $row["numPed"];
                                                                $pedId = $row["idPed"];
                                                                $nomeFluxo = $row["nomeFluxo"];
                                                                $nomeEtapa = $row["nomeEtapa"];
                                                                $nomeStatus = $row["nomeStatus"];
                                                                $corStatus = $row["corStatus"];
                                                                $data = dateFormatByHifen($row["dt"]);
                                                    ?>
                                                                <tr>
                                                                    <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                                    <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row py-3" style="overflow-x: scroll;">
                                        <div class="">

                                            <h6 class="text-orange"><b> Pausado </b> (<?php echo $qtdPausado; ?>)</h6>
                                            <!-- <a href="exportlista?l=fazendo"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> baixar lista</button></a> -->
                                        </div>
                                        <div class="card-body">
                                            <?php $arrayEtapasPausado = arrayEtapasPausado($conn); ?>
                                            <table id="tPausado" class="table table-striped table-hover">
                                                <thead class="bg-orange text-white">
                                                    <tr>
                                                        <th><b>Num Pedido</b></th>
                                                        <th><b>Etapa</b></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <?php
                                                    foreach ($arrayEtapasPausado as $key => $value) {

                                                        $value = intval($value);

                                                        $sql = "SELECT 
                                                                    r.id AS idRealizacaoProducao,
                                                                    r.numOrdem AS ordem,
                                                                    r.dataRealizacao AS dt,
                                                                    r.idEtapa AS idEtapa,
                                                                    e.nome AS nomeEtapa,
                                                                    s.nome AS nomeStatus,
                                                                    s.id AS idStatus,
                                                                    s.cor AS corStatus,
                                                                    pd.pedido AS numPed,
                                                                    pd.id AS idPed,
                                                                    f.nome AS nomeFluxo
                                                                    FROM pedidos AS pd 
                                                                    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                                                                    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                                                                    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                                                                    RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                                                                    WHERE r.id = $value;";

                                                        // echo $sql;
                                                        // exit();

                                                        $ret = mysqli_query($conn, $sql);
                                                        if ($ret) {
                                                            while ($row = mysqli_fetch_assoc($ret)) {
                                                                $numPed = $row["numPed"];
                                                                $pedId = $row["idPed"];
                                                                $nomeFluxo = $row["nomeFluxo"];
                                                                $nomeEtapa = $row["nomeEtapa"];
                                                                $nomeStatus = $row["nomeStatus"];
                                                                $corStatus = $row["corStatus"];
                                                                $data = dateFormatByHifen($row["dt"]);
                                                    ?>
                                                                <tr>
                                                                    <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                                    <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                                </tr>
                                                    <?php
                                                            }
                                                        }
                                                    }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- <div class="py-2 mb-2">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-end align-items-center">
                                                <span class="btn badge badge-light text-fab border btn-sm mx-1 shadow-sm" id="btnEtapas">etapas</span>
                                                <span class="btn badge badge-light text-fab border btn-sm mx-1 shadow-sm" id="btnColaborador">colaborador</span>
                                            </div>
                                            <div class="card-body">
                                                <section id="sEtapas" class="active">
                                                    <h2>grafico etapas</h2>
                                                    
                                                </section>
                                                <section id="sColaborador" class="hidden">
                                                    <h2>grafico colaborador</h2>
                                                    
                                                </section>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="py-2 mb-2">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-end align-items-center">
                                                <h5 class="text-muted">Últimas Atividades</h5>
                                                <hr>
                                            </div>
                                            <div class="card-body">
                                                <?php
                                                $sql = "SELECT 
                                                l.id AS Id,
                                                l.data AS DataLog,
                                                l.hora AS HoraLog,
                                                u.usersName AS Responsavel,
                                                p.pedido AS numPedido,
                                                e.nome AS Etapa,
                                                s.nome AS Status,
                                                s.cor AS corStatus
                                                FROM log_atividades_producao AS l 
                                                JOIN realizacaoproducao AS r ON l.idRealizacaoProducao = r.id
                                                JOIN pedidos AS p ON r.idPedido = p.id
                                                JOIN etapa AS e ON l.idEtapa = e.id
                                                JOIN users AS u ON l.idUsuario = u.usersId
                                                JOIN statusetapa AS s ON l.idStatus = s.id
                                                ORDER BY id DESC
                                                LIMIT 3;";
                                                $ret = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($ret) == 0) {
                                                    echo "<p>Nenhuma atividade encontrada</p>";
                                                } else {
                                                    $rowCount = mysqli_num_rows($ret);
                                                    $currentRow = 0;

                                                    while ($row = mysqli_fetch_array($ret)) {

                                                        $Id = $row["Id"];
                                                        $DataLog = $row["DataLog"];
                                                        $HoraLog = $row["HoraLog"];
                                                        $Responsavel = getFirstAndLastName($row["Responsavel"]);
                                                        $numPedido = $row["numPedido"];
                                                        $Etapa = $row["Etapa"];
                                                        $Status = $row["Status"];
                                                        $corStatus = $row["corStatus"];

                                                        $data = dateFormatByHifen($DataLog);
                                                        $hora = hourFormat($HoraLog);
                                                        $horario = $data . " " . $hora;
                                                        $currentRow++;
                                                ?>
                                                        <div class="row d-flex justify-content-center align-items-center">
                                                            <div class="col-2 col-sm-2 d-flex justify-content-center">
                                                                <span class="btn btn-fab"> <?php echo $numPedido; ?> </span>
                                                            </div>
                                                            <div class="col d-flex justify-content-center" style="flex-direction: column;">
                                                                <h5 style="font-size: 1rem;" class="text-fab"><b><?php echo $Responsavel; ?></b></h5>
                                                                <h6 style="font-size: 0.8rem;"><?php echo $Etapa; ?> - <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $Status; ?></span></h6>
                                                            </div>

                                                            <div class="col-4 col-sm-4 d-flex justify-content-center" style="flex-direction: column;">
                                                                <small class="text-mute"><?php echo $data; ?></small>
                                                                <small class="text-mute"><?php echo $hora; ?></small>
                                                            </div>
                                                        </div>
                                                        <?php if ($currentRow != $rowCount) { ?>
                                                            <hr>
                                                        <?php } ?>
                                                <?php
                                                    }
                                                }
                                                ?>

                                            </div>
                                            <div class="card-footer">
                                                <span class="d-flex justify-content-center">
                                                    <a href="logproducao" class="text-fab">Ver mais</a>
                                                </span>
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

    </body>

    <?php include_once 'php/footer_index.php' ?>

    <script>
        $(document).ready(function() {
            $('#tAtrasado').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });

        });

        $(document).ready(function() {
            $('#tHoje').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });

        });

        $(document).ready(function() {
            $('#tProximo').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });

        });

        $(document).ready(function() {
            $('#tFazendo').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });

        });

        $(document).ready(function() {
            $('#tPausado').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });

        });
    </script>
    <script>
        document.getElementById('btnEtapas').addEventListener('click', function() {
            document.getElementById('sEtapas').classList.add('active');
            document.getElementById('sEtapas').classList.remove('hidden');
            document.getElementById('sColaborador').classList.add('hidden');
            document.getElementById('sColaborador').classList.remove('active');
        });

        document.getElementById('btnColaborador').addEventListener('click', function() {
            document.getElementById('sColaborador').classList.add('active');
            document.getElementById('sColaborador').classList.remove('hidden');
            document.getElementById('sEtapas').classList.add('hidden');
            document.getElementById('sEtapas').classList.remove('active');
        });
    </script>

<?php
} else {
    header("location: login");
    exit();
}
?>