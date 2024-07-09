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
                            <div class="col-sm-2">
                                <div class="d-flex justify-content-end p-1">
                                    <span class="btn btn-fab mx-2 p-2 px-3" data-toggle="modal" data-target="#exportrelatorio"><i class="fas fa-plus"></i> Relatório</span>
                                </div>
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
                                                <th>Pedido</th>
                                                <th>Etapa</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT 
                                            l.id AS Id,
                                            l.data AS DataLog,
                                            l.hora AS HoraLog,
                                            u.usersName AS Responsavel,
                                            p.pedido AS numPedido,
                                            e.nome AS Etapa,
                                            s.nome AS Status
                                            FROM log_atividades_producao AS l 
                                            JOIN realizacaoproducao AS r ON l.idRealizacaoProducao = r.id
                                            JOIN pedidos AS p ON r.idPedido = p.id
                                            JOIN etapa AS e ON l.idEtapa = e.id
                                            JOIN users AS u ON l.idUsuario = u.usersId
                                            JOIN statusetapa AS s ON l.idStatus = s.id
                                            ORDER BY id DESC;";
                                            $ret = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_array($ret)) {

                                                $Id = $row["Id"];
                                                $DataLog = $row["DataLog"];
                                                $HoraLog = $row["HoraLog"];
                                                $Responsavel = getFirstAndLastName($row["Responsavel"]);
                                                $numPedido = $row["numPedido"];
                                                $Etapa = $row["Etapa"];
                                                $Status = $row["Status"];

                                                $data = dateFormatByHifen($DataLog);
                                                $hora = hourFormat($HoraLog);
                                                $horario = $data . " " . $hora;

                                            ?>

                                                <tr>
                                                    <th><?php echo $Id; ?></th>
                                                    <th><?php echo $horario; ?></th>
                                                    <th><?php echo $Responsavel; ?></th>
                                                    <th><?php echo $numPedido; ?></th>
                                                    <th><?php echo $Etapa; ?></th>
                                                    <th><?php echo $Status; ?></th>
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

        <!-- Modal Exportar Relatório da Produção -->
        <div class="modal fade" id="exportrelatorio" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007A5A;">
                        <h5 class="modal-title text-white">Exportar Relatório da Produção</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="w-100" action="exportrelatorio" method="POST">
                            <div class="col d-flex justify-content-end">
                                <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui um pedido..." aria-label="Pesquise aqui um pedido..." aria-describedby="search-addon" />
                                <div class="px-2 d-flex justify-content-center align-items-center">
                                    <button class="btn btn-fab input-group-text border-0 p-2" id="search-addon" type="search" value="search" name="search">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
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