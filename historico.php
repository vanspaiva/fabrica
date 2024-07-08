<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");

    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

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
            <div class="container-fluid py-4">
                <div class="row d-flex justify-content-center">

                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-center">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>Log de Atividades</b></h5>
                                <small class="text-muted">Histórico de Atividades das OS</small>
                            </div>
                        </div>
                        <hr>
                        <div class="">
                            <div class="card-body">
                                <div class="content-panel" style="overflow-x: scroll;">
                                    <table id="table" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data/Hora</th>
                                                <th>Responsável</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ret = mysqli_query($conn, "SELECT * FROM logatividades ORDER BY logId DESC;");

                                            while ($row = mysqli_fetch_array($ret)) {
                                                $OsRef = $row['logOsRef'];
                                                $Horario = $row['logHorario'];
                                                $User = $row['logUser'];
                                                $Status = $row['logStatus'];

                                                switch ($Status) {
                                                    case 'PAUSADO':
                                                        $badgeStatus = "badge-danger";
                                                        break;
                                                    case 'EM ANDAMENTO':
                                                        $badgeStatus = "badge-warning";
                                                        break;
                                                    case 'CONCLUÍDO':
                                                        $badgeStatus = "badge-success";
                                                        break;
                                                    case 'CRIADO':
                                                        $badgeStatus = "badge-info";
                                                        break;

                                                    default:
                                                        $badgeStatus = "badge-secondary";
                                                        break;
                                                }

                                                $data = dateAndHourFormat($Horario);

                                            ?>

                                                <tr>
                                                    <td><?php echo $OsRef; ?></td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><?php echo $User; ?></td>
                                                    <td><span class="badge <?php echo $badgeStatus; ?>"><?php echo $Status; ?></span></td>
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
        <?php include_once 'php/footer_index.php' ?>
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
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
                    order: []
                });

            });
        </script>


    <?php

} else {
    header("location: index");
    exit();
}

    ?>