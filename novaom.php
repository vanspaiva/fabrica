<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';

    print_r($_SESSION);

    if(isset($_GET["t"]) && ($_GET["t"] == "om")){
        $tipo = "om";
    } else if(isset($_GET["t"]) && ($_GET["t"] == "os")){
        $tipo = "os";
    } else{
        $tipo = null;
    }
?>


    <body class="bg-light-gray2">
        <style>
            #areas-adm, #banheiro,#copa-cozinha,#producao{
                /* display: none; */
            }
        </style>
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
                    <div class="card" style="">
                        <div class="card-body">

                            <?php
                            $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                            while ($row = mysqli_fetch_array($ret)) {

                                $tpconta_criacao = $_SESSION["userperm"];
                                $user_criacao = $_SESSION["useruid"];
                                $email_criador = $row['usersEmail'];

                                date_default_timezone_set('UTC');
                                $dtz = new DateTimeZone("America/Sao_Paulo");
                                $dt = new DateTime("now", $dtz);
                                $data_criacao = $dt->format("d/m/Y") . " " . $dt->format("H:i:s");

                                $localIP = getHostByName(getHostName());
                            ?>

                                <form action="includes/novaos.inc.php" method="POST" enctype='multipart/form-data'>
                                    <div hidden>
                                        <h4 class="text-fab">Dados do Usuário</h4>
                                        <div class="d-flex d-block justify-content-around">
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">Tipo de Conta</label>
                                                <input class="form-control" name="tp_contacriador" id="tp_contacriador" type="text" value="<?php echo $tpconta_criacao; ?>" readonly />
                                            </div>
                                            <div class="form-group d-inline-block flex-fill m-2">
                                                <label class="control-label" style="color:black;">Usuário</label>
                                                <input class="form-control" name="nomecriador" id="nomecriador" type="text" value="<?php echo $user_criacao; ?>" readonly>
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
                            
                                    <div class="d-flex align-items-center justify-content-end">
                                            <button type="button"class="btn btn-fab" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">+ Nova Área Administrativa</button>
                                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Adionar Nova Área Administrativa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Informe o setor</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Enviar</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                            <button type="button"class="btn btn-fab m-2" data-toggle="modal" data-target="#exampleModal2" data-whatever="@getbootstrap">+ Novo Responsável</button>
                                            <div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Adionar Novo Responsável</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                    <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Nome do responsável</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                    </div>
                                                    </form>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                    <button type="button" class="btn btn-primary">Enviar</button>
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="justify-content-around align-items-center">
                                            <div class="form-group mx-2 ">
                                                <label class='d-block control-label' style='color:black;'>Escolha o Setor <b style='color: red;'>*</b></label>

                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="1" name="grauurgencia" id="areas-adm-radio"/>
                                                    <label class="form-check-label">1. Áreas Administrativas</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="2" name="grauurgencia" id="banheiro-radio" />
                                                    <label class="form-check-label">2. Banheiro</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="3" name="grauurgencia" id="copa-cozinha-radio"/>
                                                    <label class="form-check-label">3. Copa / Cozinha</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" value="4" name="grauurgencia" id="producao-radio"/>
                                                    <label class="form-check-label"> 4.Produção</label>
                                                </div>
                                            </div>


                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label'>Selecione a área ser administrada<b style='color: red;'>*</b></label>
                                            <select class='form-control' name='setor' id='setor' required>
                                                <option value='0' selected style='color: #F6F7FA;'>Escolha um setor</option>
                                                <option value='banheiro-superior-masculino'>Banheiro superior masculino</option>
                                                <option value='banheiro-superior-feminino'>Banheiro superior feminino</option>
                                                <option value='banheiro-terreo-masculino'>Banheiro térreo masculino</option>
                                                <option value='banheiro-terreo-feminino'>Banheiro térreo feminino</option>
                                                <option value='lounge'>Lounge</option>
                                                <option value='sala-reuniao'>Sala reunião</option>
                                                <option value='sala-dr-rander'>Sala Dr. Rander</option>
                                                <option value='sala-comercial'>Sala comercial</option>
                                                <option value='sala-administrativo'>Sala administrativo</option>
                                                <option value='sala-descanso'>Sala de descanso</option>
                                                <option value='fabrica'>Fábrica</option>
                                                <option value='planejamento'>Planejamento</option>
                                                <option value='refeitorio'>Refeitório</option>
                                                <option value='estoque'>Estoque</option>
                                                <option value='osteofix'>Osteofix</option>
                                                <option value='pcp'>PCP</option>
                                                <option value='liberacao'>Liberação</option>
                                                <option value='sala-limpa'>Sala Limpa</option>
                                            </select>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data da execução da tarefa<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dtentrega' id='dtentrega' type='date' required>
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
                                        </script>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Periodo da realização<b style='color: red;'>*</b></label>
                                            <select class="custom-select" aria-label="Default select example" required>
                                                <option value="1">Selecione um periodo</option>
                                                <option value="2">Manhã</option>
                                                <option value="3">Tarde</option>
                                                <option value="4">Noite</option>
                                            </select>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                            <select class="custom-select" aria-label="Default select example" required>
                                                <option >Selecione um responsável</option>
                                                <option value="2">Kellyta</option>
                                                <option value="3">Edson</option>
                                                <option value="4">Joilza</option>
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
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia1" value="1" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia1"> 1. Vidros e Divisórias</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia2" value="2" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia2">2. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia3" value="3" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia3">3. Prateleiras/Armários</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia4" value="4" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia4">4. Bancadas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia5" value="5" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia5">5. Ar-condicionado</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia6" value="6" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia6">6. Paredes / Tomadas/ Rodapé</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia7" value="7" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia7">7. Lixeiras</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia8" value="8" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia8">8. Portas / Janelas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia9" value="9" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia9">9. Persianas</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia10" value="10" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia10">10. Computadores</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia11" value="11" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia11"> 11. Escadas/Corrimão</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-adm" type="checkbox" id="grauurgencia12" value="12" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia12">12. Filtros/ Máquinas de Café</label>
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
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia1" value="1" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia1"> 1. Sanitário</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia2" value="2" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia2">2. Pia</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia3" value="3" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia3">3. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia4" value="4" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia4">4. Espelho</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia5" value="5" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia5">5. Reposição de papel higiênico</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia6" value="6" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia6">6. Reposição de papel toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia7" value="7" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia7">7. Reposição de sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia8" value="8" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia8">8. Lixeira</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia9" value="9" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia9">9. Portas/ Janelas</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-banheiro" type="checkbox" id="grauurgencia10" value="10" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia10">10. Luminárias</label>
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
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia1" value="1" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia1"> 1. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia2" value="2" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia2">2. Pia</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia3" value="3" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia3">3. Mesa</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia4" value="4" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia4">4. Geladeira</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia5" value="5" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia5">5. Reposição de papel toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia6" value="6" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia6">6. Reposição de Sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia7" value="7" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia7">7. Paredes/ Tomadas/ Rodapés</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia8" value="8" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia8">8. Filtros/Máquina de café</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia9" value="9" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia9">9. Fogão</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-copa-cozinha" type="checkbox" id="grauurgencia10" value="10" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia10">10. Microondas/ Torradeira</label>
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
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia1" value="1" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia1"> 1. Vidros e Divisórias</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia2" value="2" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia2">2. Piso</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia3" value="3" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia3">3. Prateleiras/Armários</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia4" value="4" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia4">4. Bancadas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="5">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia5" value="5" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia5">5. Ar-condicionado</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia6" value="6" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia6">6. Paredes / Tomadas/ Rodapé</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia7" value="7" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia7">7. Lixeiras</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia8" value="8" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia8">8. Portas / Janelas</label>
                                                        </div>
                                                    </li>
                                                </ol>
                                            </div>
                                            <div class="col-sm-3">
                                                <ol start="9">
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia9" value="9" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia9">9. Computadores</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia10" value="10" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia10">10. Reposição de Papel Toalha</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input check-producao" type="checkbox" id="grauurgencia11" value="11" name="grauurgencia" />
                                                            <label class="form-check-label" for="grauurgencia11"> 11. Reposição de Sabonete</label>
                                                        </div>
                                                    </li>
                                                    <li>
                                        
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input check-producao" type="checkbox" id="grauurgencia12" value="12" name="grauurgencia" />
                                                    <label class="form-check-label" for="grauurgencia12">12. Reposição de Touca</label>
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

    </body>

    </html>
    <?php
            }
        } else {
            header("location: login");
            exit();
        }

    ?>



