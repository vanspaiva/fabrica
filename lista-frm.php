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
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>Formulário - FRM.INF.004</b></h5>
                                <small class="text-muted">Gerenciamento de pedidos</small>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-evenly">
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="FRM_INF_004"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Abrir Form</button></a>
                                    </div>
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="export"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> Exportar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data Publicação</th>
                                                <th>Data Validade</th>
                                                <th>Identificação Ambiente</th>
                                                <th>Tipo Atividade</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'db/dbh.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM frm_inf_004");

                                            while ($row = mysqli_fetch_array($ret)) {


                                            ?>

                                                <tr>
                                                    <td><?php echo $row['id']; ?></td>
                                                    <td><?php echo $row['data_publicacao']; ?></td>
                                                    <td><?php echo $row['data_validade']; ?></td>
                                                    <td><?php echo $row['identificacao_ambiente']; ?></td>
                                                    <td><?php echo $row['tipo_atividade']; ?></td>
                                                    <!-- <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td> -->


                                                    <td>
                                                        <a href="editaros?id=<?php echo $row['id']; ?>">
                                                            <button class="btn btn-info btn-sm"><i class="far fa-edit"></i></button></a>
                                                        <a href="os?id=<?php echo $row['id']; ?>">
                                                            <button class="btn btn-warning btn-sm"><i class="far fa-file-pdf"></i></button></a>

                                                        <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                            <a href="manageOs?id=<?php echo $row['id']; ?>">
                                                                <button class="btn btn-danger btn-sm" onClick="return confirm('Você realmente deseja deletar essa OS?');"><i class="far fa-trash-alt"></i></button></a>
                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
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
        <?php include_once 'php/footer_index.php' ?>
        <script>
            $(document).ready(function() {
                $('#tableProp').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableEnviada').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tableAprov').DataTable({
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
                        [0, "desc"]
                    ]
                });
                $('#tablePed').DataTable({
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
                        [0, "desc"]
                    ]
                });
            });
        </script>
        

    <?php

} else {
    header("location: index");
    exit();
}

    ?>