<?php
session_start();

if (isset($_SESSION["useruid"])) {

    include("php/head_tables.php");

    $user = $_SESSION["useruid"];
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';


?>


    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

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

                <div class="row p-4 justify-content-center">
                    <div class="col">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>OM - Acompanhamento</b></h5>
                                <small class="text-muted">Chegada de pedidos e realização de trabalho</small>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="row h-100 py-2">
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
                                                    TODOS ABERTOS</div>
                                            </div>
                                        </div>
                                        <div class="row p-2 d-flex justify-content-center">
                                            <div class="content-panel" style="overflow-x: scroll;">
                                                <table id="tableOs" class="table table-striped table-advance table-hover display responsive nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Status</th>
                                                            <th>Data Entrada</th>
                                                            <th>Máquina</th>
                                                            <th>Descrição</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'db/dbh.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omStatus IN ('CRIADO', 'EM ANDAMENTO', 'PAUSADO');");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            //Data Entrada
                                                            $dataEHora = explode(" ", $row['omDtCriacao']);

                                                            $dataBD = $dataEHora[0];
                                                            $horaBD = $dataEHora[1];

                                                            $dataBD = explode("-", $dataBD);
                                                            $horaBD = explode(":", $horaBD);

                                                            $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                            $hora = $horaBD[0] . ":" . $horaBD[1];

                                                            //Id
                                                            $idOs = $row['omId'];

                                                            //Status
                                                            $status = $row['omStatus'];
                                                            if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                            } else if ($status == 'EM ANDAMENTO') {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                                $btn = $btn . '<a href="changestatus?type=om&id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                            } else if ($status == 'CONCLUÍDO') {
                                                                $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                                <td><span class="badge bg-secondary text-white"><?php echo $row['omStatus']; ?></span></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $row['idMaquina']; ?></td>
                                                                <td><?php echo substr($row['omDescricao'], 0, 50) . '...'; ?></td>
                                                                <!-- <td class="d-flex justify-content-center" <?php
                                                                                                                if ($temporestante == null) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    if ($temporestante <= 2) {
                                                                                                                        echo 'style="color: red;"';
                                                                                                                    } ?>><?php echo $temporestante . ' dias';
                                                                                                                    } ?></td>
                                                                <td><?php if ($dataVazia) {
                                                                        echo '<a href="editarom?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                    } else {
                                                                        echo $dataEntrega;
                                                                    } ?></td> -->
                                                                <!-- <td><?php echo $btn; ?></td> -->
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
                                                    EM ANDAMENTO</div>
                                            </div>
                                        </div>
                                        <div class="row p-2 d-flex justify-content-center">
                                            <div class="content-panel" style="overflow-x: scroll;">
                                                <table id="tableandamento" class="table table-striped table-advance table-hover display responsive nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Status</th>
                                                            <th>Data Entrada</th>
                                                            <th>Máquina</th>
                                                            <th>Descrição</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'db/dbh.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omStatus IN ('EM ANDAMENTO');");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            //Data Entrada
                                                            $dataEHora = explode(" ", $row['omDtCriacao']);

                                                            $dataBD = $dataEHora[0];
                                                            $horaBD = $dataEHora[1];

                                                            $dataBD = explode("-", $dataBD);
                                                            $horaBD = explode(":", $horaBD);

                                                            $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                            $hora = $horaBD[0] . ":" . $horaBD[1];

                                                            //Id
                                                            $idOs = $row['omId'];

                                                            //Status
                                                            $status = $row['omStatus'];
                                                            if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                            } else if ($status == 'EM ANDAMENTO') {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                                $btn = $btn . '<a href="changestatus?type=om&id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                            } else if ($status == 'CONCLUÍDO') {
                                                                $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                                <td><span class="badge bg-secondary text-white"><?php echo $row['omStatus']; ?></span></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $row['idMaquina']; ?></td>
                                                                <td><?php echo substr($row['omDescricao'], 1, 50) . '...'; ?></td>
                                                                <!-- td class="d-flex justify-content-center" <?php
                                                                                                                if ($temporestante == null) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    if ($temporestante <= 2) {
                                                                                                                        echo 'style="color: red;"';
                                                                                                                    } ?>><?php echo $temporestante . ' dias';
                                                                                                                    } ?></td>
                                                                <td><?php if ($dataVazia) {
                                                                        echo '<a href="editarom?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                    } else {
                                                                        echo $dataEntrega;
                                                                    } ?></td> -->
                                                                <!--   <td><?php echo $btn; ?></td> -->
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
                                                    PAUSADOS</div>
                                            </div>
                                        </div>
                                        <div class="row p-2 d-flex justify-content-center">
                                            <div class="content-panel" style="overflow-x: scroll;">
                                                <table id="tablepausado" class="table table-striped table-advance table-hover display responsive nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Status</th>
                                                            <th>Data Entrada</th>
                                                            <th>Máquina</th>
                                                            <th>Descrição</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'db/dbh.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omStatus IN ('PAUSADO');");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            //Data Entrada
                                                            $dataEHora = explode(" ", $row['omDtCriacao']);

                                                            $dataBD = $dataEHora[0];
                                                            $horaBD = $dataEHora[1];

                                                            $dataBD = explode("-", $dataBD);
                                                            $horaBD = explode(":", $horaBD);

                                                            $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                            $hora = $horaBD[0] . ":" . $horaBD[1];


                                                            //Id
                                                            $idOs = $row['omId'];

                                                            //Status
                                                            $status = $row['omStatus'];
                                                            if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                            } else if ($status == 'EM ANDAMENTO') {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                                $btn = $btn . '<a href="changestatus?type=om&id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                            } else if ($status == 'CONCLUÍDO') {
                                                                $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                                <td><span class="badge bg-secondary text-white"><?php echo $row['omStatus']; ?></span></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $row['idMaquina']; ?></td>
                                                                <td><?php echo substr($row['omDescricao'], 1, 50) . '...'; ?></td>
                                                                <!--  <td class="d-flex justify-content-center" <?php
                                                                                                                if ($temporestante == null) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    if ($temporestante <= 2) {
                                                                                                                        echo 'style="color: red;"';
                                                                                                                    } ?>><?php echo $temporestante . ' dias';
                                                                                                                    } ?></td>
                                                                <td><?php if ($dataVazia) {
                                                                        echo '<a href="editarom?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                    } else {
                                                                        echo $dataEntrega;
                                                                    } ?></td> -->
                                                                <!--   <td><?php echo $btn; ?></td> -->
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
                                            <div class="content-panel" style="overflow-x: scroll;">
                                                <table id="tableconcluido" class="table table-striped table-advance table-hover display responsive nowrap">

                                                    <thead>
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Status</th>
                                                            <th>Data Entrada</th>
                                                            <th>Máquina</th>
                                                            <th>Descrição</th>
                                                            <!-- <th>Tempo Restante</th>
                                                            <th>Data Entrega</th> -->
                                                            <!--    <th></th> -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        require_once 'db/dbh.php';
                                                        $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omStatus IN ('CONCLUÍDO');");
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                            //Data Entrada
                                                            $dataEHora = explode(" ", $row['omDtCriacao']);

                                                            $dataBD = $dataEHora[0];
                                                            $horaBD = $dataEHora[1];

                                                            $dataBD = explode("-", $dataBD);
                                                            $horaBD = explode(":", $horaBD);

                                                            $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
                                                            $hora = $horaBD[0] . ":" . $horaBD[1];

                                                            /*    //Data Entrega
                                                            if ($row['omDtEntregaReal'] == null) {
                                                                $dataVazia = true;
                                                                $temporestante = null;
                                                            } else {
                                                                $dataVazia = false;
                                                                $dataEHoraEntrega = explode(" ", $row['omDtEntregaReal']);

                                                                $dataBDEntrega = $dataEHoraEntrega[0];
                                                                $dataBDEntrega = explode("-", $dataBDEntrega);
                                                                $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                                //Tempo restante
                                                                $now = time(); // or your date as well
                                                                $your_date = strtotime($row['omDtEntregaReal']);
                                                                $datediff = $now - $your_date;

                                                                $temporestante = round($datediff / (60 * 60 * 24));
                                                                $temporestante = $temporestante * (-1);
                                                                $temporestante = $temporestante + 1;
                                                            }
 */


                                                            //Id
                                                            $idOs = $row['omId'];

                                                            //Status
                                                            $status = $row['omStatus'];
                                                            if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=start"> <button class="btn btn-success btn-xs"><i class="fas fa-play-circle"></i></button></a>';
                                                            } else if ($status == 'EM ANDAMENTO') {
                                                                $btn = '<a href="changestatus?type=om&id=' . $idOs . '&st=pause"> <button class="btn btn-danger btn-xs"><i class="fas fa-pause-circle"></i></button></a>';
                                                                $btn = $btn . '<a href="changestatus?type=om&id=' . $idOs . '&st=stop"> <button class="btn btn-warning btn-xs"><i class="fas fa-check-circle"></i></button></a>';
                                                            } else if ($status == 'CONCLUÍDO') {
                                                                $btn = '<button class="btn btn-success btn-xs"><i class="fas fa-check"></i></button>';
                                                            }
                                                        ?>
                                                            <tr>
                                                                <td class="d-flex justify-content-center"><?php echo $idOs; ?></td>
                                                                <td><span class="badge bg-secondary text-white"><?php echo $row['omStatus']; ?></span></td>
                                                                <td><?php echo $data; ?></td>
                                                                <td><?php echo $row['idMaquina']; ?></td>
                                                                <td><?php echo substr($row['omDescricao'], 1, 50) . '...'; ?></td>
                                                                <!-- <td class="d-flex justify-content-center" <?php
                                                                                                                if ($temporestante == null) {
                                                                                                                    echo '';
                                                                                                                } else {
                                                                                                                    if ($temporestante <= 2) {
                                                                                                                        echo 'style="color: red;"';
                                                                                                                    } ?>><?php echo $temporestante . ' dias';
                                                                                                                    } ?></td>
                                                                <td><?php if ($dataVazia) {
                                                                        echo '<a href="editarom?id=' . $idOs . '" style="color: #000;">editar data</a>';
                                                                    } else {
                                                                        echo $dataEntrega;
                                                                    } ?></td> -->
                                                                <!--     <td><?php echo $btn; ?></td> -->
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
            </div>


        </div>

    </body>



    <?php include_once 'php/footer_index.php' ?>

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
                    "zeroRecords": "Nenhum item encontrado"
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
                    "zeroRecords": "Nenhum item encontrado"
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
                    "zeroRecords": "Nenhum item encontrado"
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
                    "zeroRecords": "Nenhum item encontrado"
                },
                "order": [
                    [1, "desc"]
                ]
            });
        });
    </script>

<?php
} else {
    header("location: login");
    exit();
}
?>