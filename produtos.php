<?php
session_start();

/*if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Gestor(a)'))) {*/
include("php/head_index.php");

?>
<body class="bg-light-gray2">
    <?php
    include_once 'php/navbar.php';
    include_once 'php/lateral-nav.php';
    require_once 'db/dbh.php';

    if (isset($_POST['search']) && isset($_POST['search_type'])) {
        $search = $_POST['search'];
        $search_type = $_POST['search_type'];
        if ($search_type === 'produtos') {
            $query = "SELECT * FROM produtos WHERE prodId = '$search'";
        } elseif ($search_type === 'correlacao_produto') {
            $query = "SELECT * FROM correlacao_produto WHERE correlacao_produtoId = '$search'";
        } elseif ($search_type === 'relacionados') {
            
        }
    } else {
     
        $query = "SELECT * FROM produtos";
    }

    
    if (isset($query)) {
        $ret = mysqli_query($conn, $query);
    }
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
                    <div class="justify-content-between">
                        <h2>Produtos</h2>
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal"><i class="fas fa-plus"></i> Novo Produto</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal2"><i class="fas fa-plus"></i> Nova Correlação</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal3"><i class="fas fa-plus"></i> Atualizar Produto</button>
                        <button class="btn btn-success" data-toggle="modal" data-target="#exampleModal4"><i class="fas fa-plus"></i> Atualizar Correlação Produto</button>
                    </div>
                    <br>
                    <form method="post">
                        <div class="form-group">
                            <label for="search_type" class="text-black">Tipo de Pesquisa:</label>
                            <select class="form-control" id="search_type" name="search_type">
                                <option value="produto">Visualização de Produto</option>
                                <option value="correlacao">Visualização de Correlação</option>
                                <option value="relacionados">Visualização de Produtos Relacionados</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="Pesquisar por ID">
                        </div>
                        <button type="submit" class="btn btn-primary">Pesquisar</button>
                    </form>
                    <div class="container-fluid">
                        <div class="row row-3">
                            <div class="col-md-6">
                                <h2>Produtos</h2>
                                <div class="m-2 card">
                                    <div class="m-2 card">

                                        <div class="card-body d-flex">
                                            <div class="content-panel">
                                                <table id="myTable" class="display table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Descrição</th>
                                                            <th>Código</th>
                                                            <th>Ações</th> <!-- Adicionei uma nova coluna para os botões de ação -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $row['codigoCllisto']; ?></td>
                                                                <td><?php echo $row['descricao']; ?></td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="#" id="editButton" data-toggle="modal" data-target="#exampleModal3">
                                                                            <button class="btn btn-info m-1"><i class="far fa-edit"></i></button>
                                                                        </a>
                                                                        <a href="manageProd?id=<?php echo $row['id']; ?>">
                                                                            <button class="btn btn-danger m-1" onClick="return confirm('Você realmente deseja apagar esse produto?');"><i class="far fa-trash-alt"></i></button>
                                                                        </a>
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
                            </div>
                            <div class="col-md-6">
                                <h2>Correlação</h2>
                                <div class="m-2 card">
                                    <div class="m-2 card">

                                        <div class="card-body d-flex">
                                            <div class="content-panel">
                                                <table id="myTable" class="display table table-striped table-advance table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Descrição</th>
                                                            <th>Código</th>
                                                            <th>Ações</th> <!-- Adicionei uma nova coluna para os botões de ação -->
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        while ($row = mysqli_fetch_array($ret)) {
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $row['idMaster']; ?></td>
                                                                <td><?php echo $row['IdSecundario']; ?></td>
                                                                <td>
                                                                    <div class="d-flex">
                                                                        <a href="#" id="editButton" data-toggle="modal" data-target="#exampleModal3">
                                                                            <button class="btn btn-info m-1"><i class="far fa-edit"></i></button>
                                                                        </a>
                                                                        <a href="manageProd?id=<?php echo $row['id']; ?>">
                                                                            <button class="btn btn-danger m-1" onClick="return confirm('Você realmente deseja apagar esse produto?');"><i class="far fa-trash-alt"></i></button>
                                                                        </a>
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
                            </div>
                        </div>
                    </div>
                </div>


            </div>
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
                        <div class="form-group col-md-6 d-none">
                            <label for="hidden">Descrição</label>
                            <input type="hidden" class="form-control" id="descricao" name="descricao" required>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="descricao">Descrição</label>
                                <input type="text" class="form-control" id="descricao" name="descricao" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="codigoCllisto">Callisto</label>
                                <input type="text" class="form-control" id="codigoCllisto" name="codigoCllisto" required>
                                <small class="text-muted">Código cadastrado no Callisto</small>
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

    <!-- Modal 2 -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Inserir Nova Correlação de Produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="prodForm" action="includes/produtos.inc.php" method="post">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="idMaster">Produto</label>
                                <input type="text" class="form-control" id="idMaster" name="idMaster" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="IdSecundario">Subproduto</label>
                                <input type="text" class="form-control" id="IdSecundario" name="IdSecundario" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="submit" name="submit_correlacao" class="btn btn-fab">Cadastrar</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal3 -->
    <div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Atualizar Produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="prodForm" action="includes/produtos.inc.php" method="post">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="parametro1">Produto</label>
                                <input type="text" class="form-control" id="parametro1" name="parametro1" required>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end">
                            <button type="update" name="update" class="btn btn-fab">Cadastrar</button>
                        </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <!-- Modal 4 -->
    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> Atualizar Correlação Produto </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="prodForm" action="includes/produtos.inc.php" method="post">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="parametro1">Correlação</label>
                                <input type="text" class="form-control" id="parametro1" name="parametro1" required>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="update" name="update" class="btn btn-fab">Cadastrar</button>
                            </div>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <?php include_once 'php/footer_index.php' ?>
    <?php
    /*
} else {
    header("location: index");
    exit();
}
*/
    ?>
</body>