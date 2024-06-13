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
                                            doisAnosDepois.setFullYear(doisAnosDepois.getFullYear() + 2);

                                            // Verificar se a data de validade caiu no dia 17 e ajustar para o dia 18
                                            if (doisAnosDepois.getDate() === 17) {
                                                doisAnosDepois.setDate(18);
                                            }

                                            // Formatar a data de validade para o formato "YYYY-MM-DD"
                                            var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                            var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                            var ano = doisAnosDepois.getFullYear();
                                            var dataValidadeFormatada = ano + "-" + mes + "-" + dia;

                                            // Exibir a data de validade no campo de "Validade"
                                            document.getElementById('validade').value = dataValidadeFormatada;
                                        });
                                    </script>
                                    <div class='d-flex justify-content-between'>
                                        <div class='form-group col-md-4 m-2'>
                                            <label class='control-label'>Identificação do Ambiente <b style='color: red;'>*</b></label>
                                            <input class='form-control' name='identificadorAmbiente' id='identificadorAmbiente' required>
                                        </div>
                                        <div class='form-group col-md-4 m-2'>
                                            <label class='control-label'>Tipo de Atividade <b style='color: red;'>*</b></label>
                                            <input class='form-control' name='tipoAtividade' id='tipoAtividade' required>
                                        </div>
                                        <div class='form-group col-md-3 m-2'> 
                                            <label class='control-label'>Marca/Modelo</label>
                                            <input class='form-control' name='marcaModelo' id='marcaModelo' value='Springer' readonly>
                                        </div>
                                    </div>

                                    <!-- Descrição das atividades -->
                                    <div class='d-flex justify-content-center' style="margin-top: 50px;">
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data da Atividade<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dataAtividade' id='dataAtividade' type='date' required>
                                        </div>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <table class="table" style="font-size: 1rem; margin: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; font-size: 1.2rem;">Descrição das Atividades</th>
                                                        <th style="text-align: center; font-size: 1.2rem;">Executado</th>
                                                        <th style="text-align: center; font-size: 1.2rem;">Responsável</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Verificação e drenagem da água</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"  value="Verificação e drenagem da água"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"  value=""></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Trocar filtros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Trocar filtros"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Verificação da fixação</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Verificação da fixação"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Verificação de vazamentos nas ligações flexíveis</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Verificação de vazamentos nas ligações flexíveis"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Estado de conservação do isolamento termo-acústico</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Estado de conservação do isolamento termo-acústico"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Vedação dos painéis de fechamento do gabinete</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Vedação dos painéis de fechamento do gabinete"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Manutenção mecânica</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Manutenção mecânica"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Manutenção elétrica</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="Manutenção elétrica"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td>outros</td>
                                                        <td style="vertical-align: middle; text-align: center;"><input type="checkbox" name="executado[]"value="outros"></td>
                                                        <td><input type="text" name="responsavel[]" style="border-radius: 10px; border: groove;"></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="py-4 col d-flex justify-content-center">
                                        <button class="btn btn-fab" type="submit" name="submit" id="submit">Enviar</button>
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