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

        if (isset($_SESSION['successMessage'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['successMessage'] . '</div>';
            unset($_SESSION['successMessage']);
        } elseif (isset($_SESSION['errorMessage'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['errorMessage'] . '</div>';
            unset($_SESSION['errorMessage']);
        }
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
                return null;
            }
        }
        ?>
        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div class="container-fluid">

                <div class="col-sm-12 mx-2 justify-content-start">
                    <div class="card">
                        <div class="card-head"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm py-2">
                                    <h3 class="font-weight-semibold" style="text-align: center;">Registro de Manutenção</h3>
                                    <h5 class="font-weight-regular" style="text-align: center;">Formulário</h5>
                                    <h6 class="font-weight-regular" style="text-align: center;">FRM.PRO.004</h6>
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
                                $responsavel = $_SESSION["useruid"];
                            ?>

                                <form action="includes/frm_004.inc.php" method="POST">
                                    <h4 class="text-fab">Dados de Registro</h4>

                                    <div style="display: none !important;" class='d-flex justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data de Publicação<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' required value='2023-10-18'>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Validade</label>
                                            <input class='form-control' name='dataValidade' id='dataValidade' type='date' readonly value='2025-10-18'>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('dataPublicacao').addEventListener('change', function() {

                                            var dataPublicacao = new Date(this.value);

                                            var doisAnosDepois = new Date(dataPublicacao);
                                            doisAnosDepois.setFullYear(dataPublicacao.getFullYear() + 2);

                                            doisAnosDepois.setDate(doisAnosDepois.getDate() + 1);

                                            if (doisAnosDepois.getMonth() === 1 && doisAnosDepois.getDate() === 29) {

                                                if (!isBissexto(doisAnosDepois.getFullYear())) {
                                                    doisAnosDepois.setDate(28)
                                                }
                                            }

                                            var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                            var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                            var ano = doisAnosDepois.getFullYear();
                                            var dataValidadeFormatada = ano + "-" + mes + "-" + dia

                                            document.getElementById('dataValidade').value = dataValidadeFormatada
                                        });

                                        function isBissexto(ano) {
                                            return (ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0);
                                        }
                                    </script>

                                    <div class='d-flex justify-content-around'>
                                        <div class='form-group flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Nº Máquina<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='idMaquina' id='idMaquina' type='text'>
                                        </div>
                                        <div class='form-group flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Nome Máquina</label>
                                            <input class='form-control' name='omNomeMaquina' id='omNomeMaquina' type='text' readonly>
                                        </div>
                                    </div>

                                    <div class='d-flex justify-content-between'>
                                        <div class='form-group col-md-4 m-2'>
                                            <div class='form-group d-inline-block flex-fill'>
                                                <label class='control-label' style='color:black;'>Data de Prevista<b style='color: red;'>*</b></label>
                                                <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='text' required value="10/06 a 12/06">
                                            </div>
                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                <label class='control-label' style='color:black;'>Data e Hora realizado</label>
                                                <input class='form-control' name='dataValidade' id='dataValidade' type="datetime-local" required>
                                            </div>
                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                                <select class='form-control' name='responsavel' id='responsavel' style="text-transform: capitalize;" required>
                                                    <option value="">Selecione o(a) responsável</option>
                                                    <option value="Edson">Edson</option>
                                                    <option value="Kellyta">Kellyta</option>
                                                    <option value="Joilza">Joilza</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class='d-flex d-block justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <table class="table" style="font-size: 1rem; margin: 10px;">
                                                <thead>
                                                    <tr>
                                                        <th style="text-align: center; font-size: 1.2rem;">Semanal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <label class='control-label' style='color:black;'>Data de Prevista<b style='color: red;'>*</b></label>
                                                        </td>
                                                        <td>
                                                            <label class='control-label' style='color:black;'>Data e Hora realizado</label>
                                                        </td>
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


        </div>


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>
        <!--      <script>
            <?php require_once "config/firebaseConfig.php"; ?>
            const firebaseConfig = <?php echo json_encode($firebaseConfig); ?>;
        </script> -->

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