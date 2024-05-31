<?php ob_start();
include("php/head_updateprop.php");
require_once 'db/dbh.php';
if (isset($_SESSION["useruid"])) {
    $user = $_SESSION["useruid"];

?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';

        $osid = $_GET['id'];

        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osId='" . $osid . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $fileNameOs = $row['osNomeArquivo'];
        ?>

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
                        <div class="col-sm" id="titulo-pag">
                            <div class="d-flex">
                                <div class="col-sm-1">
                                    <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                        <button class='button-back button-back-dark p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                    </div>
                                </div>
                                <div class="col-sm-8 pt-2 row-padding-2">
                                    <div class="row px-3" style="color: #fff">
                                        <h2>Informações da Ordem de Serviço - <?php echo $osid; ?> </h2>
                                    </div>
                                </div>
                                <?php
                                if ($fileNameOs != null) {
                                ?>
                                        <div class="col-sm pt-2">
                                            <div class="d-flex justify-content-center p-1">
                                                <!-- <a href="<?php //echo $fileNameOs ?>" class="btn btn-outline-fab" download><i class="bi bi-cloud-arrow-down"></i> Download Arquivo</a> -->
                                                <a href="<?php echo htmlspecialchars($fileNameOs); ?>" target="_blank" class="btn btn-outline-fab" download><i class="bi bi-cloud-arrow-down"></i> Download Arquivo</a>

                                            </div>
                                        </div>
                                <?php
                                }
                                ?>


                            </div>

                            <br>

                            <div class="card">
                                <div class="card-body">
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="content-panel">
                                                        <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updateos.inc.php" method="POST">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="osid">OS ID</label>
                                                                    <input type="number" class="form-control" id="osid" name="osid" value="<?php echo $row['osId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="user">User Responsável</label>
                                                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                                </div>
                                                            </div>

                                                            <div class="card border-success">
                                                                <div class="card-body">
                                                                    <div class='d-flex d-block justify-content-around'>
                                                                        <div class="col form-group d-inline-block flex-fill m-2">
                                                                            <label class="form-label text-black" for="status">Status</label>
                                                                            <select class='form-control' name='status' id='status' required>
                                                                                <?php
                                                                                $retStatus = mysqli_query($conn, "SELECT * FROM statusos ORDER BY stPosicao ASC;");
                                                                                while ($rowStatus = mysqli_fetch_array($retStatus)) { ?>

                                                                                    <option value="<?php echo $rowStatus['stNome']; ?>" <?php if (trim($row['osStatus']) == trim($rowStatus['stNome'])) echo ' selected="selected"'; ?>><?php echo $rowStatus['stNome']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col form-group d-inline-block flex-fill m-2">
                                                                            <label class='d-block control-label' style='color:black;'>Grau de urgência da tarefa <b style='color: red;'>*</b></label>
                                                                            <select class='form-control' name='grau' id='grau' required>
                                                                                <option value='0' selected style='color: #F6F7FA;'>Escolha um grau</option>

                                                                                <option value="1" <?php if ($row['osGrauUrgencia'] == 1) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>1</option>
                                                                                <option value="2" <?php if ($row['osGrauUrgencia'] == 2) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>2</option>
                                                                                <option value="3" <?php if ($row['osGrauUrgencia'] == 3) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>3</option>
                                                                                <option value="4" <?php if ($row['osGrauUrgencia'] == 4) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>4</option>
                                                                                <option value="5" <?php if ($row['osGrauUrgencia'] == 5) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>5</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label'>Para qual setor se destina a tarefa? <b style='color: red;'>*</b></label>
                                                                    <select class='form-control' name='setor' id='setor' required>
                                                                        <option value='0' selected style='color: #F6F7FA;'>Escolha um setor</option>
                                                                        <?php
                                                                        $retEtapa = mysqli_query($conn, "SELECT * FROM etapasos ORDER BY etapaNome ASC;");
                                                                        while ($rowEtapa = mysqli_fetch_array($retEtapa)) { ?>

                                                                            <option value="<?php echo $rowEtapa['etapaNome']; ?>" <?php if (trim($row['osSetor']) == trim($rowEtapa['etapaNome'])) echo ' selected="selected"'; ?>><?php echo $rowEtapa['etapaNome']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data Desejada <b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='dtentrega' id='dtentrega' type='date' value="<?php echo $row['osDtEntregasDesejada']; ?>" required readonly>
                                                                    <small class="text-muted">Prazo sujeito a aprovação de acordo com calendário</small>
                                                                </div>
                                                                <script>
                                                                    var dtToday = new Date();
                                                                    var month = dtToday.getMonth() + 1; // getMonth() is zero-based
                                                                    var day = dtToday.getDate();
                                                                    var year = dtToday.getFullYear();
                                                                    if (month < 10)
                                                                        month = '0' + month.toString();
                                                                    if (day < 10)
                                                                        day = '0' + day.toString();

                                                                    var minData = year + '-' + month + '-' + day;
                                                                    $('#dtentrega').attr('min', minData);
                                                                    $('#dtrealentrega').attr('min', minData);
                                                                    $('#dtexecucao').attr('min', minData);
                                                                </script>
                                                            </div>
                                                            <div class="d-flex d-block justify-content-around">
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data entrega <b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='dtrealentrega' id='dtrealentrega' type='date' value="<?php echo $row['osDtEntregaReal']; ?>" required>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data Execução Tarefa </label>
                                                                    <input class='form-control' name='dtexecucao' id='dtexecucao' type='date' value="<?php echo $row['dtExecucao']; ?>">
                                                                </div>

                                                            </div>
                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Lote </label>
                                                                    <input class='form-control' name='lote' id='lote' type='text' value="<?php echo $row['osLote']; ?>">
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Nº Pedido </label>
                                                                    <input class='form-control' name='nped' id='nped' type='text' value="<?php echo $row['osNPed']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Descrição da Tarefa<b style='color: red;'>*</b></label>
                                                                    <br>
                                                                    <small class="text-muted">As informações devem ser <b>claras e completas</b> para o operador compreender corretamente a tarefa</small>
                                                                    <textarea class="form-control color-bg-dark color-txt-wh" name="descricao" id="descricao" rows="3" onkeyup="limite_textarea(this.value)" maxlength="400"><?php echo $row['osDescricao']; ?></textarea><br><br>
                                                                    <div class="row d-flex justify-content-start p-0 m-0">
                                                                        <small class="pl-2 text-muted" style="margin-top: -40px !important;"><small class="text-muted" id="cont">400</small> Caracteres restantes</small>
                                                                    </div>
                                                                </div>
                                                                <script>
                                                                    $(document).ready(function() {
                                                                        limite_textarea(document.getElementById("descricao").value);
                                                                    });

                                                                    function limite_textarea(valor) {
                                                                        quant = 400;
                                                                        total = valor.length;
                                                                        if (total <= quant) {
                                                                            resto = quant - total;
                                                                            document.getElementById('cont').innerHTML = resto;
                                                                        } else {
                                                                            document.getElementById('texto').value = valor.substr(0, quant);
                                                                        }
                                                                    }
                                                                </script>
                                                            </div>

                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Observações</label>
                                                                    <input class='form-control' name='obs' id='obs' type='text' value="<?php echo $row['osObs']; ?>">
                                                                </div>
                                                            </div>


                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" id="update" class="btn btn-fab">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
            include_once 'php/footer_updateprop.php';
        }
    } else {

        header("location: ../index");
        exit();
    }
    ?>