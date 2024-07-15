<?php
session_start();

if (isset($_SESSION["useruid"])) {

    include("php/head_updateprop.php");
    require_once 'db/dbh.php';
    $user = $_SESSION["useruid"];

?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';

        $omid = $_GET['id'];

        $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omId='" . $omid . "';");
        while ($row = mysqli_fetch_array($ret)) {
            $fileNameOs = $row['omNomeArquivo'];
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
                                        <h2>Informações da Ordem de Manutenção - <?php echo $omid; ?> </h2>
                                    </div>
                                </div>
                                <?php
                                if ($fileNameOs != null) {
                                ?>
                                    <div class="col-sm pt-2">
                                        <div class="d-flex justify-content-center p-1">
                                            <!-- <a href="<?php //echo $fileNameOs 
                                                            ?>" class="btn btn-outline-fab" download><i class="bi bi-cloud-arrow-down"></i> Download Arquivo</a> -->
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
                                                        <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updateom.inc.php" method="POST">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="omid">OM ID</label>
                                                                    <input type="number" class="form-control" id="omid" name="omid" value="<?php echo $row['omId']; ?>" required readonly>
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

                                                                                    <option value="<?php echo $rowStatus['stNome']; ?>" <?php if (trim($row['omStatus']) == trim($rowStatus['stNome'])) echo ' selected="selected"'; ?>><?php echo $rowStatus['stNome']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col form-group d-inline-block flex-fill m-2">
                                                                            <label class='d-block control-label' style='color:black;'>Grau de urgência da tarefa <b style='color: red;'>*</b></label>
                                                                            <select class='form-control' name='grau' id='grau' required>
                                                                                <option value='0' selected style='color: #F6F7FA;'>Escolha um grau</option>

                                                                                <option value="1" <?php if ($row['omGrauUrgencia'] == 1) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>1</option>
                                                                                <option value="2" <?php if ($row['omGrauUrgencia'] == 2) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>2</option>
                                                                                <option value="3" <?php if ($row['omGrauUrgencia'] == 3) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>3</option>
                                                                                <option value="4" <?php if ($row['omGrauUrgencia'] == 4) {
                                                                                                        echo ' selected="selected"';
                                                                                                    } ?>>4</option>
                                                                                <option value="5" <?php if ($row['omGrauUrgencia'] == 5) {
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

                                                                            <option value="<?php echo $rowEtapa['etapaNome']; ?>" <?php if (trim($row['omSetor']) == trim($rowEtapa['etapaNome'])) echo ' selected="selected"'; ?>><?php echo $rowEtapa['etapaNome']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data Desejada <b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='dtentrega' id='dtentrega' type='date' value="<?php echo $row['omDtEntregasDesejada']; ?>" required readonly>
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
                                                                    <input class='form-control' name='dtrealentrega' id='dtrealentrega' type='date' value="<?php echo $row['omDtEntregaReal']; ?>" required>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data Execução Tarefa </label>
                                                                    <input class='form-control' name='dtexecucao' id='dtexecucao' type='date' value="<?php echo $row['dtExecucao']; ?>">
                                                                </div>

                                                            </div>
                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Nº Máquina </label>
                                                                    <input class='form-control' name='idMaquina' id='idMaquina' type='text' value="<?php echo $row['idMaquina']; ?>">
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Nome Máquina</label>
                                                                    <input class='form-control' name='omNomeMaquina' id='omNomeMaquina' type='text' value="<?php echo $row['omNomeMaquina']; ?>" readonly>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Marca/ Modelo / N° Serie</label>
                                                                    <input class='form-control' name='omIdentificadorMaquina' id='omIdentificadorMaquina' type='text' value="<?php echo $row['omIdentificadorMaquina']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class='d-flex d-block justify-content-around'>
                                                                <!--                                                                 <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label for="">Tipo de Manutenção</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tipomanutencao" id="tipomanutencao1" value="preventiva" <?php if ($row['omTipoManutencao'] == 'preventiva') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="tipomanutencao1">
                                                                            Manutenção preventiva
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="tipomanutencao" id="tipomanutencao2" value="corretiva" <?php //if ($row['omTipoManutencao'] == 'corretiva') echo 'checked'; 
                                                                                                                                                                                    ?>>
                                                                        <label class="form-check-label" for="tipomanutencao2">
                                                                            Manutenção corretiva
                                                                        </label>
                                                                    </div>
                                                                </div> -->
                                                                <!--                                                                 <div class="form-group d-inline-block flex-fill m-2">
                                                                    <label for="">A maquina está operacional</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="operacional" id="operacional1" value="sim" <?php //if ($row['omOperacional'] == 'sim') echo 'checked'; 
                                                                                                                                                                        ?>>
                                                                        <label class="form-check-label" for="operacional1">
                                                                            Sim
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="operacional" id="operacional2" value="não" <?php //if ($row['omOperacional'] == 'não') echo 'checked'; 
                                                                                                                                                                        ?>>
                                                                        <label class="form-check-label" for="operacional2">
                                                                            Não
                                                                        </label>
                                                                    </div>
                                                                </div> -->
                                                                <div class="form-group d-inline-block flex-fill m-2">
                                                                    <label for="">Ação da qualidade</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="acaoquali" id="acaoquali1" value="op1" <?php if ($row['omAcaoQualidade'] == 'op1') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="acaoquali1">
                                                                            verificar a plaquinha de não operacional
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="acaoquali" id="acaoquali2" value="op2" <?php if ($row['omAcaoQualidade'] == 'op2') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="acaoquali2">
                                                                            verificar se realmente deve estar operacional
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Descreva a manutenção que precisa ser feita <b style='color: red;'>*</b></label>
                                                                    <br>
                                                                    <small class="text-muted">As informações devem ser <b>claras e completas</b> para o operador compreender corretamente a tarefa</small>
                                                                    <textarea class="form-control color-bg-dark color-txt-wh" name="descricao" id="descricao" rows="3" onkeyup="limite_textarea(this.value)" maxlength="400"><?php echo $row['omDescricao']; ?></textarea><br><br>
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
                                                                    <label for="">Necessidade de requalificação</label>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="requalificar" id="requalificar1" value="não" <?php if ($row['omRequalificar'] == 'não') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="requalificar1">
                                                                            Não requalificar
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" name="requalificar" id="mrequalificar" value="sim" <?php if ($row['omRequalificar'] == 'sim') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="requalificar2">
                                                                            Requalificar
                                                                        </label>
                                                                    </div>
                                                                </div>

                                                                <div id="responsavel-container" class='form-group <?php if (($row['omRequalificar'] == 'não') || ($row['omRequalificar'] == null)) echo ' d-none '; ?> flex-fill m-2'>
                                                                    <label class='control-label'>Responsável pela requalificação <b style='color: red;'>*</b></label>
                                                                    <select class='form-control' name='resprequali' id='resprequali'>
                                                                        <option value='0' selected style='color: #F6F7FA;'>Escolha um usuário</option>
                                                                        <?php
                                                                        $retEtapa = mysqli_query($conn, "SELECT * FROM users WHERE NOT usersPerm= '1ADM' ORDER BY usersName ASC;");
                                                                        while ($rowEtapa = mysqli_fetch_array($retEtapa)) { ?>
                                                                            <option value=" <?php echo $rowEtapa['usersId']; ?>" <?php if ($row['omIdRespRequalificar'] == $rowEtapa['usersId']) echo ' selected="selected"'; ?>><?php echo $rowEtapa['usersName']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>

                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label'>Responsável pela manutenção <b style='color: red;'>*</b></label>
                                                                    <select class='form-control' name='manutencao' id='manutencao' required>
                                                                        <option value='0' selected style='color: #F6F7FA;'>Escolha um usuário</option>
                                                                        <?php
                                                                        $retEtapa = mysqli_query($conn, "SELECT * FROM users WHERE NOT usersPerm= '1ADM' ORDER BY usersName ASC;");
                                                                        while ($rowEtapa = mysqli_fetch_array($retEtapa)) { ?>
                                                                            <option value=" <?php echo $rowEtapa['usersId']; ?>" <?php if ($row['omIdRespManutencao'] == $rowEtapa['usersId']) echo ' selected="selected"'; ?>><?php echo $rowEtapa['usersName']; ?></option>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>


                                                            <div class='d-flex d-block justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Observações</label>
                                                                    <input class='form-control' name='obs' id='obs' type='text' value="<?php echo $row['omObs']; ?>">
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
            ?>

            <script>
                document.addEventListener('DOMContentLoaded', function() {

                    // Adicionar event listener para os radio buttons
                    document.getElementsByName('requalificar').forEach(function(elem) {
                        elem.addEventListener('change', function(event) {
                            if (event.target.value === 'sim') {
                                // console.log("Sim");
                                document.getElementById('responsavel-container').classList.remove("d-none");
                            } else {
                                // console.log("Não");
                                document.getElementById('responsavel-container').classList.add("d-none");
                            }
                        });
                    });
                });
            </script>
    <?php
        }
    } else {

        header("location: ../index");
        exit();
    }
    ?>