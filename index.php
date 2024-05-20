<?php ob_start();
include("php/head_index.php");

if (isset($_SESSION["useruid"])) {
?>

    <body class="bg-light text-dark">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div class="container-fluid">
                <div class="row d-flex justify-content-around align-items-center p-3 mb-3">
                    <div class="col-sm d-flex justify-content-center">
                        <a href="lista-os"><button class="btn btn-outline-fab"><i class="fas fa-list"></i> Lista OS</button></a>
                    </div>
                    <div class="col-sm d-flex justify-content-center">
                        <a href="novaos"><button class="btn btn-fab"><i class="fas fa-plus"></i> Abrir OS</button></a>
                    </div>
                    <div class="col-sm d-flex justify-content-center">
                        <a href="atividades"><button class="btn btn-outline-fab"><i class="fas fa-thumbtack"></i> Quadro de Atividades</button></a>
                    </div>
                </div>
                <div class="row d-flex justify-content-around align-items-center">
                    <?php
                    if (($_SESSION["userperm"] == 'Gestor(a)') || ($_SESSION["userperm"] == 'Administrador')) {

                        $contagem = 0;
                        $contagemAndamento = 0;
                        $contagemPausado = 0;

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='CRIADO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagem++;
                        }

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='EM ANDAMENTO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemAndamento++;
                        }

                        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE  osStatus='PAUSADO';");
                        while ($row = mysqli_fetch_array($ret)) {
                            $contagemPausado++;
                        }


                    ?>
                        <div class="col-sm-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Pedidos</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagem; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Em Andamento</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemAndamento; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Pausados</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $contagemPausado; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class='bi bi-collection fa-2x text-gray-300'></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                </div>
            </div>


            <div class="row p-4 d-flex justify-content-center">
                <div class="col">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <!--Casos Abertos, Casos Pendentes, Casos Finalizados e Casos Arquivados-->
                            <!--Tabs for large devices-->
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link active text-tab" id="pills-todos-tab" data-toggle="pill" href="#pills-todos" role="tab" aria-controls="pills-todos" aria-selected="true">Todos</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-andamento-tab" data-toggle="pill" href="#pills-andamento" role="tab" aria-controls="pills-andamento" aria-selected="true">Em Andamento</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-pausados-tab" data-toggle="pill" href="#pills-pausados" role="tab" aria-controls="pills-pausados" aria-selected="false">Pausados</a>
                                    </li>
                                    <li class="nav-item px-3" role="presentation">
                                        <a class="nav-link text-tab" id="pills-concluidos-tab" data-toggle="pill" href="#pills-concluidos" role="tab" aria-controls="pills-concluidos" aria-selected="false">Concluídos</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- Tabs for smaller devices -->
                            <div class="d-flex justify-content-center">
                                <ul class="nav nav-pills mb-3 " id="pills-tab-small" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center active text-tab" id="pills-todos-tab" data-toggle="pill" href="#pills-todos" role="tab" aria-controls="pills-todos" aria-selected="true"><i class="fas fa-pallet fa-2x"></i></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-andamento-tab" data-toggle="pill" href="#pills-andamento" role="tab" aria-controls="pills-andamento" aria-selected="true"><i class="fas fa-play-circle fa-2x"></i></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-pausados-tab" data-toggle="pill" href="#pills-pausados" role="tab" aria-controls="pills-pausados" aria-selected="false"><i class="fas fa-pause-circle fa-2x"></i></a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link d-flex justify-content-center text-tab" id="pills-concluidos-tab" data-toggle="pill" href="#pills-concluidos" role="tab" aria-controls="pills-concluidos" aria-selected="false"><i class="fas fa-check-circle fa-2x"></i></a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-todos" role="tabpanel" aria-labelledby="pills-todos-tab">
                                    <div class="row no-gutters align-items-center py-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                                Acompanhamento data entrega (TODOS ABERTOS)</div>
                                        </div>
                                    </div>
                                    <div class="row p-2 d-flex justify-content-center">
                                        <div class="content-panel">
                                            <table id="tableOs" class="table table-striped table-advance table-hover display responsive nowrap">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Status</th>
                                                        <th>Data Entrada</th>
                                                        <th>Produto</th>
                                                        <th>Tempo Restante</th>
                                                        <th>Data Entrega</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'db/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osStatus IN ('CRIADO', 'EM ANDAMENTO', 'PAUSADO');");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        //Data Entrada
                                                        $dataEHora = explode(" ", $row['osDtCriacao']);

                                                        $dataBD = $dataEHora[0];
                                                        $horaBD = $dataEHora[1];

                                                        $dataBD = explode("-", $dataBD);
                                                        $horaBD = explode(":", $horaBD);

                                                        $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                        $hora = $horaBD[0] . ":" . $horaBD[1];

                                                        //Data Entrega
                                                        if ($row['osDtEntregaReal'] == null) {
                                                            $dataVazia = true;
                                                            $temporestante = null;
                                                        } else {
                                                            $dataVazia = false;
                                                            $dataEHoraEntrega = explode(" ", $row['osDtEntregaReal']);

                                                            $dataBDEntrega = $dataEHoraEntrega[0];
                                                            $dataBDEntrega = explode("-", $dataBDEntrega);
                                                            $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                            //Tempo restante
                                                            $now = time(); // or your date as well
                                                            $your_date = strtotime($row['osDtEntregaReal']);
                                                            $datediff = $now - $your_date;

                                                            $temporestante = round($datediff / (60 * 60 * 24));
                                                            $temporestante = $temporestante * (-1);
                                                            $temporestante = $temporestante + 1;
                                                        }



                                                        //Id
                                                        $idOs = $row['osId'];

                                                        //Status
                                                        $status = $row['osStatus'];
                                                        if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                        } else if ($status == 'EM ANDAMENTO') {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                            $btn = $btn . '<a href="changestatus?id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                        } else if ($status == 'CONCLUÍDO') {
                                                            $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                            <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo substr($row['osDescricao'], 0, 20) . '...'; ?></td>
                                                            <td class="d-flex justify-content-center" <?php
                                                                                                        if ($temporestante == null) {
                                                                                                            echo '';
                                                                                                        } else {
                                                                                                            if ($temporestante <= 2) {
                                                                                                                echo 'style="color: red;"';
                                                                                                            } ?>><?php echo $temporestante . ' dias';
                                                                                                                } ?></td>
                                                            <td><?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo $dataEntrega;
                                                                } ?></td>
                                                            <td><?php echo $btn; ?></td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-andamento" role="tabpanel" aria-labelledby="pills-andamento-tab">
                                    <div class="row no-gutters align-items-center py-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                                Acompanhamento data entrega (EM ANDAMENTO)</div>
                                        </div>
                                    </div>
                                    <div class="row p-2 d-flex justify-content-center">
                                        <div class="content-panel">
                                            <table id="tableandamento" class="table table-striped table-advance table-hover display responsive nowrap">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Status</th>
                                                        <th>Data Entrada</th>
                                                        <th>Produto</th>
                                                        <th>Tempo Restante</th>
                                                        <th>Data Entrega</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'db/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osStatus IN ('EM ANDAMENTO');");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        //Data Entrada
                                                        $dataEHora = explode(" ", $row['osDtCriacao']);

                                                        $dataBD = $dataEHora[0];
                                                        $horaBD = $dataEHora[1];

                                                        $dataBD = explode("-", $dataBD);
                                                        $horaBD = explode(":", $horaBD);

                                                        $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                        $hora = $horaBD[0] . ":" . $horaBD[1];

                                                        //Data Entrega
                                                        if ($row['osDtEntregaReal'] == null) {
                                                            $dataVazia = true;
                                                            $temporestante = null;
                                                        } else {
                                                            $dataVazia = false;
                                                            $dataEHoraEntrega = explode(" ", $row['osDtEntregaReal']);

                                                            $dataBDEntrega = $dataEHoraEntrega[0];
                                                            $dataBDEntrega = explode("-", $dataBDEntrega);
                                                            $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                            //Tempo restante
                                                            $now = time(); // or your date as well
                                                            $your_date = strtotime($row['osDtEntregaReal']);
                                                            $datediff = $now - $your_date;

                                                            $temporestante = round($datediff / (60 * 60 * 24));
                                                            $temporestante = $temporestante * (-1);
                                                            $temporestante = $temporestante + 1;
                                                        }



                                                        //Id
                                                        $idOs = $row['osId'];

                                                        //Status
                                                        $status = $row['osStatus'];
                                                        if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                        } else if ($status == 'EM ANDAMENTO') {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                            $btn = $btn . '<a href="changestatus?id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                        } else if ($status == 'CONCLUÍDO') {
                                                            $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                            <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo substr($row['osDescricao'], 1, 20) . '...'; ?></td>
                                                            <td class="d-flex justify-content-center" <?php
                                                                                                        if ($temporestante == null) {
                                                                                                            echo '';
                                                                                                        } else {
                                                                                                            if ($temporestante <= 2) {
                                                                                                                echo 'style="color: red;"';
                                                                                                            } ?>><?php echo $temporestante . ' dias';
                                                                                                                } ?></td>
                                                            <td><?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo $dataEntrega;
                                                                } ?></td>
                                                            <td><?php echo $btn; ?></td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-pausados" role="tabpanel" aria-labelledby="pills-pausados-tab">
                                    <div class="row no-gutters align-items-center py-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                                Acompanhamento data entrega (PAUSADOS)</div>
                                        </div>
                                    </div>
                                    <div class="row p-2 d-flex justify-content-center">
                                        <div class="content-panel">
                                            <table id="tablepausado" class="table table-striped table-advance table-hover display responsive nowrap">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Status</th>
                                                        <th>Data Entrada</th>
                                                        <th>Produto</th>
                                                        <th>Tempo Restante</th>
                                                        <th>Data Entrega</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'db/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osStatus IN ('PAUSADO');");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        //Data Entrada
                                                        $dataEHora = explode(" ", $row['osDtCriacao']);

                                                        $dataBD = $dataEHora[0];
                                                        $horaBD = $dataEHora[1];

                                                        $dataBD = explode("-", $dataBD);
                                                        $horaBD = explode(":", $horaBD);

                                                        $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                        $hora = $horaBD[0] . ":" . $horaBD[1];

                                                        //Data Entrega
                                                        if ($row['osDtEntregaReal'] == null) {
                                                            $dataVazia = true;
                                                            $temporestante = null;
                                                        } else {
                                                            $dataVazia = false;
                                                            $dataEHoraEntrega = explode(" ", $row['osDtEntregaReal']);

                                                            $dataBDEntrega = $dataEHoraEntrega[0];
                                                            $dataBDEntrega = explode("-", $dataBDEntrega);
                                                            $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                            //Tempo restante
                                                            $now = time(); // or your date as well
                                                            $your_date = strtotime($row['osDtEntregaReal']);
                                                            $datediff = $now - $your_date;

                                                            $temporestante = round($datediff / (60 * 60 * 24));
                                                            $temporestante = $temporestante * (-1);
                                                            $temporestante = $temporestante + 1;
                                                        }



                                                        //Id
                                                        $idOs = $row['osId'];

                                                        //Status
                                                        $status = $row['osStatus'];
                                                        if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                        } else if ($status == 'EM ANDAMENTO') {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                            $btn = $btn . '<a href="changestatus?id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                        } else if ($status == 'CONCLUÍDO') {
                                                            $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                            <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo substr($row['osDescricao'], 1, 20) . '...'; ?></td>
                                                            <td class="d-flex justify-content-center" <?php
                                                                                                        if ($temporestante == null) {
                                                                                                            echo '';
                                                                                                        } else {
                                                                                                            if ($temporestante <= 2) {
                                                                                                                echo 'style="color: red;"';
                                                                                                            } ?>><?php echo $temporestante . ' dias';
                                                                                                                } ?></td>
                                                            <td><?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo $dataEntrega;
                                                                } ?></td>
                                                            <td><?php echo $btn; ?></td>
                                                        </tr>
                                                    <?php
                                                    } ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="pills-concluidos" role="tabpanel" aria-labelledby="pills-concluidos-tab">
                                    <div class="row no-gutters align-items-center py-2">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                                CONCLUÍDOS</div>
                                        </div>
                                    </div>
                                    <div class="row p-2 d-flex justify-content-center">
                                        <div class="content-panel">
                                            <table id="tableconcluido" class="table table-striped table-advance table-hover display responsive nowrap">

                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Status</th>
                                                        <th>Data Entrada</th>
                                                        <th>Produto</th>
                                                        <th>Tempo Restante</th>
                                                        <th>Data Entrega</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    require_once 'db/dbh.inc.php';
                                                    $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osStatus IN ('CONCLUÍDO');");
                                                    while ($row = mysqli_fetch_array($ret)) {
                                                        //Data Entrada
                                                        $dataEHora = explode(" ", $row['osDtCriacao']);

                                                        $dataBD = $dataEHora[0];
                                                        $horaBD = $dataEHora[1];

                                                        $dataBD = explode("-", $dataBD);
                                                        $horaBD = explode(":", $horaBD);

                                                        $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                        $hora = $horaBD[0] . ":" . $horaBD[1];

                                                        //Data Entrega
                                                        if ($row['osDtEntregaReal'] == null) {
                                                            $dataVazia = true;
                                                            $temporestante = null;
                                                        } else {
                                                            $dataVazia = false;
                                                            $dataEHoraEntrega = explode(" ", $row['osDtEntregaReal']);

                                                            $dataBDEntrega = $dataEHoraEntrega[0];
                                                            $dataBDEntrega = explode("-", $dataBDEntrega);
                                                            $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                            //Tempo restante
                                                            $now = time(); // or your date as well
                                                            $your_date = strtotime($row['osDtEntregaReal']);
                                                            $datediff = $now - $your_date;

                                                            $temporestante = round($datediff / (60 * 60 * 24));
                                                            $temporestante = $temporestante * (-1);
                                                            $temporestante = $temporestante + 1;
                                                        }



                                                        //Id
                                                        $idOs = $row['osId'];

                                                        //Status
                                                        $status = $row['osStatus'];
                                                        if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                        } else if ($status == 'EM ANDAMENTO') {
                                                            $btn = '<a href="changestatus?id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                            $btn = $btn . '<a href="changestatus?id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                        } else if ($status == 'CONCLUÍDO') {
                                                            $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                        }
                                                    ?>
                                                        <tr>
                                                            <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                            <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td>
                                                            <td><?php echo $data; ?></td>
                                                            <td><?php echo substr($row['osDescricao'], 1, 20) . '...'; ?></td>
                                                            <td class="d-flex justify-content-center" <?php
                                                                                                        if ($temporestante == null) {
                                                                                                            echo '';
                                                                                                        } else {
                                                                                                            if ($temporestante <= 2) {
                                                                                                                echo 'style="color: red;"';
                                                                                                            } ?>><?php echo $temporestante . ' dias';
                                                                                                                } ?></td>
                                                            <td><?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo $dataEntrega;
                                                                } ?></td>
                                                            <td><?php echo $btn; ?></td>
                                                        </tr>
                                                    <?php
                                                    } ?>

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

            <script>
                $(document).ready(function() {
                    $('#tableOs').DataTable({
                        responsive: true,
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
                            "zeroRecords": "Nenhuma proposta encontrada"
                        },
                        "order": [
                            [1, "desc"]
                        ]
                    });

                    $('#tableandamento').DataTable({
                        responsive: true,
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
                            "zeroRecords": "Nenhuma proposta encontrada"
                        },
                        "order": [
                            [1, "desc"]
                        ]
                    });

                    $('#tablepausado').DataTable({
                        responsive: true,
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
                            "zeroRecords": "Nenhuma proposta encontrada"
                        },
                        "order": [
                            [1, "desc"]
                        ]
                    });

                    $('#tableconcluido').DataTable({
                        responsive: true,
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
                            "zeroRecords": "Nenhuma proposta encontrada"
                        },
                        "order": [
                            [1, "desc"]
                        ]
                    });

                });
            </script>

            <hr style="border-bottom: 1px solid #fff;">

        <?php
                    }
        ?>


        </div>
        </div>

        <?php
        $thisYear = date("Y");
        ?>


        <footer class="footer mt-5 py-3 bg-light text-dark">
            <div class="container">
                <p class="small text-center">&copy; Sistemas Fábrica 2021 - <?php echo $thisYear; ?></p>
                <p class="small text-center"> Versão 1.0</p>
            </div>
        </footer>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: login");
    exit();
}

    ?>