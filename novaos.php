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
                                    <h5 class="font-weight-regular" style="text-align: center;">ORDEM DE SERVIÇO</h5>
                                    <h6 class="font-weight-regular" style="text-align: center;">Form 006 Rev 00</h6>
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
                                    <h4 class="text-fab">Dados da OS</h4>

                                    <!-- Componentes radios para criar a condição de mudança do formulário -->
                                    <div class="col form-group d-inline-block flex m-2 p-0">
                                            <label class='d-block control-label' style='color:black;'>Selecione o tipo de serviço <b style='color: red;'>*</b></label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="Ordem de Serviço(OS)" name="ordemdeservico" id="radioOS" required />
                                                <label class="form-check-label">Ordem de Serviço(OS)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="Ordem de Manutenção(OM)" name="ordemdeservico" id="radioOM" required />
                                                <label class="form-check-label">Ordem de Manutenção(OM)</label>
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
                                                    <option value=" <?php echo $rowEtapa['etapaNome']; ?>"><?php echo $rowEtapa['etapaNome']; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data limite para execução da tarefa <b style='color: red;'>*</b></label>
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


                                    <!-- removido as classes bootstrap d-flex e d-block e substitutindo por um style -->
                                    <div style="display: none;" class='justify-content-around' id="lote-pedido" >
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Lote </label>
                                            <input class='form-control' name='lote' id='lote' type='text' placeholder="Digite o número do lote...">
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Nº Pedido </label>
                                            <input class='form-control' name='nped' id='nped' type='text' placeholder="Digite o número do pedido...">
                                        </div>
                                    </div>


                                    <!-- nova propriedade caso o fomulário seja para OM -->
                                    <div style="display: none;" class='justify-content-around' id="nomeNumero-maquina" >
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Máquina </label>
                                            <input class='form-control' name='nomeMaquina' id='inomeMaquina' type='text' placeholder="Digite o nome da máquina...">
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Nº Máquina</label>
                                            <input class='form-control' name='nmaquina' id='nmaquina' type='text' placeholder="Digite o número da máquina...">
                                        </div>
                                    </div>

                                    <script>
                                        // Capturando os elementos do formulário
                                        var lotePedido = document.getElementById('lote-pedido');
                                        var maquina = document.getElementById('nomeNumero-maquina');
                                        var radioOS = document.getElementById('radioOS');
                                        var radioOM = document.getElementById('radioOM');

                                        // Função para verificar o tipo de formulário se é OM ou OS
                                        function verificarSelecao() {
                                            if (radioOS.checked) {

                                                lotePedido.style.display= "flex";

                                            } else {
                                                lotePedido.style.display= "none";
                                            }

                                            if (radioOM.checked) {
                                                maquina.style.display= "flex";
                                            } else {
                                                maquina.style.display= "none";
                                            }
                                        }

                                        // Adiciona um event listener para o evento 'change' em ambos os botões de rádio
                                        radioOS.addEventListener('change', verificarSelecao);
                                        radioOM.addEventListener('change', verificarSelecao);

                                    </script>

                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Descrição da Tarefa, detalhar de <b>forma clara</b> as informações mais importantes <b style='color: red;'>*</b></label>
                                            <br>
                                            <small class="text-muted">As informações devem ser <b>claras e completas</b> para o operador compreender corretamente a tarefa</small>
                                            <textarea class="form-control color-bg-dark color-txt-wh" name="descricao" id="descricao" rows="3" onkeyup="limite_textarea(this.value)" maxlength="400"></textarea><br><br>
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
                                    <div class="d-flex d-block justify-content-around align-items-center">
                                        <div class="col form-group d-inline-block flex-fill m-2">
                                            <label class='d-block control-label' style='color:black;'>Grau de urgência da tarefa <b style='color: red;'>*</b></label>
                                            <div class="form-check form-check-inline">
                                                <small class="form-check-label">Pode aguardar</small>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="1" name="grauurgencia" />
                                                <label class="form-check-label">1</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="2" name="grauurgencia" />
                                                <label class="form-check-label">2</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="3" name="grauurgencia" />
                                                <label class="form-check-label">3</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="4" name="grauurgencia" />
                                                <label class="form-check-label">4</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" value="5" name="grauurgencia" />
                                                <label class="form-check-label">5</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <small class="form-check-label">Executar o quanto antes</small>
                                            </div>
                                        </div>
                                        <div class="col form-group d-inline-block flex-fill m-2">
                                            <label class='control-label d-block' style='color:black;'>Arquivos necessário para a execução da tarefa devem ser anexados aqui ou possuir link de acesso presente na descrição da atividade</label>
                                            <div class="d-flex justify-content-center p-2 border rounded bg-light">
                                                <div>
                                                    <label class="d-block" for="formFile" style="text-align: center;"><i class="fas fa-upload fa-3x hovericon"></i></label>
                                                    <small class="d-block" id="file-name" style="text-align: center; color: green;"></small>
                                                    <span class="filedata"></span>
                                                    <span class="loading d-none">Carregando arquivo...</span>
                                                </div>
                                            </div>
                                            
                                            <input class="form-control" type="file" id="formFile" name="formFile" onchange="getImageData(event)" hidden>
                                            <small class="text-muted">Imagens, dxf, desenhos...</small>
                                            <div class="progressBar">
                                                <div class="progress"></div>
                                            </div>
                                            <script>
                                                updateList = function() {
                                                    var input = document.getElementById('formFile');
                                                    var output = document.getElementById('file-name');

                                                    output.innerHTML = '';
                                                    for (var i = 0; i < input.files.length; ++i) {
                                                        output.innerHTML += input.files.item(i).name + ', ';
                                                    }
                                                }
                                            </script>
                                            <style>
                                                .hovericon {
                                                    transition: ease all 0.2s;
                                                }

                                                .hovericon:hover {
                                                    transform: scale(0.9);
                                                    cursor: pointer;
                                                }


                                                .progressBar {
                                                    width: 100%;
                                                    background: rgb(196, 193, 193);
                                                    padding: 15px 20px;
                                                    position: relative;
                                                }

                                                .progress {
                                                    height: 100%;
                                                    width: 0%;
                                                    background: linear-gradient(90deg, rgba(213,213,213,1) 0%, rgba(0,122,90,1) 71%);
                                                    position: absolute;
                                                    left: 0;
                                                    top: 0;
                                                    bottom: 0;
                                                    display: flex;
                                                    justify-content: center;
                                                    align-items: center;
                                                    color: white;
                                                }
                                            </style>
                                        </div>

                                    </div>
                                    <div class='d-none'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Url</label>
                                            <input class='form-control urlThrowback' name='urlThrowback' id='urlThrowback' type='text'>
                                        </div>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Observações</label>
                                            <input class='form-control' name='obs' id='obs' type='text'>
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