<?php include("php/head_tables.php");

if (isset($_SESSION["useruid"])) {
?>

    <body class="bg-conecta">
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
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2>Ordens de Serviço</h2>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-evenly">
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="novaos"><button class="btn btn-fab"><i class="fas fa-plus"></i> Abrir OS</button></a>
                                    </div>
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="atividades"><button class="btn btn-outline-fab"><i class="fas fa-thumbtack"></i> Atividades</button></a>
                                    </div>
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="export"><button class="btn btn-outline-fab"><i class="far fa-file-excel"></i> Exportar</button></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data Chegada</th>
                                                <th>User Criador</th>
                                                <th>Status</th>
                                                <th>Data Solicitada</th>
                                                <th>Descricao</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'db/dbh.inc.php';
                                            $ret = mysqli_query($conn, "SELECT * FROM ordenservico");

                                            while ($row = mysqli_fetch_array($ret)) {


                                            ?>

                                                <tr>
                                                    <td><?php echo $row['osId']; ?></td>
                                                    <td><?php echo $row['osDtCriacao']; ?></td>
                                                    <td><?php echo $row['osNomeCriador']; ?></td>
                                                    <td><span class="badge bg-secondary text-white"><?php echo $row['osStatus']; ?></span></td>
                                                    <td><?php echo $row['osDtEntregasDesejada']; ?></td>
                                                    <td><?php echo substr($row['osDescricao'], 0, 50) . '...'; ?></td>


                                                    <td>
                                                        <a href="editaros?id=<?php echo $row['osId']; ?>">
                                                            <button class="btn btn-info btn-xs"><i class="far fa-edit"></i></button></a>
                                                        <a href="os?id=<?php echo $row['osId']; ?>">
                                                            <button class="btn btn-warning btn-xs"><i class="far fa-file-pdf"></i></button></a>

                                                        <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                            <a href="manageOs?id=<?php echo $row['osId']; ?>">
                                                                <button class="btn btn-danger btn-xs" onClick="return confirm('Você realmente deseja deletar essa OS?');"><i class="far fa-trash-alt"></i></button></a>
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
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>
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
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>