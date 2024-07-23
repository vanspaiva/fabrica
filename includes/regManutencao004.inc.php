<?php
session_start();
require_once 'db/dbh.php'; // Certifique-se de que o arquivo contém a configuração correta para a conexão com o banco

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idMaquina = $_POST['idMaquina'];
    $atividades = explode(',', $_POST['atividades']);
    $dataPrevista = $_POST['dataPrevista'];
    $dataRealizada = $_POST['dataRealizada'];
    $responsavel = $_POST['responsavel'];
    $observacao = $_POST['observacao'];

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        $_SESSION['errorMessage'] = "Erro na conexão com o banco de dados: " . $conn->connect_error;
        header('Location: ../registroManutencao004.php');
        exit();
    }

    // Começa a transação
    $conn->begin_transaction();

    try {
        // Prepara a instrução SQL
        $sql = "INSERT INTO OmRegistroManutencao (idMaquina, idManutencaoSemanal, dataPrevista, dataRealizada, responsavel, observacao) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            throw new Exception('Erro ao preparar a instrução: ' . $conn->error);
        }

        // Vincula os parâmetros e executa a instrução para cada atividade
        foreach ($atividades as $atividade) {
            $stmt->bind_param('sissss', $idMaquina, $atividade, $dataPrevista, $dataRealizada, $responsavel, $observacao);
            if (!$stmt->execute()) {
                throw new Exception('Erro ao executar a instrução: ' . $stmt->error);
            }
        }

        // Comita a transação
        $conn->commit();
        $_SESSION['successMessage'] = "Dados inseridos com sucesso.";
    } catch (Exception $e) {
        // Reverte a transação em caso de erro
        $conn->rollback();
        $_SESSION['errorMessage'] = "Erro ao inserir dados: " . $e->getMessage();
    }

    // Fecha a instrução e a conexão
    $stmt->close();
    $conn->close();

    header('Location: ../registroManutencao004.php');
    exit();
} else {
    header('Location: ../registroManutencao004.php');
    exit();
}
?>
