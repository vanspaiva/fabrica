<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $dataPublicacao = $_POST['dataPublicacao'];
    $dataValidade = $_POST['dataValidade'];
    $dataManutencao = $_POST['dataManutencao'];
    $marcaModelo = $_POST['marcaModelo'];
    $setorId = $_POST['setor_id'];
    $executado = $_POST['executado'];

    echo "Data de Publicação: " . htmlspecialchars($dataPublicacao) . "<br>";
    echo "Data de Validade: " . htmlspecialchars($dataValidade) . "<br>";
    echo "Data de Manutencao: " . htmlspecialchars($dataManutencao) . "<br>";
    echo "Marca/Modelo: " . htmlspecialchars($marcaModelo) . "<br>";
    echo "Setor ID: " . htmlspecialchars($setorId) . "<br>";

    if (empty($setorId)) {
        die("Erro: Setor não foi selecionado.");
    }

    require_once '../db/dbh.php'; 

    mysqli_begin_transaction($conn);

    try {

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

        $sqlFrmInf = "INSERT INTO frm_inf_004 (data_publicacao, data_validade, modelo, data_manutencao, descricao_atividades, descricao_setores)
                      VALUES (?, ?, ?, ?,?, ?)";
        $stmtFrmInf = mysqli_prepare($conn, $sqlFrmInf);
        mysqli_stmt_bind_param($stmtFrmInf, "ssssss", $dataPublicacao, $dataValidade, $marcaModelo, $dataManutencao, $descricaoAtividadesStr, $descricaoSetor);

        if (!mysqli_stmt_execute($stmtFrmInf)) {
            throw new Exception('Erro ao executar a consulta SQL para frm_inf_004: ' . mysqli_error($conn));
        }

        mysqli_commit($conn);

        $_SESSION['successMessage'] = "Dados inseridos com sucesso no banco de dados.";
        header('Location: ../frm_inf_004.php');
        exit();

    } catch (Exception $e) {
        mysqli_rollback($conn);
        $_SESSION['errorMessage'] = "Erro na consulta SQL: " . $e->getMessage();
    }
}
