<?php
require_once '../db/dbh.php';
session_start();

if (isset($_POST['update'])) {
    $frmId = $_POST['id'];
    $dataPublicacao = $_POST['dataPublicacao'];
    $dataValidade = $_POST['dataValidade'];
    $dataManutencao = $_POST['dataManutencao'];
    $modelo = $_POST['marcaModelo'];   
    $setorId = $_POST['setor_id'];
    $descricaoAtividadesIds = isset($_POST['descricao_atividades']) ? $_POST['descricao_atividades'] : [];

    $frmStatus = 1; 

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    try {
        // 1. Deletar os registros antigos na tabela frm_inf_004_atividades
        $sqlDelete = "DELETE FROM frm_inf_004_atividades WHERE frm_inf_004_id = ?";
        $stmtDelete = $conn->prepare($sqlDelete);
        $stmtDelete->bind_param('i', $frmId);
        $stmtDelete->execute();

        // 2. Inserir os novos IDs selecionados na tabela frm_inf_004_atividades
        $sqlInsert = "INSERT INTO frm_inf_004_atividades (frm_inf_004_id, descricao_atividades_id) VALUES (?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);

        foreach ($descricaoAtividadesIds as $atividadeId) {
            $stmtInsert->bind_param('ii', $frmId, $atividadeId);
            $stmtInsert->execute();
        }

        // 3. Atualizar os dados na tabela frm_inf_004
        // Obter a descrição do setor
        $sqlSetor = "SELECT descricao_setores FROM setor_arcondicionado WHERE id = ?";
        $stmtSetor = $conn->prepare($sqlSetor);
        $stmtSetor->bind_param('i', $setorId);
        $stmtSetor->execute();
        $resultSetor = $stmtSetor->get_result();

        if ($resultSetor->num_rows > 0) {
            $descricao_setor = $resultSetor->fetch_assoc()['descricao_setores'];
        } else {
            throw new Exception('Setor não encontrado.');
        }
        $stmtSetor->close();

        // Montar a descrição das atividades selecionadas
        $descricaoAtividades = "";
        if (!empty($descricaoAtividadesIds)) {
            $atividadesNomes = [];
            foreach ($descricaoAtividadesIds as $atividadeId) {
                $sqlDescricao = "SELECT descricao FROM descricao_atividades WHERE id = ?";
                $stmtDescricao = $conn->prepare($sqlDescricao);
                $stmtDescricao->bind_param('i', $atividadeId);
                $stmtDescricao->execute();
                $resultDescricao = $stmtDescricao->get_result();
                if ($resultDescricao->num_rows > 0) {
                    $descricao = $resultDescricao->fetch_assoc()['descricao'];
                    $atividadesNomes[] = $descricao;
                }
                $stmtDescricao->close();
            }
            $descricaoAtividades = implode(", ", $atividadesNomes);
        }

        // Atualizar os dados na tabela frm_inf_004
        $sqlUpdate = "UPDATE frm_inf_004 SET 
                      data_publicacao = STR_TO_DATE(?, '%Y-%m-%d'), 
                      data_validade = STR_TO_DATE(?, '%Y-%m-%d'), 
                      data_manutencao = STR_TO_DATE(?, '%Y-%m-%d'), 
                      modelo = ?, 
                      descricao_setor = ?, 
                      descricao_atividades = ?, 
                      frmstatus_id = ? 
                      WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('ssssssii', $dataPublicacao, $dataValidade, $dataManutencao, $modelo, $descricao_setor, $descricaoAtividades, $frmStatus, $frmId);

        if (!$stmtUpdate->execute()) {
            throw new Exception('Erro ao executar a consulta SQL para atualização: ' . $stmtUpdate->error);
        }

        $_SESSION['success_message'] = "Dados atualizados com sucesso!";
        $conn->commit();

        header("Location: ../editfrm.php?id=" . $frmId);
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        die("Erro na consulta SQL: " . $e->getMessage());
    }

    $stmtUpdate->close();
    $conn->close();

} else {
    echo "Método de requisição inválido.";
}
?>
