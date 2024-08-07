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
    <link href="css/systemnew.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="bg-ligth bg-image-2">
    <?php
    include_once 'db/dbh.php';
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
                <h3 class="text-center fw-bold"><b>COMPLETE SEU CADASTRO</b></h3>
            </div>

        </div>
        <div>
            <!--  <?php
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
                    ?> -->
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
                                <!-- <div class='col-md-6'>
                                    <div class='form-group'>
                                        <label class='ml-2 label-control'>Setor de sua Responsábilidade*</label>
                                        <input class='form-control py-4' name='name' type='text' style='text-transform: capitalize;' required />
                                    </div>
                                </div> -->
                                <h5 class="text-fab">Selecione os Setores de sua Responsábilidade</h5>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class='form-group'>
                                        <?php
                                        // Obtém todos os setores
                                        $ret = mysqli_query($conn, "SELECT * FROM setor ORDER BY nome ASC");
                                        $total_setores = mysqli_num_rows($ret);

                                        // Calcula o meio dos setores para dividir em duas colunas
                                        $meio = ceil($total_setores / 2);

                                        // Itera sobre os setores e exibe na primeira coluna
                                        $i = 0;
                                        mysqli_data_seek($ret, 0); // Reseta o ponteiro para o início do resultado
                                        while ($row = mysqli_fetch_array($ret)) {
                                            if ($i < $meio) {
                                        ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dep[]" value="<?php echo $row['id']; ?>" id="setor<?php echo $row['id']; ?>">
                                                    <label class="form-check-label" for="setor<?php echo $row['id']; ?>">
                                                        <?php echo $row['nome']; ?>
                                                    </label>
                                                </div>
                                        <?php
                                            }
                                            $i++;
                                        }
                                        ?>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class='form-group'>
                                        <?php
                                        // Itera sobre os setores e exibe na segunda coluna
                                        $i = 0;
                                        mysqli_data_seek($ret, 0); // Reseta o ponteiro para o início do resultado
                                        while ($row = mysqli_fetch_array($ret)) {
                                            if ($i >= $meio) {
                                        ?>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="dep[]" value="<?php echo $row['id']; ?>" id="setor<?php echo $row['id']; ?>">
                                                    <label class="form-check-label" for="setor<?php echo $row['id']; ?>">
                                                        <?php echo $row['nome']; ?>
                                                    </label>
                                                </div>
                                        <?php
                                            }
                                            $i++;
                                        }
                                        ?>
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

    <?php

    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="js/standart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assetsnew/demo/chart-area-demo.js"></script>
    <script src="assetsnew/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js" crossorigin="anonymous"></script>
    <script src="assetsnew/demo/datatables-demo.js"></script>
</body>

</html>