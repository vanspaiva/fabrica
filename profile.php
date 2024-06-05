<?php 
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';

?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

        <div id="main">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <h2>Meu Perfil</h2>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <?php

                                $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                                while ($row = mysqli_fetch_array($ret)) {
                                    $userName = $row['usersName'];
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
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <div class="nav">
                                                            <div class="col-sm-7 p-4" id="coluna-info">
                                                                <div>
                                                                    <?php
                                                                    if (isset($_GET["error"])) {
                                                                        if ($_GET["error"] == "emptyerror") {
                                                                            echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Todos os campos são obrigatórios!</p></div>";
                                                                        } else if ($_GET["error"] == "stmtfailed") {
                                                                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                        } else if ($_GET["error"] == "edit") {
                                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Informações do usuário foram alteradas com sucesso!</p></div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <h5 style="color: #4A4A4A;" class="text-align-center">Informações do Usuário</h5>
                                                                <p class="text-align-center text-small p-0 m-0">Utilize os campos abaixo para editar seus dados. </p>
                                                                <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                <br>

                                                                <form class="form-horizontal style-form mt-4 p-4" name="form1" action="includes/updateuserUser.inc.php" method="post">
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
                                                                            <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['usersEmail']; ?>" required readonly>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="uid">Usuário</label>
                                                                            <input type="text" class="form-control" id="uid" name="uid" value="<?php echo $row['usersUid']; ?>" required readonly>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-row">
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="celular">Celular</label>
                                                                            <input type="tel" class="form-control" id="celular" name="celular" value="<?php echo $row['usersCel']; ?>" placeholder='(xx) xxxxx-xxxx' maxlength='15' onkeyup='maskCel()' required>
                                                                        </div>
                                                                        <div class="form-group col-md-6">
                                                                            <label class="form-label text-black" for="identificador">Identificador</label>
                                                                            <input type="tel" class="form-control" id="identificador" name="identificador" value="<?php echo $row['usersIdentificador']; ?>"  required>
                                                                        </div>
                                                                    </div>

                                                                    <hr>
                                                                   
                                                                    <div class="d-flex justify-content-center">
                                                                        <button type="submit" name="update" class="btn btn-fab">Atualizar Dados</button>
                                                                    </div>
                                                                </form>

                                                            </div>
                                                            <div class="col-sm-5 justify-content-center p-4" id="coluna-senha">
                                                                <div>
                                                                    <?php
                                                                    if (isset($_GET["error"])) {
                                                                        if ($_GET["error"] == "pwderror") {
                                                                            echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Senhas não são iguais!</p></div>";
                                                                        } else if ($_GET["error"] == "stmtfailed") {
                                                                            echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                                                                        } else if ($_GET["error"] == "none") {
                                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Senha alterada com sucesso!</p></div>";
                                                                        }
                                                                    }
                                                                    ?>
                                                                </div>
                                                                <h5 style="color: #4A4A4A;" class="text-align-center">Redefinir Senha</h5>
                                                                <p class="text-align-center text-small p-0 m-0">Utilize os campos abaixo para redefinir sua senha. </p>
                                                                <p class="text-align-center text-small p-0 m-0">Ao finalizar o preenchimento certifique-se de salvar!</p>
                                                                <br>
                                                                <br>
                                                                <form class="form p-4" name="form1" method="post" action="includes/updatePwd.inc.php">
                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill" hidden>
                                                                            <label class="form-label" style="color:black;">Usuário</label>
                                                                            <input type="text" class="form-control" name="user" value="<?php echo $row['usersUid']; ?>">
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill">
                                                                            <label class="form-label" style="color:black;">Nova Senha</label>
                                                                            <!-- <input type="password" class="form-control" name="pwd"> -->
                                                                            <div class="input-group mb-3">
                                                                                <input id="senha" class="form-control" name="pwd" type="password" aria-describedby="basic-addon2">
                                                                                <div class="input-group-append">
                                                                                    <button onclick="showPass('pwd')" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="form-row">
                                                                        <div class="form-group flex-fill">
                                                                            <label class="form-label" style="color:black;">Confirme Senha</label>
                                                                            <!-- <input type="password" class="form-control" name="confirmpwd"> -->
                                                                            <div class="input-group mb-3">
                                                                                <input id="confirmeSenha" class="form-control" name="confirmpwd" type="password" aria-describedby="basic-addon2">
                                                                                <div class="input-group-append">
                                                                                    <button onclick="showPass('confirme')" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="form-row justify-content-center mt-3">
                                                                        <input type="submit" name="newpwd" value="Alterar Senha" class="btn btn-fab" style="margin-left: 30px;">
                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    <?php }
                                    ?>
                            </div>
                            <div class="card-footer"></div>
                        </div>
                    </div>
                    

                </div>

            </div>
        </div>

        <?php include_once 'php/footer_index.php' ?>
        <script>
            function showPass(tipo) {
                event.preventDefault();

                if (tipo == 'pwd') {
                    var passInput = document.getElementById('senha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                } else {
                    var passInput = document.getElementById('confirmeSenha');
                    if (passInput.type == 'password') {
                        passInput.type = 'text';
                    } else {
                        passInput.type = 'password';
                    }
                }



            }

            // function maskCel() {
            //     var cel = document.getElementById("celular");

            //     //(61) 9xxxx-xxxx
            //     //'(' nas posições -> 0
            //     //')' nas posições -> 3
            //     //' ' nas posições -> 4
            //     //'-' nas posições -> 10

            //     if (cel.value.length == 1) {
            //         cel.value = '(' + cel.value;
            //     }

            //     if (cel.value.length == 3) {
            //         cel.value += ') ';
            //     } else if (cel.value.length == 10) {
            //         cel.value += '-';
            //     }

            // }

            function maskTelefone() {
                var tel = document.getElementById("telefone");

                //(61) xxxx-xxxx
                //'(' nas posições -> 0
                //')' nas posições -> 3
                //' ' nas posições -> 4
                //'-' nas posições -> 10

                if (tel.value.length == 1) {
                    tel.value = '(' + tel.value;
                }

                if (tel.value.length == 3) {
                    tel.value += ') ';
                } else if (tel.value.length == 9) {
                    tel.value += '-';
                }

            }

            // function maskCNPJ() {
            //     var cnpj = document.getElementById("cnpj");

            //     //39.376.870/0001-03
            //     //'.' nas posições -> 2,6
            //     //'/' nas posições -> 10
            //     //'-' nas posições -> 15

            //     if (cnpj.value.length == 2 || cnpj.value.length == 6) {
            //         cnpj.value += '.';
            //     } else if (cnpj.value.length == 10) {
            //         cnpj.value += '/';
            //     } else if (cnpj.value.length == 15) {
            //         cnpj.value += '-';
            //     }

            // }

            // function maskCRM() {
            //     var crm = document.getElementById("crm");

            //     //CRX-UF-0000
            //     //'-' nas posições -> 3,6

            //     if (crm.value.length == 3 || crm.value.length == 6) {
            //         crm.value += '-';
            //     }

            // }
        </script>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>