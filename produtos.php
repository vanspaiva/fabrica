<?php include("php/head_index.php");

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Gestor(a)'))) {
?>

    <body class="bg-conecta">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        require_once 'db/dbh.inc.php';
        $ret = mysqli_query($conn, "SELECT * FROM produtos");
        $cnt = 1;
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto cadastrado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Produto foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2>Produtos</h2>
                            <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Cadastrar Produto</button>
                        </div>
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="myTable" class="display table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Categoria</th>
                                                <th>Código</th>
                                                <th>Descrição</th>
                                                <th>Atividades</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php


                                            while ($row = mysqli_fetch_array($ret)) {

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['prodCategoria'];  ?></td>
                                                    <td><?php echo $row['prodCodCallisto'];  ?></td>
                                                    <td><?php echo $row['prodDescricao']; ?></td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="editProd?id=<?php echo $row['prodId']; ?>">
                                                                <button class="btn btn-info m-1"><i class="far fa-edit"></i></button></a>
                                                            <a href="manageProd?id=<?php echo $row['prodId']; ?>">
                                                                <button class="btn btn-danger m-1" onClick="return confirm('Você realmente deseja apagar esse produto?');"><i class="far fa-trash-alt"></i></button></a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php

                                            }

                                            ?>

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

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Novo Produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="prodForm" action="includes/produtos.inc.php" method="post">
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label for="categoria">Categoria</label>
                                    <select class="form-control" id="categoria" name="categoria" required>
                                        <option>Selecione categoria</option>
                                        <option value="CMF">CMF</option>
                                        <option value="CRÂNIO">CRÂNIO</option>
                                        <option value="BIOMODELO">BIOMODELO</option>
                                        <option value="COLUNA">COLUNA</option>
                                        <option value="ATA">ATA</option>
                                        <option value="EXTRA">EXTRA</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cdg">Callisto</label>
                                    <input type="text" class="form-control" id="cdg" name="cdg" required>
                                    <small class="text-muted">Código cadastrado no callisto</small>
                                </div>
                            </div>
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="descricao">Descrição</label>
                                    <input type="text" class="form-control" id="descricao" name="descricao" required>
                                </div>
                                <div class="form-group col-md">
                                    <label for="anvisa">Anvisa</label>
                                    <input type="text" class="form-control" id="anvisa" name="anvisa" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="submit" class="btn btn-fab">Cadastrar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <script>
            function populateModal(element) {
                console.log(element);
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#myTable').DataTable({
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
                    }
                });
            });
        </script>
        <script src="//cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>