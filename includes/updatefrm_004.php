<?php
require_once '../db/dbh.php';
session_start();

if (isset($_POST['update'])) {
    $frmId = $_POST['id'];

    $dataPublicacao = $_POST['dataPublicacao'];
    $dataValidade = $_POST['dataValidade'];
    $dataManutencao = $_POST['dataManutencao'];
    $modelo = $_POST['marcaModelo'];
    $descricaoSetor = $_POST['setor_id'];
    $descricaoAtividadesIds = isset($_POST['descricao_atividades']) ? $_POST['descricao_atividades'] : [];

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $conn->begin_transaction();

    try {
  
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

 
        $sqlUpdate = "UPDATE frm_inf_004 SET 
                      data_publicacao = STR_TO_DATE(?, '%Y-%m-%d'), 
                      data_validade = STR_TO_DATE(?, '%Y-%m-%d'), 
                      modelo = ?, 
                      data_manutencao = STR_TO_DATE(?, '%Y-%m-%d'), 
                      descricao_atividades = ?, 
                      descricao_setores = ? 
                      WHERE id = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);


        if (!$stmtUpdate) {
            throw new Exception('Erro na preparação da consulta SQL para atualização: ' . $conn->error);
        }


        $stmtUpdate->bind_param('ssssssi', $dataPublicacao, $dataValidade, $modelo, $dataManutencao, $descricaoAtividades, $descricaoSetor, $frmId);

 
        if (!$stmtUpdate->execute()) {
            throw new Exception('Erro ao executar a consulta SQL para atualização: ' . $stmtUpdate->error);
        }

  
        $_SESSION['success_message'] = "Dados inseridos com sucesso!";
        $conn->commit();

        /* header("Location: editfrm.php?id=" . $frmId); // Redireciona de volta para a página de edição
        exit(); */

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
