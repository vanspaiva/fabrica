<?php
session_start();

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_index.php");
    require_once 'db/dbh.php';
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row d-flex justify-content-center py-4">
                    <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                        <h5 class="text-muted"><b>Mudar senha</b></h5>
                        <small class="text-muted">Utilize os campos abaixo para redefinir sua senha.</small>
                    </div>
                </div>
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-10">
                        <div class="container-fluiud">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <div class="card shadow">

                                        <div class="card-body">

                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="content-panel">
                                                                <div class="nav">
                                                                    <div class="col-sm justify-content-center p-4" id="coluna-senha">
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
                                                                
                                                                        <form class="form p-4" name="form1" method="post" action="includes/updatePwdAdm.inc.php">
                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">Usuário</label>
                                                                                    <input id="usuario" class="form-control" name="usuario" type="text">
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row">
                                                                                <div class="form-group flex-fill">
                                                                                    <label class="form-label" style="color:black;">Nova Senha</label>
                                                                                    <div class="input-group mb-3">
                                                                                        <input id="senha" class="form-control" name="pwd" type="password" aria-describedby="basic-addon2">
                                                                                        <div class="input-group-append">
                                                                                            <button onclick="showPass('pwd')" class="input-group-text" id="basic-addon2"><i class="far fa-eye"></i></button>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="form-row justify-content-center mt-3">
                                                                                <input type="submit" name="novasenha" value="Salvar" class="btn btn-fab" style="margin-left: 30px;">
                                                                            </div>

                                                                        </form>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>

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
        </script>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>