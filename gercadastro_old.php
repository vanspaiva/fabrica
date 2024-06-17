<?php include("php/head_tables.php");

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
?>
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script> -->

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';

        require_once 'db/dbh.php';

        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Caso editado com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Caso foi deletado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-8 justify-content-start" id="titulo-pag">
                        <div class="d-flex justify-content-between">
                            <h2 class="text-white">Configurações de Cadastro</h2>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-md container-fluid">

                                            <!-- Estados -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Estados</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addestado"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retEstados = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                    while ($rowEstados = mysqli_fetch_array($retEstados)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowEstados['ufAbreviacao']; ?> <a href="manageConfigCadastro?deleteestado=<?php echo $rowEstados['ufId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>



                                            <!-- Modal Add Estados-->
                                            <div class="modal fade" id="addestado" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Estado</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcadastro.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="abrev">Abreviação</label>
                                                                        <input type="text" class="form-control" id="abrev" name="abrev" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novoestado" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>



                                            <!-- Tipo Usuário Interno -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Tipo Usuário Interno</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addcadinterno"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retCadInterno = mysqli_query($conn, "SELECT * FROM tipocadastrointerno ORDER BY tpcadinNome  ASC");
                                                    while ($rowCadInterno = mysqli_fetch_array($retCadInterno)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowCadInterno['tpcadinCodCadastro'] . ') ' . $rowCadInterno['tpcadinNome']; ?> <a href="manageConfigCadastro?deletecadin=<?php echo $rowCadInterno['tpcadinId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>



                                            <!-- Modal Add Tipo Usuário Interno-->
                                            <div class="modal fade" id="addcadinterno" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Tipo Usuário Interno</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcadastro.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="codigo">Código</label>
                                                                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novocadin" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Tipo Usuário Externo -->
                                            <div class="row w-100 p-3 bg-light rounded my-4">
                                                <div class="d-flex justify-content-between p-1 align-items-center">
                                                    <h5 class="text-black">Tipo Usuário Externo</h5>
                                                    <button class="btn btn-conecta" data-toggle="modal" data-target="#addcadexterno"><i class="far fa-plus-square"></i> novo</button>
                                                </div>
                                                <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                                <div class="col p-1">
                                                    <?php
                                                    $retCadExterno = mysqli_query($conn, "SELECT * FROM tipocadastroexterno ORDER BY tpcadexNome  ASC");
                                                    while ($rowCadExterno = mysqli_fetch_array($retCadExterno)) {
                                                    ?>
                                                        <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo '(' . $rowCadExterno['tpcadexCodCadastro'] . ') ' . $rowCadExterno['tpcadexNome']; ?> <a href="manageConfigCadastro?deletecadex=<?php echo $rowCadExterno['tpcadexId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                    <?php
                                                    }
                                                    ?>

                                                </div>
                                            </div>



                                            <!-- Modal Add Tipo Usuário Externo-->
                                            <div class="modal fade" id="addcadexterno" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title text-black">Novo Tipo Usuário Externo</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="prodForm" action="includes/configcadastro.inc.php" method="post">
                                                                <div class="form-row">
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="codigo">Código</label>
                                                                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                                                                    </div>
                                                                    <div class="form-group col-md">
                                                                        <label class="text-black" for="nome">Nome</label>
                                                                        <input type="text" class="form-control" id="nome" name="nome" required>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="submit" name="novocadex" class="btn btn-primary">Adicionar</button>
                                                                </div>
                                                            </form>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Etapas -->
                                        <div class="row w-100 p-3 bg-light rounded my-4">
                                            <div class="d-flex justify-content-between p-1 align-items-center">
                                                <h5 class="text-black">Etapas OS</h5>
                                                <button class="btn btn-conecta" data-toggle="modal" data-target="#addetapaos"><i class="far fa-plus-square"></i> novo</button>
                                            </div>
                                            <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                            <div class="col p-1">
                                                <?php
                                                $retEtapasOs = mysqli_query($conn, "SELECT * FROM etapasos ORDER BY etapaNome  ASC");
                                                while ($rowEtapasOs = mysqli_fetch_array($retEtapasOs)) {
                                                ?>
                                                    <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowEtapasOs['etapaNome']; ?> <a href="manageConfigCadastro?deleteetapaos=<?php echo $rowEtapasOs['etapaId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>



                                        <!-- Modal Add Etapas-->
                                        <div class="modal fade" id="addetapaos" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-black">Novo Etapa OS</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="prodForm" action="includes/configcadastro.inc.php" method="post">
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label class="text-black" for="nome">Nome</label>
                                                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="novoetapaos" class="btn btn-primary">Adicionar</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                        <!-- Status -->
                                        <div class="row w-100 p-3 bg-light rounded my-4">
                                            <div class="d-flex justify-content-between p-1 align-items-center">
                                                <h5 class="text-black">Status OS</h5>
                                                <button class="btn btn-conecta" data-toggle="modal" data-target="#addstatus"><i class="far fa-plus-square"></i> novo</button>
                                            </div>
                                            <hr class="mt-1 px-1" style="border-bottom: 2px dashed #a1a1a1;">
                                            <div class="col p-1">
                                                <?php
                                                $retStatusOs = mysqli_query($conn, "SELECT * FROM statusos ORDER BY stPosicao  ASC");
                                                while ($rowStatusOs = mysqli_fetch_array($retStatusOs)) {
                                                ?>
                                                    <span class="badge bg-secondary my-1" style="font-size: 1rem;"> <?php echo $rowStatusOs['stNome']; ?> <a href="manageConfigCadastro?deletestatus=<?php echo $rowStatusOs['stId']; ?>" class="px-1" style="color: #fff;"><i class="fas fa-times"></i> </a></span>
                                                <?php
                                                }
                                                ?>

                                            </div>
                                        </div>



                                        <!-- Modal Add Status-->
                                        <div class="modal fade" id="addstatus" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title text-black">Novo Status OS</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="prodForm" action="includes/configcadastro.inc.php" method="post">
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label class="text-black" for="posicao">Posição Modalidade</label>
                                                                    <input type="text" class="form-control" id="posicao" name="posicao" required>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="text-black" for="nome">Nome</label>
                                                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="novostatus" class="btn btn-primary">Adicionar</button>
                                                            </div>
                                                        </form>
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
        </div>
        </div>



        <?php include_once 'php/footer_index.php' ?>

        <script>
            $(document).ready(function() {
                $('#usersTable').DataTable({
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
                        "zeroRecords": "Nenhum caso encontrado"
                    }
                });
            });
        </script>

        <script>
            function show(elem) {
                elem = elem.text;
                var tabAgenda = document.getElementById("v-pills-home");
                var tabConfig = document.getElementById("v-pills-settings");
                var linkAgenda = document.getElementById("v-pills-home-tab");
                var linkConfig = document.getElementById("v-pills-settings-tab");

                switch (elem) {
                    case 'Agenda':
                        tabAgenda.classList.add('show', 'active');
                        tabConfig.classList.remove('show', 'active');
                        linkAgenda.classList.add('active');
                        linkConfig.classList.remove('active');
                        break;

                    case 'Configurações':
                        tabAgenda.classList.remove('show', 'active');
                        tabConfig.classList.add('show', 'active');
                        linkAgenda.classList.remove('active');
                        linkConfig.classList.add('active');
                        break;

                    default:
                        console.log('erro');
                }


            }
        </script>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>