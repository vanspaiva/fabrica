<?php
session_start();

if (isset($_SESSION["useruid"])) {
    require_once 'db/dbh.php';
    include("php/head_updateprop.php");

    $user = $_SESSION["useruid"];

    // Verifica se o ID foi passado via GET
    if (isset($_GET['id'])) {
        $frmId = $_GET['id'];

        // Consulta para obter os dados do registro específico
        $sql = "SELECT * FROM frm_inf_004 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $frmId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        // Consulta para obter todas as atividades
        $sqlAtividades = "SELECT * FROM descricao_atividades";
        $stmtAtividades = $conn->query($sqlAtividades);
        $atividadesData = $stmtAtividades->fetch_all(MYSQLI_ASSOC);

        // Consulta para obter os setores
        $sqlSetores = "SELECT id, descricao_setores FROM setor_arcondicionado";
        $stmtSetores = $conn->query($sqlSetores);
        $setoresData = $stmtSetores->fetch_all(MYSQLI_ASSOC);
        // Debug - Verifica o conteúdo das variáveis
        //var_dump($data);
        var_dump($data['descricao_setores']);
        var_dump($data['descricao']);
       ?>

        <body class="bg-light-gray2">
            <?php
            include_once 'php/navbar.php';
            include_once 'php/lateral-nav.php';

            if (isset($_GET["error"])) {
                if ($_GET["error"] == "stmfailed") {
                    echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                }
            }

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
                                                                <label class="form-label text-black" for="user">User Responsável</label>
                                                                <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                            </div>
                                                        </div>

                                                        <div class='d-flex justify-content-around'>
                                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                                <label class='control-label' style='color:black;'>Data de Publicação<b style='color: red;'>*</b></label>
                                                                <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' value="<?php echo $data['data_publicacao']; ?>" required>
                                                            </div>
                                                            <div class='form-group d-inline-block flex-fill m-2'>
                                                                <label class='control-label' style='color:black;'>Validade</label>
                                                                <input class='form-control' name='dataValidade' id='dataValidade' type='date' value="<?php echo $data['data_validade']; ?>" readonly>
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
                                                                <label class='control-label'>Setor <b style='color: red;'>*</b></label>
                                                                <select class="form-control" name='descricao_setores' id='descricao_setores'>
                                                                    <?php
                                                                    foreach ($setoresData as $setor) {
                                                                        $selected = ($setor['descricao_setores'] === $data['descricao_setores']) ? 'selected' : '';

                                                                        echo '<option value="' . htmlspecialchars($setor["descricao_setores"]) . '" ' . $selected . '>' . htmlspecialchars($setor["descricao_setores"]) . '</option>';
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
                                                            <input class='form-control' name='responsavel' id='responsavel' style="text-transform: capitalize;" value="<?php echo $_SESSION["userfirstname"]; ?>" required>
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
                                                                            <th style="text-align: center; font-size: 1.2rem;">Descrição das Atividades</th>
                                                                            <th style="text-align: center; font-size: 1.2rem;">Executado</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tbody>
                                                                        <?php foreach ($atividadesData as $atividade) : ?>
                                                                            <?php
                                                                            $id = $atividade['id'];
                                                                            $descricao = $atividade['descricao'];
                                                                            $checked = false;

                                                                            // Verifica se o ID da atividade está presente em $data['descricao']
                                                                            if (isset($data['descricao'])) {
                                                                                $descricaoIds = explode(',', $data['descricao']);
                                                                                if (in_array($id, $descricaoIds)) {
                                                                                    $checked = true;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <td><?php echo htmlspecialchars($descricao); ?></td>
                                                                                <td style="vertical-align: middle; text-align: center;">
                                                                                    <input type="checkbox" name="descricao_atividades[]" value="<?php echo $id; ?>" <?php if ($checked) echo 'checked'; ?>>
                                                                                </td>
                                                                            </tr>
                                                                        <?php endforeach; ?>

                                                                    </tbody>
                                                                    </tbody>

                                                                </table>

                                                            </div>
                                                        </div>


                                                        <br>

                                                        <div class='d-flex justify-content-center'>
                                                            <button type='submit' name='edit' class='btn btn-primary'>Editar</button>
                                                            <a class='btn btn-danger' href='lista-frm.php'>Cancelar</a>
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
<?php
    } else {
        // Se o ID não estiver definido, redireciona de volta para lista-frm.php
        header("Location: lista-frm.php?error=id_not_found");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>