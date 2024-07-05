<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataPublicacao = $_POST['dataPublicacao'];
    $dataValidade = $_POST['dataValidade'];
    $dataManutencao = $_POST['dataManutencao'];
    $marcaModelo = $_POST['marcaModelo'];
    $responsavel = $_POST['responsavel'];
    $setorId = $_POST['setor_id'];
    $executado = $_POST['executado'];

    $frmStatus = '1';

    if (empty($setorId)) {
        die("Erro: Setor não foi selecionado.");
    }

    require_once '../db/dbh.php';

    mysqli_begin_transaction($conn);

    try {
    
        $sqlUserId = "SELECT usersId FROM users WHERE usersUid = ?";
        $stmtUserId = mysqli_prepare($conn, $sqlUserId);
        mysqli_stmt_bind_param($stmtUserId, "s", $responsavel);
        mysqli_stmt_execute($stmtUserId);
        mysqli_stmt_bind_result($stmtUserId, $userId);
        mysqli_stmt_fetch($stmtUserId);
        mysqli_stmt_close($stmtUserId);

        if (!$userId) {
            throw new Exception("Erro: Usuário não encontrado.");
        }


        if (!$userId) {
            throw new Exception("Erro: Usuário não encontrado.");
        }

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

        $stmtInsert = $conn->prepare("INSERT INTO frm_inf_004 (data_publicacao, data_validade, modelo, descricao_setor, data_manutencao, descricao_atividades, userId, frmStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtInsert->bind_param("ssssssis", $dataPublicacao, $dataValidade, $marcaModelo, $descricaoSetor, $dataManutencao, $descricaoAtividadesStr, $userId, $frmStatus);

        if (!$stmtInsert->execute()) {
            throw new Exception('Erro ao executar a consulta SQL para frm_inf_004: ' . $stmtInsert->error);
        }

        mysqli_commit($conn);

        $_SESSION['successMessage'] = "Dados inseridos com sucesso.";
        header('Location: ../frm_inf_004.php');
        exit();
    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['errorMessage'] = "Erro na consulta SQL: " . $e->getMessage();
    }
}
