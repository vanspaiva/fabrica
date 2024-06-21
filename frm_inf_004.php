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
            // Obter outros dados do formulário
            $dataPublicacao = $_POST['dataPublicacao'];
            $identificadorAmbiente = $_POST['identificadorAmbiente'];
            $tipoAtividade = $_POST['tipoAtividade'];

            // Calcular a data de validade
            $dataValidade = date('Y-m-d', strtotime($dataPublicacao . ' + 2 years'));

            // Inserir no banco de dados
            $marcaModelo = "Springer";
            $responsavel = $_SESSION["userfirstname"]; 

            $sql = "INSERT INTO FRM_INF_004 (data_publicacao, data_validade, modelo, identificacao_ambiente, tipo_atividade,  usersId) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $sql);
            
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "sssssi", $dataPublicacao, $dataValidade, $marcaModelo, $identificadorAmbiente, $tipoAtividade,  $userId);
                mysqli_stmt_execute($stmt);
                $frmInfId = mysqli_insert_id($conn);
                echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Dados inseridos com sucesso!</p></div>";
            } else {
                $error = mysqli_error($conn);
                error_log("Erro ao preparar a consulta SQL: $error");
            }
    }
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
                                            <label class='control-label'>Identificação do Ambiente <b style='color: red;'>*</b></label>
                                            <input class='form-control' name='identificadorAmbiente' id='identificadorAmbiente' required>
                                        </div>
                                        <div class='form-group col-md-4 m-2'>
                                            <label class='control-label'>Tipo de Atividade<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='tipoAtividade' id='tipoAtividade' required>
                                        </div>
                                        <div class='form-group col-md-3 m-2'>
                                            <label class='control-label'>Marca/Modelo</label>
                                            <input class='form-control' name='marcaModelo' id='marcaModelo' value='Springer' readonly>
                                        </div>
                                    </div>
                                    <div class='form-group d-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='responsavel' id='responsavel' style="text-transform: capitalize;" value="<?php echo $_SESSION["userfirstname"]; ?>">
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