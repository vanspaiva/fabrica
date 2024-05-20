<?php include("php/head_index.php");

require_once 'db/dbh.inc.php';

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {

?>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->

    <body class="bg-conecta">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';

        $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersId='" . $_GET['id'] . "';");
        while ($row = mysqli_fetch_array($ret)) {


            $userPerm = $row['usersPerm'];
            $tipoUsuario1 = '';
            $tipoUsuario2 = '';

            $retPerm1 = mysqli_query($conn, "SELECT * FROM tipocadastroexterno WHERE tpcadexCodCadastro='" . $userPerm . "';");
            while ($rowPerm1 = mysqli_fetch_array($retPerm1)) {
                $tipoUsuario1 = $rowPerm1['tpcadexNome'];
            }

            $retPerm2 = mysqli_query($conn, "SELECT * FROM tipocadastrointerno WHERE tpcadinCodCadastro= '" . $userPerm . "';");
            while ($rowPerm2 = mysqli_fetch_array($retPerm2)) {
                $tipoUsuario2 = $rowPerm2['tpcadinNome'];
            }

            $tipoUsuario = $tipoUsuario1 . $tipoUsuario2;
        ?>



            <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
            <div id="main">
                <div>
                    <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "stmfailed") {
                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                        }
                    }
                    ?>
                </div>
                <div class="container-fluid">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-10 justify-content-start" id="titulo-pag">
                            <div class="d-flex align-items-center">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back button-back-dark p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-11 pt-2">
                                    <div class="row px-3">
                                        <h2 style="font-weight: bold; color: #6D6D6D;" class="py-2">Informações do Usuário - <?php echo $tipoUsuario ?> </h2>
                                    </div>
                                </div>
                            </div>

                            <br>
                            <div class="card">
                                <div class="card-body">
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <form class="form-horizontal style-form" name="form1" action="includes/updateuser.inc.php" method="post">

                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="usersid">User ID</label>
                                                                    <input type="number" class="form-control" id="usersid" name="usersid" value="<?php echo $row['usersId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="nome">Nome Completo</label>
                                                                    <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $row['usersName']; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="uf">UF</label>
                                                                    <select name="uf" class="form-control" id="uf">
                                                                        <?php
                                                                        $retUf = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                                                        while ($rowUf = mysqli_fetch_array($retUf)) {
                                                                        ?>
                                                                            <option value="<?php echo $rowUf['ufAbreviacao']; ?>" <?php if ($row['usersUf'] == $rowUf['ufAbreviacao']) echo ' selected="selected"'; ?>><?php echo $rowUf['ufAbreviacao']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="email">E-mail</label>
                                                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['usersEmail']; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="uid">Usuário</label>
                                                                    <input type="text" class="form-control" id="uid" name="uid" value="<?php echo $row['usersUid']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="celular">Celular</label>
                                                                    <input type="tel" class="form-control" id="celular" name="celular" value="<?php echo $row['usersCel']; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="identificador">Identificador</label>
                                                                    <input type="tel" class="form-control" id="identificador" name="identificador" value="<?php echo $row['usersIdentificador']; ?>" required>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="aprov">Aprovação</label>
                                                                    <select name="aprov" class="form-control" id="aprov">
                                                                        <option value="APROV" <?php if ($row['usersAprov'] == 'APROV') echo ' selected="selected"'; ?>>Aprovado</option>
                                                                        <option value="AGRDD" <?php if ($row['usersAprov'] == 'AGRDD') echo ' selected="selected"'; ?>>Aguardando</option>
                                                                        <option value="BLOQD" <?php if ($row['usersAprov'] == 'BLOQD') echo ' selected="selected"'; ?>>Bloqueado</option>
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="form-label text-black" for="perm">Permissão</label>
                                                                    <select name="perm" class="form-control" id="perm">
                                                                        <?php
                                                                        $retPermIn = mysqli_query($conn, "SELECT * FROM tipocadastrointerno ORDER BY tpcadinNome ASC");
                                                                        while ($rowPermIn = mysqli_fetch_array($retPermIn)) {
                                                                        ?>
                                                                            <option value="<?php echo $rowPermIn['tpcadinCodCadastro']; ?>" <?php if ($row['usersPerm'] == $rowPermIn['tpcadinCodCadastro']) echo ' selected="selected"'; ?>><?php echo $rowPermIn['tpcadinNome']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                        <?php
                                                                        $retPermEx = mysqli_query($conn, "SELECT * FROM tipocadastroexterno ORDER BY tpcadexNome ASC");
                                                                        while ($rowPermEx = mysqli_fetch_array($retPermEx)) {
                                                                        ?>
                                                                            <option value="<?php echo $rowPermEx['tpcadexCodCadastro']; ?>" <?php if ($row['usersPerm'] == $rowPermEx['tpcadexCodCadastro']) echo ' selected="selected"'; ?>><?php echo $rowPermEx['tpcadexNome']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" class="btn btn-fab">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    <?php } ?>
                                </div>
                                <div class="card-footer"></div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

            <?php include_once 'php/footer_index.php' ?>

        <?php

    } else {
        header("location: index");
        exit();
    }


        ?>