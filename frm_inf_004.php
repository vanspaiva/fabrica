<?php
session_start();

// Incluir cabeçalhos e conexão com banco de dados
include("php/head_index.php");
require_once 'db/dbh.php';

// Verificar se o usuário está autenticado
if (isset($_SESSION["useruid"])) {
    $useruid = $_SESSION["useruid"];

    // Função para obter o ID do usuário
    function getUserId($conn, $useruid)
    {
        $stmt = $conn->prepare("SELECT usersId FROM users WHERE usersUid = ?");
        $stmt->bind_param("s", $useruid);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['usersId'];
        } else {
            return null; // Retorna null se nenhum usuário for encontrado
        }
    }

    // Obter o ID do usuário
    $userId = getUserId($conn, $useruid);

    if ($userId !== null) {
        // Processar o formulário quando enviado
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
            // Obter dados do formulário
            $dataPublicacao = $_POST['dataPublicacao'];
            $identificadorAmbiente = $_POST['identificadorAmbiente'];
            $tipoAtividade = $_POST['tipoAtividade'];

            // Calcular a data de validade
            $dataValidade = date('d-m-y', strtotime($dataPublicacao . ' + 2 years'));

            // Inserir na tabela FRM_INF_004
            $marcaModelo = "Springer";

            $sql = "INSERT INTO FRM_INF_004 (data_publicacao, data_validade, modelo, identificacao_ambiente, tipo_atividade, usersId) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssi", $dataPublicacao, $dataValidade, $marcaModelo, $identificadorAmbiente, $tipoAtividade, $userId);
                mysqli_stmt_execute($stmt);
                $frmInfId = mysqli_insert_id($conn); // Obter o ID inserido

                // Capturar a data de manutenção do formulário (se estiver disponível no formulário)
                $dataManutencao = $_POST['dataManutencao'];

                // Verificar se checkboxes foram selecionados
                if (isset($_POST['executado']) && is_array($_POST['executado']) && !empty($_POST['executado'])) {
                    $descricaoAtividadeIds = $_POST['executado'];
                    $descricaoAtividadeIdsJson = json_encode($descricaoAtividadeIds);


                    $sql = "INSERT INTO atividades_executadas (data_manutencao, frm_inf_004_id, descricao_atividade) VALUES (?, ?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $dataManutencao, $frmInfId, $descricaoAtividadeIdsJson);
                    $stmt->execute();
                }
            } else {
                echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>Erro ao preparar consulta SQL.</p></div>";
            }
        }
    } else {
        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Usuário não encontrado.</p></div>";
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
                                    <h3 class="font-weight-semibold" style="text-align: center;">Registro de Manutenção Preventiva e Limpeza de Ar-Condicionado</h3>
                                    <h5 class="font-weight-regular" style="text-align: center;">Formulário</h5>
                                    <h6 class="font-weight-regular" style="text-align: center;">FRM.INF.004</h6>
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

                                <form action="" method="POST">
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
                                    <h4 class="text-fab">Dados de Registro</h4>

                                    <div class='d-flex justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data de Publicação<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' required>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Validade</label>
                                            <input class='form-control' name='dataValidade' id='dataValidade' type='date' readonly>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('dataPublicacao').addEventListener('change', function() {
                                            // Obter a data de publicação inserida
                                            var dataPublicacao = new Date(this.value);

                                            // Calcular a data de validade (dois anos após a data de publicação)
                                            var doisAnosDepois = new Date(dataPublicacao);
                                            doisAnosDepois.setFullYear(dataPublicacao.getFullYear() + 2);
                                            doisAnosDepois.setDate(doisAnosDepois.getDate() + 1);

                                            // Verificar se o ano é bissexto e ajustar a data de validade, se necessário
                                            if (doisAnosDepois.getMonth() === 1 && doisAnosDepois.getDate() === 29) {
                                                // Se a data de validade é 29 de fevereiro, ajuste para 28 de fevereiro se o próximo ano não for bissexto
                                                if (!isBissexto(doisAnosDepois.getFullYear() + 1)) {
                                                    doisAnosDepois.setDate(28);
                                                }
                                            }

                                            // Formatar a data de validade para o formato "YYYY-MM-DD"
                                            var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                            var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                            var ano = doisAnosDepois.getFullYear();
                                            var dataValidadeFormatada = ano + "-" + mes + "-" + dia;

                                            // Exibir a data de validade no campo de "Validade"
                                            document.getElementById('dataValidade').value = dataValidadeFormatada;
                                        });

                                        function isBissexto(ano) {
                                            return (ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0);
                                        }
                                    </script>

                                    <div class='d-flex justify-content-between'>
                                        <div class='form-group col-md-4 m-2'>
                                            <label class='control-label'>Setor<b style='color: red;'>*</b></label>
                                            <select class="form-control" name='descricao_setores' id='descricao_setores'>
                                                <option value="">Selecione um Setor</option>
                                                <option value="1">Estoque CPMH</option>
                                                <option value="2">Estoque Osteofix</option>
                                                <option value="3">PCP</option>
                                                <option value="4">Sala Impressoras</option>
                                                <option value="5">Sala Planejamento</option>
                                                <option value="6">Sala Inspeção Qualidade</option>
                                                <option value="7">Sala Reunião Terreo</option>
                                                <option value="8">ADM / Financeiro</option>
                                                <option value="9">Marketing / Comercial</option>
                                                <option value="10">Sala Diretoria Comercial</option>
                                                <option value="11">Sala Jogos</option>
                                                <option value="12">Auditório</option>
                                                <option value="13">Presidência</option>
                                                <option value="14">Lounge</option>
                                                <option value="15">Sala Reunião 1º Andar</option>
                                                <option value="16">Sala Fotografia</option>
                                            </select>
                                        </div>

                                        
                                        <div class='form-group col-md-4 m-2'>
                                            <label class="control-label" style="color: black;">Responsável <b style="color: red;">*</b></label>
                                            <input class="form-control" name="responsavel" id="responsavel" style="text-transform: capitalize;" value="<?php echo $_SESSION["userfirstname"]; ?>">
                                        </div>

                                        <div class='form-group col-md-2 m-2'>
                                            <label class='control-label'>Marca/Modelo</label>
                                            <input class='form-control' name='marcaModelo' id='marcaModelo' value='Springer' readonly>
                                        </div>
                                    </div>


                                    <!-- Descrição das atividades -->
                                    <script>
                                        function validarFormulario(event) {
                                            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                                            var selecionado = Array.from(checkboxes).some(checkbox => checkbox.checked);

                                            if (!selecionado) {
                                                alert("Por favor, selecione ao menos uma atividade executada na manuntenção.");
                                                event.preventDefault(); // Impede o envio do formulário
                                            }
                                        }

                                        document.addEventListener('DOMContentLoaded', (event) => {
                                            var formulario = document.querySelector('form');
                                            formulario.addEventListener('submit', validarFormulario);
                                        });
                                    </script>

                                    <div class='d-flex justify-content-center' style="margin-top: 50px;">
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data da Manutenção<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dataManutencao' id='dataManutencao' type='date' required>
                                        </div>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <table class="table" style="font-size: 1rem; margin: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; font-size: 1.2rem;">Descrição das Atividades</th>
                                                        <th style="text-align: center; font-size: 1.2rem;">Executado</th>
                                                        <th style="display: none; text-align: center; font-size: 1.2rem;">Responsável</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Verificação e drenagem da água</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[1]" value="1"></td>
                                                        <td><input type="text" name="responsavel[1]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px" value="<?php echo $_SESSION["userfirstname"]; ?>"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[2]" value="2"></td>
                                                        <td><input type="text" name="responsavel[2]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[3]" value="3"></td>
                                                        <td><input type="text" name="responsavel[3]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[4]" value="4"></td>
                                                        <td><input type="text" name="responsavel[4]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trocar filtros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[5]" value="5"></td>
                                                        <td><input type="text" name="responsavel[5]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Verificação da fixação</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[6]" value="6"></td>
                                                        <td><input type="text" name="responsavel[6]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Verificação de vazamentos nas ligações flexíveis</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[7]" value="7"></td>
                                                        <td><input type="text" name="responsavel[7]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estado de conservação do isolamento termo-acústico</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[8]" value="8"></td>
                                                        <td><input type="text" name="responsavel[8]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vedação dos painéis de fechamento do gabinete</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[9]" value="9"></td>
                                                        <td><input type="text" name="responsavel[9]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Manutenção mecânica</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[10]" value="10"></td>
                                                        <td><input type="text" name="responsavel[10]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Manutenção elétrica</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[11]" value="11"></td>
                                                        <td><input type="text" name="responsavel[11]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>outros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[12]" value="12"></td>
                                                        <td><input type="text" name="responsavel[12]" style="display: none; border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <button class="btn btn-fab" type="submit" name="submit" id="submit">Enviar</button>
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