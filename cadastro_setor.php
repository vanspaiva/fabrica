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

        <head>

            <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_354996bcb85d6a2dac07942e7066358d.png" />
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
            </div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <hr style="border: 2px dashed #fff;" />
                        <div class="card-pass m-auto">
                            <div class="card-body">
                                <form action="includes/cadSetor.inc.php" method="post">
                                    <div class='form-row'>
                                        <div class="col-sm mt-2">
                                            <div class="card shadow rounded p-4 h-100" style="border-top: #007A5A 7px solid;">
                                                <!-- <h5 class="text-fab"><b>DASHBOARD</b></h5> -->
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col">
                                                            <h5 class="txt-ciano-agiliza" style="font-weight: 400;">😄 Olá, <?php echo $_SESSION["userfirstname"]; ?>!</b></h5>

                                                            <span class="text-muted text-small"><?php echo $_SESSION["userperm"] . " - " . $_SESSION["usernomedep"]; ?></span>
                                                        </div>

                                                    </div>

                                                </div>
                                                <h5 class="text-fab">Selecione os Setores de sua Responsabilidade</h5>

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


                                                <button class='form-group mt-4 mb-0 btn btn-fab btn-block' type='update' name='update' id='submit'>atualizar</button>

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

    <?php

} else {
    header("location: index");
    exit();
}

    ?>