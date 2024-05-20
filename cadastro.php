<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_354996bcb85d6a2dac07942e7066358d.png" />
    <title>Fábrica</title>
    <!-- <link href="css/styles.css" rel="stylesheet" /> -->
    <link href="css/system.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-ligth bg-image-2">
    <?php
    include_once 'db/dbh.inc.php';
    ?>
    <style>
        .btn-fab {
            color: #fff;
            background-color: #007A5A;
            border-color: #007A5A;
        }

        .btn-fab:hover {
            color: #fff;
            background-color: #53B05C;
            border-color: #53B05C;
        }

        .btn-fab:focus,
        .btn-fab.focus {
            color: #fff;
            background-color: #53B05C;
            border-color: #53B05C;
            box-shadow: 0 0 0 0.2rem rgba(76, 76, 77, 0.5);
        }

        .btn-fab.disabled,
        .btn-fab:disabled {
            color: #fff;
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-fab:not(:disabled):not(.disabled):active,
        .btn-fab:not(:disabled):not(.disabled).active,
        .show>.btn-fab.dropdown-toggle {
            color: #fff;
            background-color: var(--secondary);
            border-color: var(--secondary);
        }

        .btn-fab:not(:disabled):not(.disabled):active:focus,
        .btn-fab:not(:disabled):not(.disabled).active:focus,
        .show>.btn-fab.dropdown-toggle:focus {
            box-shadow: 0 0 0 0.2rem rgba(37, 42, 48, 0.5);
        }
    </style>
    <div class="container">
        <div class="row py-4">
            <div class="col">
                <h3 class="text-center fw-bold"><b>NOVO USUÁRIO</b></h3>
            </div>

        </div>
        <div>
            <?php
            if (isset($_GET["error"])) {
                if ($_GET["error"] == "emptyinput") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Preencha todos os campos!</p></div>";
                } else if ($_GET["error"] == "invaliduid") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Nome de usuário inválido!</p></div>";
                } else if ($_GET["error"] == "invalidemail") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>E-mail inválido!</p></div>";
                } else if ($_GET["error"] == "passworddontmatch") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Senhas não correspondem</p></div>";
                } else if ($_GET["error"] == "usernametaken") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Esse nome de usuário já está em uso!</p></div>";
                } else if ($_GET["error"] == "stmtfailed") {
                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                } else if ($_GET["error"] == "none") {
                    echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Usuário criado com sucesso!</p></div>";
                } else if ($_GET["error"] == "conecterror") {
                    echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                } else if ($_GET["error"] == "termserror") {
                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Você precisa aceitar os termos e politicas de privacidade!</p></div>";
                }
            }
            ?>
        </div>

    </div>
    <div class="container">
        <div class="row">
            <div class="col">
                <hr style="border: 2px dashed #fff;" />
                <div class="card-pass m-auto">
                    <div class="card-body">
                        <form action="includes/register.inc.php" method="post">
                            <div class='form-row'>
                                <div class='col-md'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Nome Completo *</label>
                                        <input class='form-control py-4' name='name' type='text' style='text-transform: capitalize;' required />
                                    </div>
                                </div>
                                <!-- <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Usuário *</label>
                                        <input class='form-control py-4' name='username' id='username' type='text' required onkeyup="maskUid()" style="text-transform: lowercase;" />
                                    </div>
                                </div> -->
                            </div>
                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>E-mail *</label>
                                        <input class='form-control py-4' name='email' type='email' aria-describedby='emailHelp' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Ramal *</label>
                                        <input class='form-control py-4' name='celular' id='celular' type='text' maxlength='15' required />
                                    </div>
                                </div>
                                <!-- <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Ramal *</label>
                                        <input class='form-control py-4' name='celular' id='celular' type='text' maxlength='15' onkeyup='maskCel()' required />
                                    </div>
                                </div> -->
                            </div>
                            <!-- <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Identificador *</label>
                                        <input class='form-control py-4' name='identificador' id='identificador' type='text' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>UF *</label>
                                        <select class='form-select form-select-xl w-100 ' name='uf' required>
                                            <option selected>Selecione uma UF</option>
                                            <?php
                                            $retUf = mysqli_query($conn, "SELECT * FROM estados ORDER BY ufAbreviacao ASC");
                                            while ($rowUf = mysqli_fetch_array($retUf)) {
                                            ?>
                                                <option value="<?php echo $rowUf['ufAbreviacao']; ?>"><?php echo $rowUf['ufAbreviacao']; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div> -->

                            <div class='form-row'>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Senha *</label>
                                        <input class='form-control py-4' name='password' type='password' required />
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Confirmar Senha*</label>
                                        <input class='form-control py-4' name='confirmpassword' type='password' required />
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='col-md'>
                                    <div class='form-check'>
                                        <input class='form-check-input check-required' type='checkbox' id='termsCheck' name='termsCheck'>
                                        <label class='form-check-label' for='flexCheckChecked'>
                                            Ao informar meus dados, eu concordo com a <a href='https://www.cpmhdigital.com.br/politica-de-privacidade-app/' target='blank' style='text-decoration: underline; color: #007A5A;'>Política de Privacidade </a>e em receber ofertas e comunicação personalizadas de acordo com meus interesses
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <button class='form-group mt-4 mb-0 btn btn-fab btn-block' type='submit' name='submit' id='submit'>Criar Conta</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="card-footer text-center">
        <div class="">
            <a href="login">
                <div class="alert alert-secondary">Já tenho cadastro! Acessar</div>
            </a>
        </div>
    </div>

    <?php

    ?>
    <script>
        function showPass() {

            event.preventDefault();
            var passInput = document.getElementById('login-input-2');
            if (passInput.type == 'password') {
                passInput.type = 'text';
                console.log('mostrou');
            } else {
                passInput.type = 'password';
                console.log('escondeu');
            }
        }

        function verifyEspec(elem) {

            var elem = elem.value;

            if (elem == 'outros') {
                document.getElementById('outraespec').hidden = false;

            } else {
                document.getElementById('outraespec').hidden = true;
            }
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/standart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/datatables-demo.js"></script>
</body>

</html>