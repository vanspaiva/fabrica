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

        $frmId = $_GET['id'];

        $ret = mysqli_query($conn, "SELECT * FROM FRM_INF_004 WHERE id='" . $frmId . "';");
        while ($row = mysqli_fetch_array($ret)) {
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
                                        <h2>Informações da Manutenção e Limpeza- <?php echo $frmId; ?> </h2>
                                    </div>
                                </div>
                                <?php
                               /*  if ($fileNameOs != null) {
                                ?>
                                    <div class="col-sm pt-2">
                                        <div class="d-flex justify-content-center p-1">
                                                <a href="<?php echo $fileNameFrm 
                                                            ?>" class="btn btn-outline-fab" download><i class="bi bi-cloud-arrow-down"></i> Download Arquivo</a> 
                                              <a href="<?php echo htmlspecialchars($fileNameOs); ?>" target="_blank" class="btn btn-outline-fab" download><i class="bi bi-cloud-arrow-down"></i> Download Arquivo</a> 

                                        </div>
                                    </div>
                                <?php
                                } */
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
                                                        <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updatefrm_004.php"  method="POST">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="osid">OS ID</label>
                                                                    <input type="number" class="form-control" id="id" name="id" value="<?php echo $row['frmId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="user">User Responsável</label>
                                                                    <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                                </div>
                                                            </div>


                                                            <div class='d-flex justify-content-around'>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Data de Publicação<b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' value="<?php echo $row['data_publicacao']; ?>" required>
                                                                </div>
                                                                <div class='form-group d-inline-block flex-fill m-2'>
                                                                    <label class='control-label' style='color:black;'>Validade</label>
                                                                    <input class='form-control' name='dataValidade' id='dataValidade' type='date' value="<?php echo $row['data_validade']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                document.getElementById('dataPublicacao').addEventListener('change', function() {

                                                                    var dataPublicacao = new Date(this.value);

                                                                    var doisAnosDepois = new Date(dataPublicacao);
                                                                    doisAnosDepois.setFullYear(dataPublicacao.getFullYear() + 2);
                                                                    doisAnosDepois.setDate(doisAnosDepois.getDate() + 1);

                                                                    if (doisAnosDepois.getMonth() === 1 && doisAnosDepois.getDate() === 29) {

                                                                        if (!isBissexto(doisAnosDepois.getFullYear() + 1)) {
                                                                            doisAnosDepois.setDate(28);
                                                                        }
                                                                    }

                                                                    var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                                                    var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                                                    var ano = doisAnosDepois.getFullYear();
                                                                    var dataValidadeFormatada = ano + "-" + mes + "-" + dia;

                                                                    document.getElementById('dataValidade').value = dataValidadeFormatada;
                                                                });

                                                                function isBissexto(ano) {
                                                                    return (ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0);
                                                                }
                                                            </script>

                                                            <div class='d-flex justify-content-between'>
                                                                <div class='form-group col-md-4 m-2'>
                                                                    <label class='control-label'>Identificação do Ambiente <b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='identificadorAmbiente' id='identificadorAmbiente' value="<?php echo $row['identificacao_ambiente']; ?>" required>
                                                                </div>
                                                                <div class='form-group col-md-4 m-2'>
                                                                    <label class='control-label'>Tipo de Atividade<b style='color: red;'>*</b></label>
                                                                    <input class='form-control' name='tipoAtividade' id='tipoAtividade' value="<?php echo $row['tipo_atividade']; ?>" required>
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
                                                                                <th style="text-align: center; font-size: 1.2rem;">Responsável</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td>Verificação e drenagem da água</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][1]" value="1"></td>
                                                                                <td><input type="text" name="responsavel[1]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][2]" value="2"></td>
                                                                                <td><input type="text" name="responsavel[2]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][3]" value="3"></td>
                                                                                <td><input type="text" name="responsavel[3]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][4]" value="4"></td>
                                                                                <td><input type="text" name="responsavel[4]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Trocar filtros</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][5]" value="5"></td>
                                                                                <td><input type="text" name="responsavel[5]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Verificação da fixação</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][6]" value="6"></td>
                                                                                <td><input type="text" name="responsavel[6]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Verificação de vazamentos nas ligações flexíveis</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][7]" value="7"></td>
                                                                                <td><input type="text" name="responsavel[7]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Estado de conservação do isolamento termo-acústico</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][8]" value="8"></td>
                                                                                <td><input type="text" name="responsavel[8]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Vedação dos painéis de fechamento do gabinete</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][9]" value="9"></td>
                                                                                <td><input type="text" name="responsavel[9]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Manutenção mecânica</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][10]" value="10"></td>
                                                                                <td><input type="text" name="responsavel[10]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Manutenção elétrica</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][11]" value="11"></td>
                                                                                <td><input type="text" name="responsavel[11]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>outros</td>
                                                                                <td style="vertical-align: middle; text-align: center;"><input type="checkbox" class="executado-checkbox" name="$_POST['executado'][12]" value="12"></td>
                                                                                <td><input type="text" name="responsavel[12]" style="border-radius: 10px; border: 1px solid #ced4da; padding: 5px;"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                            <script>
                                                                $('input[type="checkbox"]').change(function() {
                                                                    if (this.checked) {
                                                                        var descricaoAtividadeId = $(this).data('id');
                                                                        console.log('ID da Descrição da Atividade:', descricaoAtividadeId);
                                                                    }
                                                                });
                                                            </script>
                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" id="update" class="btn btn-fab">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                </div>


                            </div>

                            <script>
                                <?php require_once "config/firebaseConfig.php"; ?>
                                const firebaseConfig = <?php echo json_encode($firebaseConfig); ?>;
                            </script>

                            <script src="js/uploadToFirebase.js"></script>

    </body>


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