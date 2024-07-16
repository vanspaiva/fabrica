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
                                $responsavel = $_SESSION["useruid"];
                            ?>

                                <form action="includes/frm_004.inc.php" method="POST">
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
                                    <div class='d-flex justify-content-between'>
                                        <div class='form-group col-md-4 m-2'>
                                            <label class='control-label'>Setor<b style='color: red;'>*</b></label>
                                            <select class="form-control" name="setor_id" id="setor_id" onchange="updateUrlWithSetor()" required>
                                                <option value="">Selecione um Setor</option>
                                                <?php
                                                $sql = "SELECT id, descricao_setores FROM setor_arcondicionado";
                                                $result = $conn->query($sql);

                                                $selected_setor_id = '';
                                                $selected_setor_description = '';

                                                if (isset($_GET['setor'])) {
                                                    $setor_param = $_GET['setor'];
                                                    if (is_numeric($setor_param)) {
                                                        $selected_setor_id = $setor_param;
                                                    } else {
                                                        $selected_setor_description = urldecode($setor_param);
                                                    }
                                                }

                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        $selected = '';
                                                        if ($selected_setor_id && $row["id"] == $selected_setor_id) {
                                                            $selected = 'selected';
                                                        } elseif ($selected_setor_description && $row["descricao_setores"] == $selected_setor_description) {
                                                            $selected = 'selected';
                                                        }
                                                        echo '<option value="' . $row["id"] . '" ' . $selected . '>' . $row["descricao_setores"] . '</option>';
                                                    }
                                                } else {
                                                    echo '<option value="">Nenhum setor disponível</option>';
                                                }
                                                ?>
                                            </select>
                                            <script>
                                                function updateUrlWithSetor() {
                                                    var selectElement = document.getElementById('setor_id');
                                                    var setorId = selectElement.value;
                                                    if (setorId) {
                                                        var newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?setor=' + setorId;
                                                        window.history.pushState({
                                                            path: newUrl
                                                        }, '', newUrl);
                                                    }
                                                }

                                                window.onload = function() {
                                                    var urlParams = new URLSearchParams(window.location.search);
                                                    var setor = urlParams.get('setor');
                                                    if (setor) {
                                                        document.getElementById('setor_id').value = setor;
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <div class='form-group d-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                            <select class='form-control' name='responsavel' id='responsavel' style="text-transform: capitalize;" required>
                                                <option value="">Selecione o(a) responsável</option>
                                                <option value="Edson">Edson</option>
                                                <option value="Kellyta">Kellyta</option>
                                                <option value="Joilza">Joilza</option>
                                            </select>
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
                                                event.preventDefault();
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
                                    <?php
                                    $descriptions = [
                                        1 => "Verificação e drenagem da água",
                                        2 => "Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)",
                                        3 => "Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)",
                                        4 => "Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros",
                                        5 => "Trocar filtros",
                                        6 => "Verificação da fixação",
                                        7 => "Verificação de vazamentos nas ligações flexíveis",
                                        8 => "Estado de conservação do isolamento termo-acústico",
                                        9 => "Vedação dos painéis de fechamento do gabinete",
                                        10 => "Manutenção mecânica",
                                        11 => "Manutenção elétrica",
                                        12 => "outros"
                                    ];
                                    
                                    if (is_array($descriptions) && !empty($descriptions)) {
                                        foreach ($descriptions as $id => $description) {
                                            echo "<tr>";
                                            echo "<td>$description</td>";
                                            echo "<td style=\"vertical-align: middle; text-align: center;\">";
                                            echo "<input type=\"checkbox\" name=\"executado[]\" value=\"$id\">";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
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