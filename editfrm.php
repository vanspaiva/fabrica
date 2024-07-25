<?php
session_start();

if (isset($_SESSION["useruid"])) {
    require_once 'db/dbh.php';
    include("php/head_updateprop.php");

    $user = $_SESSION["useruid"];

    if (isset($_GET['id'])) {
        $frmId = $_GET['id'];

        if (isset($_SESSION['success_message'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']);
        }


        $sql = "SELECT * FROM frm_inf_004 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $frmId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        if ($data) {
            $responsavel = isset($data['responsavel']) ? $data['responsavel'] : '';
            $frmStatus = isset($data['frmStatus']) ? $data['frmStatus'] : '';
            $descricao_setor_id = isset($data['descricao_setor']) ? $data['descricao_setor'] : '';
        }

        $sqlAtividadesIds = "SELECT descricao_atividades_id FROM frm_inf_004_atividades WHERE frm_inf_004_id = ?";
        $stmtAtividadesIds = $conn->prepare($sqlAtividadesIds);
        $stmtAtividadesIds->bind_param("i", $frmId);
        $stmtAtividadesIds->execute();
        $resultAtividadesIds = $stmtAtividadesIds->get_result();


        $checkboxIds = [];
        while ($row = $resultAtividadesIds->fetch_assoc()) {
            $checkboxIds[] = $row['descricao_atividades_id'];
        }

        $sqlAtividades = "SELECT * FROM descricao_atividades";
        $stmtAtividades = $conn->query($sqlAtividades);
        $atividadesData = $stmtAtividades->fetch_all(MYSQLI_ASSOC);

        $sqlSetores = "SELECT id, descricao_setores FROM setor_arcondicionado";
        $stmtSetores = $conn->query($sqlSetores);
        $setoresData = $stmtSetores->fetch_all(MYSQLI_ASSOC);
?>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar.php';
            include_once 'php/lateral-nav.php';
            ?>
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
                                    <h2>Informações da Manutenção e Limpeza - <?php echo $frmId; ?></h2>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="card">
                            <div class="card-body">
                                <section id="main-content">
                                    <section class="wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-panel">
                                                    <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/updatefrm_004.php" method="POST">
                                                        <div class="form-row" hidden>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="osid">OS ID</label>
                                                                <input type="number" class="form-control" id="id" name="id" value="<?php echo $data['id']; ?>" required readonly>
                                                                <small class="text-muted">ID não é editável</small>
                                                            </div>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="user">User
                                                                    Responsável</label>
                                                                <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                        <?php if ($_SESSION["userperm"] === 'Administrador' || $_SESSION["userperm"] === 'Gestor(a)') { ?>
                                                            <div class='d-flex justify-content-around'>
                                                                <div class='form-group col-md-3 m-2'>
                                                                    <label class='control-label'>Status <b style='color: red;'>*</b></label><br>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="frmStatus" id="statusPendente" value="Pendente" <?php if (isset($data['frmStatus']) && $data['frmStatus'] == 'Pendente') echo 'checked'; ?> required>
                                                                        <label class="form-check-label" for="statusPendente">Pendente</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input class="form-check-input" type="radio" name="frmStatus" id="statusConcluida" value="Concluída" <?php if (isset($data['frmStatus']) && $data['frmStatus'] == 'Concluída') echo 'checked'; ?>>
                                                                        <label class="form-check-label" for="statusConcluida">Concluído</label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?> 


                                                        <div class='d-flex justify-content-around'>
                                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                                <label class='control-label' style='color:black;'>Data de
                                                                    Publicação<b style='color: red;'>*</b></label>
                                                                <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' value="<?php echo $data['data_publicacao']; ?>" required>
                                                            </div>
                                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                                <label class='control-label' style='color:black;'>Validade</label>
                                                                <input class='form-control' name='dataValidade' id='dataValidade' type='date' value="<?php echo $data['data_validade']; ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.getElementById('dataPublicacao').addEventListener('change',
                                                                function() {
                                                                    var dataPublicacao = new Date(this.value);
                                                                    var doisAnosDepois = new Date(dataPublicacao);
                                                                    doisAnosDepois.setFullYear(dataPublicacao.getFullYear() +
                                                                        2);
                                                                    doisAnosDepois.setDate(doisAnosDepois.getDate() + 1);

                                                                    if (doisAnosDepois.getMonth() === 1 && doisAnosDepois
                                                                        .getDate() === 29) {
                                                                        if (!isBissexto(doisAnosDepois.getFullYear() + 1)) {
                                                                            doisAnosDepois.setDate(28);
                                                                        }
                                                                    }

                                                                    var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                                                    var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                                                    var ano = doisAnosDepois.getFullYear();
                                                                    var dataValidadeFormatada = ano + "-" + mes + "-" + dia;

                                                                    document.getElementById('dataValidade').value =
                                                                        dataValidadeFormatada;
                                                                });

                                                            function isBissexto(ano) {
                                                                return (ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0);
                                                            }
                                                        </script>

                                                        <div class='form-group col-md-4 m-2'>
                                                            <label class='control-label'>Setor <b style='color: red;'>*</b></label>
                                                            <select class="form-control" name='setor_id' id='setor_id'>
                                                                <?php
                                                                var_dump($setoresData); 

                                                                foreach ($setoresData as $setor) {
                                                                    $selected = ($setor['descricao_setores'] == $data['descricao_setor']) ? 'selected' : '';
                                                                    echo '<option value="' . htmlspecialchars($setor["id"]) . '" ' . $selected . '>' . htmlspecialchars($setor["descricao_setores"]) . '</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>


                                                        <div class='form-group col-md-3 m-2'>
                                                            <label class='control-label'>Marca/Modelo</label>
                                                            <input class='form-control' name='marcaModelo' id='marcaModelo' value='Springer' readonly>
                                                        </div>
                                                </div>

                                                <div class='form-group d-block flex-fill m-2'>
                                                    <label class='control-label' style='color:black;'>Responsável<b style='color: red;'>*</b></label>
                                                    <input class='form-control' name='responsavel' id='responsavel' style="text-transform: capitalize;" value="<?php echo $responsavel ?>" required>
                                                </div>

                                                <div class='d-flex justify-content-around'>
                                                    <div class='form-group col-md-3 m-2'>
                                                        <label class='control-label'>Data de Manutenção <b style='color: red;'>*</b></label>
                                                        <input class='form-control' name='dataManutencao' id='dataManutencao' type='date' value="<?php echo $data['data_manutencao']; ?>" required>
                                                    </div>
                                                </div>
                                                <div class='d-flex justify-content-center' style="margin-top: 50px;">
                                                    <div class='form-group d-inline-block flex-fill m-2'>
                                                        <table class="table" style="font-size: 1rem; margin: 10px;">
                                                            <thead>
                                                                <tr>
                                                                    <th style="text-align: center; font-size: 1.2rem;">Descrição
                                                                        das Atividades</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                    <?php
                                                                    foreach ($atividadesData as $ativRow) {
                                                                        $atividadeId = $ativRow['id'];
                                                                        $descricao = $ativRow['descricao'];
                                                                
                                                                        // Verifica se o ID da atividade está na lista de IDs do formulário
                                                                        $checked = in_array($atividadeId, $checkboxIds) ? "checked" : "";
                                                                
                                                                        echo "<tr>";
                                                                        echo "<td>";
                                                                        echo "<input type='checkbox' name='descricao_atividades[]' value='{$atividadeId}' {$checked}> {$descricao}<br>";
                                                                        echo "</td>";
                                                                        echo "</tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                                <br>
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
            <script src='scripts/scriptjs/scriptprop.js'></script>
            <script src='scripts/scriptjs/scriptpmo.js'></script>
        </body>

        </html>

<?php
    } else {
        header("Location: lista-frm.php?error=id_not_found");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
