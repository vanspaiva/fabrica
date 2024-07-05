<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';

    if(isset($_GET["t"]) && ($_GET["t"] == "om")){
        $tipo = "om";
    } else if(isset($_GET["t"]) && ($_GET["t"] == "os")){
        $tipo = "os";
    } else{
        $tipo = null;
    }
?>


    <body class="bg-light-gray2">
        <?php
            include_once 'php/navbar.php';
            include_once 'php/lateral-nav.php';

        ?>


        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Nova Proposta criada</p></div>";
                    } else if ($_GET["error"] == "fileerror") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Erro ao fazer upload do arquivo. Tente novamente!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">

                <div class="col-sm-12 mx-2 justify-content-start">
                    <div class="card">
                        <div class="card-head"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm py-2">
                                    <h3 class="font-weight-semibold" style="text-align: center;">Procedimento do Sistema de Gestão da Qualidade</h3>
                                    <h5 class="font-weight-regular" style="text-align: center;">REGISTRO DE LIMPEZA</h5>
                                    <h6 class="font-weight-regular" style="text-align: center;">FRM.INF.003</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 mx-2 py-4 justify-content-start">
                    <div class="card">
                        <div class="card-body">

                            <?php
                            
                            $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                            while ($row = mysqli_fetch_array($ret)) {

                                $tpconta_criacao = $_SESSION["userperm"];
                                $user_criacao = $_SESSION["useruid"];
                                $user_id = $_SESSION["userid"];
                                $email_criador = $row['usersEmail'];

                                date_default_timezone_set('UTC');
                                $dtz = new DateTimeZone("America/Sao_Paulo");
                                $dt = new DateTime("now", $dtz);
                                $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");
                                
                                $localIP = getHostByName(getHostName());
                            ?>
                                <form action="includes/insertrl003.inc.php" method="POST" enctype='multipart/form-data'>
                                    <div hidden>
                                        <h4 class="text-fab">Dados do Usuário</h4>
                                        <div class="d-flex d-block justify-content-around">
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">Tipo de Conta</label>
                                                <input class="form-control" name="tp_contacriador" id="tp_contacriador" type="text" value="<?php echo $tpconta_criacao; ?>" readonly />
                                            </div>
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">Usuário</label>
                                                <input class="form-control" name="idCriador" id="idCriador" type="text" value="<?php echo $user_id; ?>" readonly>
                                            </div>
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">E-mail</label>
                                                <input class="form-control" name="emailcriacao" id="emailcriacao" type="text" value="<?php echo $email_criador; ?>" readonly>
                                            </div>
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">Data Criação</label>
                                                <input class="form-control" name="dtcriacao" id="dtcriacao" type="text" value="<?php echo $data_criacao; ?>" readonly>
                                            </div>
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">IP</label>
                                                <input class="form-control" name="userip" id="userip" type="text" value="<?php echo $localIP; ?>" readonly>
                                            </div>
                                        </div>
                                        <hr>
                                    </div>
                                    <h4 class="text-fab">Dados da OM</h4>
                                        <div class="justify-content-around align-items-center">
                                            <div class="form-group mx-2">
                                                <label class='d-block control-label' style='color:black;'>Escolha o Setor <b style='color: red;'>*</b></label>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="1. Áreas Administrativas" name="setor" id="areas-adm-radio" <?php echo isset($_GET['setor']) && $_GET['setor'] == '1. Áreas Administrativas' ? 'checked' : ''; ?> required />
                                                    <label class="form-check-label" for="areas-adm-radio">1. Áreas Administrativas</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="2. Banheiro" name="setor" id="banheiro-radio"
                                                    <?php echo isset($_GET['setor']) && $_GET['setor'] == '2. Banheiro' ? 'checked' : ''; ?> />
                                                    <label class="form-check-label" for="banheiro-radio">2. Banheiro</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="3. Copa / Cozinha" name="setor" id="copa-cozinha-radio"  <?php echo isset($_GET['setor']) && $_GET['setor'] == '3. Copa / Cozinha' ? 'checked' : ''; ?> />
                                                    <label class="form-check-label" for="copa-cozinha-radio">3. Copa / Cozinha</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="4. Produção" name="setor" id="producao-radio"
                                                    <?php echo isset($_GET['setor']) && $_GET['setor'] == '4. Produção' ? 'checked' : ''; ?>/>
                                                    <label class="form-check-label" for="producao-radio">4. Produção</label>
                                                </div>
                                            </div>

                                        <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label for="validationDefault04">Informe o Deprtamento: </label>
                                            <select class="custom-select" id="validationDefault04" name="area-adm" required>
                                                <?php
                                                    if (isset($_GET['area-adm'])){

                                                        $resultadoADM = $_GET['area-adm'];
                                                    }
                                                
                                                ?>
                                                <option selected value="<?php echo isset($resultadoADM) ? $resultadoADM : "" ?>"><?php echo isset($resultadoADM) ? $resultadoADM : "Escolha um Departamento" ?></option>
                                            </select>
                                        </div>
                                        <script>

                                            document.querySelectorAll('input[name="setor"]').forEach(radio => {
                                                radio.addEventListener('change', function() {
                                                    getDepartamentos(this.value);
                                                });
                                            });

                                            function getDepartamentos(value) {
                                                var xhttp = new XMLHttpRequest();
                                                xhttp.onload = function() {
                                                    if (this.status === 200) {
                                                        var receiveRequest = JSON.parse(this.responseText);
                                                        populateSelect(receiveRequest); 
                                                    }
                                                };
                                                xhttp.open("GET", `get_departamentos003.php?value=${value}`, true);
                                                xhttp.send();
                                            }

                                            function populateSelect(data) {
                                                var select = document.getElementById("validationDefault04");

                                                // Limpa as opções existentes
                                                select.innerHTML = '<option selected disabled value="">Escolha um Departamento</option>';

                                                // Adiciona as novas opções baseadas nos dados recebidos
                                                data.forEach(function(option) {
                                                    var opt = document.createElement('option');
                                                    opt.appendChild(document.createTextNode(option));
                                                    opt.value = option;
                                                    select.appendChild(opt);
                                                });
                                            }

                                        </script>

                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data da execução da tarefa<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dtexec' id='dtexec' type='date' value="<?php echo date("Y-m-d")?>" required>
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
                                        </script>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Periodo da realização<b style='color: red;'>*</b></label>
                                            <select class="custom-select" name="periodo" aria-label="Default select example" required>
                                                <option selected disabled value="">Informe o periodo</option>
                                                    <?php

                                                        date_default_timezone_set('America/Sao_Paulo');

                                                        if(date("H") < 12){
                                                            echo "<option selected value='Manhã'> Manhã </option>";
                                                        }
                                                        elseif(date("H") > 12 && date("H") < 18){
                                                            echo "<option selected value='Tarde'> Tarde </option>";
                                                        }
                                                        else {
                                                            echo "<option selected value='Manhã'> Manhã </option>";
                                                            echo "<option selected value='Tarde'> Tarde </option>";
                                                            echo "<option selected value='Noite'> Noite </option>";
                                                        }
                                                    ?>
                                                
                                            </select>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                            <select class="custom-select" name="responsavel" aria-label="Default select example" required>
                                                <option value="" disabled selected>Selecione um responsável</option>
                                                <option value="Kellyta">Kellyta</option>
                                                <option value="Edson">Edson</option>
                                                <option value="Joilza">Joilza</option>
                                            </select>
                                        </div>
                                    </div>

                                    
                                    <div id="areas-adm">
                                        <div class="d-flex d-block mt-4 mx-4 ">
                                            <label class='d-block control-label' style='color:black;'>Selecione os tipos de limpeza realizados <b style='color: red;'>*</b></label>
                                        </div>
                                        <div class="row mx-2">
                                            <div class="col-sm-3">
                                                <ol>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv1-adm" value="1. Vidros e Divisórias" name="srv1" />
                                                            <label class="form-check-label" for="srv1-adm"> 1. Vidros e Divisórias</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv2-adm" value="2. Piso" name="srv2" />
                                                            <label class="form-check-label" for="srv2-adm">2. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv3-adm" value="3. Prateleiras/Armários" name="srv3" />
                                                            <label class="form-check-label" for="srv3-adm">3. Prateleiras/Armários</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv4-adm" value="4. Bancadas" name="srv4"/>
                                                            <label class="form-check-label" for="srv4-adm">4. Bancadas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv5-adm" value="5. Ar-condicionado" name="srv5" />
                                                            <label class="form-check-label" for="srv5-adm">5. Ar-condicionado</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv6-adm" value="6. Paredes / Tomadas/ Rodapé" name="srv6" />
                                                            <label class="form-check-label" for="srv6-adm">6. Paredes / Tomadas/ Rodapé</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv7-adm" value="7. Lixeiras" name="srv7" />
                                                            <label class="form-check-label" for="srv7-adm">7. Lixeiras</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv8-adm" value="8. Portas / Janelas" name="srv8" />
                                                            <label class="form-check-label" for="srv8-adm">8. Portas / Janelas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv9-adm" value="9. Persianas" name="srv9" />
                                                            <label class="form-check-label" for="srv9-adm">9. Persianas</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv10-adm" value="10. Computadores" name="srv10" />
                                                            <label class="form-check-label" for="srv10-adm">10. Computadores</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv11-adm" value="11. Escadas/Corrimão" name="srv11" />
                                                            <label class="form-check-label" for="srv11-adm"> 11. Escadas/Corrimão</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="srv12-adm" value="12. Filtros/ Máquinas de Café" name="srv12" />
                                                            <label class="form-check-label" for="srv12-adm">12. Filtros/ Máquinas de Café</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>







                                    <div id="banheiro">
                                        <div class="d-flex d-block mt-4 mx-4 ">
                                            <label class='d-block control-label' style='color:black;'>Selecione os tipos de limpeza realizados <b style='color: red;'>*</b></label>
                                        </div>
                                        <div class="row mx-2">
                                            <div class="col-sm-3">
                                                <ol>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv1-ban" value="1. Sanitário" name="srv1" />
                                                            <label class="form-check-label" for="srv1-ban"> 1. Sanitário</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv2-ban" value="2. Pia" name="srv2" />
                                                            <label class="form-check-label" for="srv2-ban">2. Pia</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv3-ban" value="3. Piso" name="srv3" />
                                                            <label class="form-check-label" for="srv3-ban">3. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv4-ban" value="4. Espelho" name="srv4" />
                                                            <label class="form-check-label" for="srv4-ban">4. Espelho</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv5-ban" value="5. Reposição de papel higiênico" name="srv5" />
                                                            <label class="form-check-label" for="srv5-ban">5. Reposição de papel higiênico</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv6-ban" value="6. Reposição de papel toalha" name="srv6" />
                                                            <label class="form-check-label" for="srv6-ban">6. Reposição de papel toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv7-ban" value="7. Reposição de sabonete" name="srv7" />
                                                            <label class="form-check-label" for="srv7-ban">7. Reposição de sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv8-ban" value="8. Lixeira" name="srv8" />
                                                            <label class="form-check-label" for="srv8-ban">8. Lixeira</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv9-ban" value="9. Portas/ Janelas" name="srv9" />
                                                            <label class="form-check-label" for="srv9-ban">9. Portas/ Janelas</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="srv10-ban" value="10. Luminárias" name="srv10" />
                                                            <label class="form-check-label" for="srv10-ban">10. Luminárias</label>
                                                        </div>
                                                    </li>

                                                </ol>
                                            </div>
                                        </div>
                                    </div>












                                    <div id="copa-cozinha">
                                        <div class="d-flex d-block mt-4 mx-4 ">
                                            <label class='d-block control-label' style='color:black;'>Selecione os tipos de limpeza realizados <b style='color: red;'>*</b></label>
                                        </div>
                                        <div class="row mx-2">
                                            <div class="col-sm-3">
                                                <ol>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv1-coz" value="1. Piso" name="srv1" />
                                                            <label class="form-check-label" for="srv1-coz"> 1. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv2-coz" value="2. Pia" name="srv2" />
                                                            <label class="form-check-label" for="srv2-coz">2. Pia</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv3-coz" value="3. Mesa" name="srv3" />
                                                            <label class="form-check-label" for="srv3-coz">3. Mesa</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv4-coz" value="4. Geladeira" name="srv4" />
                                                            <label class="form-check-label" for="srv4-coz">4. Geladeira</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv5-coz" value="5. Reposição de papel toalha" name="srv5" />
                                                            <label class="form-check-label" for="srv5-coz">5. Reposição de papel toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv6-coz" value="6. Reposição de Sabonete" name="srv6" />
                                                            <label class="form-check-label" for="srv6-coz">6. Reposição de Sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv7-coz" value="7. Paredes/ Tomadas/ Rodapés" name="srv7" />
                                                            <label class="form-check-label" for="srv7-coz">7. Paredes/ Tomadas/ Rodapés</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv8-coz" value="8. Filtros/Máquina de café" name="srv8" />
                                                            <label class="form-check-label" for="srv8-coz">8. Filtros/Máquina de café</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv9-coz" value="9. Fogão" name="srv9" />
                                                            <label class="form-check-label" for="srv9-coz">9. Fogão</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="srv10-coz" value="10. Microondas/ Torradeira" name="srv10" />
                                                            <label class="form-check-label" for="srv10-coz">10. Microondas/ Torradeira</label>
                                                        </div>
                                                    </li>
                                                    
                                                </ol>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="producao">
                                        <div class="d-flex d-block mt-4 mx-4 ">
                                            <label class='d-block control-label' style='color:black;'>Selecione os tipos de limpeza realizados <b style='color: red;'>*</b></label>
                                        </div>
                                        <div class="row mx-2">
                                            <div class="col-sm-3">
                                                <ol>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv1-prod" value="1. Vidros e Divisórias" name="srv1" />
                                                            <label class="form-check-label" for="srv1-prod"> 1. Vidros e Divisórias</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv2-prod" value="2. Piso" name="srv2" />
                                                            <label class="form-check-label" for="srv2-prod">2. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv3-prod" value="3. Prateleiras/Armários" name="srv3" />
                                                            <label class="form-check-label" for="srv3-prod">3. Prateleiras/Armários</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv4-prod" value="4. Bancadas" name="srv4" />
                                                            <label class="form-check-label" for="srv4-prod">4. Bancadas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv5-prod" value="5. Ar-condicionado" name="srv5" />
                                                            <label class="form-check-label" for="srv5-prod">5. Ar-condicionado</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv6-prod" value="6. Paredes / Tomadas/ Rodapé" name="srv6" />
                                                            <label class="form-check-label" for="srv6-prod">6. Paredes / Tomadas/ Rodapé</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv7-prod" value="7. Lixeiras" name="srv7" />
                                                            <label class="form-check-label" for="srv7-prod">7. Lixeiras</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv8-prod" value="8. Portas / Janelas" name="srv8"/>
                                                            <label class="form-check-label" for="srv8-prod">8. Portas / Janelas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv9-prod" value="9. Computadores" name="srv9" />
                                                            <label class="form-check-label" for="srv9-prod">9. Computadores</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv10-prod" value="10. Reposição de Papel Toalha" name="srv10" />
                                                            <label class="form-check-label" for="srv10-prod">10. Reposição de Papel Toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="srv11-prod" value="11. Reposição de Sabonete" name="srv11" />
                                                            <label class="form-check-label" for="srv11-prod"> 11. Reposição de Sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                        
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check-producao" type="checkbox" id="srv12-prod" value="12. Reposição de Touca" name="srv12" />
                                                    <label class="form-check-label" for="srv12-prod">12. Reposição de Touca</label>
                                                </div>
                                                    </li>
                                                </ol>
                                            </div>
                                        </div>
                                    </div>

                                    <script>                                     
                                        var areasAdm = document.getElementById('areas-adm');
                                        var banheiro = document.getElementById('banheiro');
                                        var copaCozinha = document.getElementById('copa-cozinha');
                                        var producao = document.getElementById('producao');

                                        var radioAreasAdm = document.getElementById('areas-adm-radio');
                                        var radioBanheiro = document.getElementById('banheiro-radio');
                                        var radioCopaCozinha = document.getElementById('copa-cozinha-radio');
                                        var radioProducao = document.getElementById('producao-radio');
                                        
                                        var checkAdm = document.querySelectorAll('.check-adm');
                                        var checkBanheiro = document.querySelectorAll('.check-banheiro');
                                        var checkCopaCozinha = document.querySelectorAll('.check-copa-cozinha');
                                        var checkProducao = document.querySelectorAll('.check-producao');


                                        function cancelarAdm(){
                                            checkAdm.forEach(function(checkbox) {
                                                checkbox.checked = false; // Unchecks the checkbox
                                                checkbox.disabled = true; // Disables the checkbox  
                                            });
                                        }
                                        function aprovarAdm(){
                                            checkAdm.forEach(function(checkbox) {
                                                checkbox.disabled = false; // Disables the checkbox  
                                            });
                                        }

                                        function cancelarBanheiro(){
                                            checkBanheiro.forEach(function(checkbox) {
                                                checkbox.checked = false; // Unchecks the checkbox
                                                checkbox.disabled = true; // Disables the checkbox  
                                            });
                                        }
                                        function aprovarBanheiro(){
                                            checkBanheiro.forEach(function(checkbox) {
                                                checkbox.disabled = false; // Disables the checkbox  
                                            });                                            
                                        }

                                        function cancelarCopaCozinha(){
                                            checkCopaCozinha.forEach(function(checkbox) {
                                                checkbox.checked = false; // Unchecks the checkbox
                                                checkbox.disabled = true; // Disables the checkbox  
                                            });
                                        }
                                        function aprovarCopaCozinha(){
                                            checkCopaCozinha.forEach(function(checkbox) {
                                                checkbox.disabled = false; // Disables the checkbox  
                                            });                                                
                                        }
                                        function cancelarProducao(){
                                            checkProducao.forEach(function(checkbox) {
                                                checkbox.checked = false; // Unchecks the checkbox
                                                checkbox.disabled = true; // Disables the checkbox  
                                            });
                                        }
                                        function aprovarProducao(){
                                          checkProducao.forEach(function(checkbox) {
                                                checkbox.disabled = false   ; // Disables the checkbox  
                                            });
                                        }


                                        function toggleSections() {
                                            areasAdm.style.display = radioAreasAdm.checked ? 'block' : 'none';
                                            banheiro.style.display = radioBanheiro.checked ? 'block' : 'none';
                                            copaCozinha.style.display = radioCopaCozinha.checked ? 'block' : 'none';
                                            producao.style.display = radioProducao.checked ? 'block' : 'none';

                                            if (radioAreasAdm.checked) {
                                                aprovarAdm();
                                                cancelarBanheiro();
                                                cancelarCopaCozinha();
                                                cancelarProducao();
                                            }
                                            if(radioBanheiro.checked){
                                                aprovarBanheiro();
                                                cancelarAdm();
                                                cancelarCopaCozinha();
                                                cancelarProducao();
                                            }
                                            if(radioCopaCozinha.checked){
                                                aprovarCopaCozinha();
                                                cancelarAdm();
                                                cancelarProducao();
                                                cancelarBanheiro();
                                            }
                                            if(radioProducao.checked){
                                                aprovarProducao();
                                                cancelarAdm();
                                                cancelarBanheiro();
                                                cancelarCopaCozinha();
                                            }
                                             
                                            
                                        }

                                        radioAreasAdm.addEventListener('change', toggleSections);
                                        radioBanheiro.addEventListener('change', toggleSections);
                                        radioCopaCozinha.addEventListener('change', toggleSections);
                                        radioProducao.addEventListener('change', toggleSections);

                                        
                                        toggleSections(); 

                                    </script>
                                    </div>
                                    <div class='d-none'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Url</label>
                                            <input class='form-control urlThrowback' name='urlThrowback' id='urlThrowback' type='text'>
                                        </div>
                                    </div>

                                    <div class="py-4 col d-flex justify-content-center">
                                        <button class="btn btn-fab" type="submit" name="submit" id="submit" >Enviar</button>
                                    </div>

                                </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>
        <script>
            <?php require_once "config/firebaseConfig.php"; ?>
            const firebaseConfig = <?php echo json_encode($firebaseConfig); ?>;
        </script>

        <script src="js/uploadToFirebase.js"></script>
     <?php include_once 'php/footer_index.php' ?>

    </body>

    </html>
    <?php
            }
        } else {
            header("location: login");
            exit();
        }

    ?>



