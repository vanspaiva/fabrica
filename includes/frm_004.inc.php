<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebendo e validando os dados do formulário
    $dataPublicacao = isset($_POST['dataPublicacao']) ? $_POST['dataPublicacao'] : null;
    $dataValidade = isset($_POST['dataValidade']) ? $_POST['dataValidade'] : null;
    $dataManutencao = isset($_POST['dataManutencao']) ? $_POST['dataManutencao'] : null;
    $marcaModelo = $_POST['marcaModelo'];
    $responsavel = $_POST['responsavel'];
    $setorId = $_POST['setor_id'];
    $executado = $_POST['executado'];

    $frmStatus = 1; 

    if (empty($setorId)) {
        die("Erro: Setor não foi selecionado.");
    }

    if (empty($responsavel)) {
        die("Erro: Responsável não foi selecionado.");
    }

    require_once '../db/dbh.php';

    mysqli_begin_transaction($conn);

    $sqlSetor = "SELECT descricao_setores FROM setor_arcondicionado WHERE id = ?";
    $stmtSetor = mysqli_prepare($conn, $sqlSetor);
    mysqli_stmt_bind_param($stmtSetor, "i", $setorId);
    mysqli_stmt_execute($stmtSetor);
    mysqli_stmt_bind_result($stmtSetor, $descricaoSetor);
    mysqli_stmt_fetch($stmtSetor);
    mysqli_stmt_close($stmtSetor);

    if (!$descricaoSetor) {
        throw new Exception("Erro: Setor não encontrado.");
    }

    $descricaoAtividades = array();
    foreach ($executado as $id) {
        $id = intval($id);
        $sqlDescricao = "SELECT descricao FROM descricao_atividades WHERE id = ?";
        $stmtDescricao = mysqli_prepare($conn, $sqlDescricao);
        mysqli_stmt_bind_param($stmtDescricao, "i", $id);
        mysqli_stmt_execute($stmtDescricao);
        mysqli_stmt_bind_result($stmtDescricao, $descricao);
        mysqli_stmt_fetch($stmtDescricao);
        mysqli_stmt_close($stmtDescricao);
        if ($descricao) {
            $descricaoAtividades[] = $descricao;
        }
    }

    $descricaoAtividadesStr = implode(", ", $descricaoAtividades);

    // Preparando e executando a consulta de inserção
    $stmtInsert = $conn->prepare("INSERT INTO frm_inf_004 (data_publicacao, data_validade, modelo, descricao_setor, data_manutencao, descricao_atividades, responsavel, frmstatus_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtInsert->bind_param("sssssssi", $dataPublicacao, $dataValidade, $marcaModelo, $descricaoSetor, $dataManutencao, $descricaoAtividadesStr, $responsavel, $frmStatus);

    if (!$stmtInsert->execute()) {
        throw new Exception('Erro ao executar a consulta SQL para frm_inf_004: ' . $stmtInsert->error);
    }

    mysqli_commit($conn);

    $_SESSION['successMessage'] = "Dados inseridos com sucesso.";
    header('Location: ../frm_inf_004.php');
    exit();
}
?>
