<?php

require_once '../db/dbh.php';


$dadosTabelaSemanal = json_decode($_POST['dadosTabelaSemanal'], true);
$dadosTabelaMensal = json_decode($_POST['dadosTabelaMensal'], true);
$atividadesSelecionadas = explode(',', $_POST['atividadesSelecionadas']);
$idMaquina = $_POST['idMaquina']; 


$stmt = $conn->prepare("INSERT INTO omregistromanutencao (idMaquina, idManutencaoSemanal, idManutencaoMensal, dataPrevista, dataRealizada, responsavel, observacao) VALUES (?, ?, ?, ?, ?, ?, ?)");

try {

    foreach ($dadosTabelaSemanal as $linha) {
        $idManutencaoSemanal = $linha['idManutencaoSemanal'] ?? null; 
        $idManutencaoMensal = null; 
        $dataPrevista = date('Y-m-d', strtotime($linha['dataPrevista']));
        $dataRealizada = $linha['dataRealizada'];
        $responsavel = $linha['responsabilidade'];
        $observacao = $linha['observacao'];

        $stmt->bind_param('siissss', $idMaquina, $idManutencaoSemanal, $idManutencaoMensal, $dataPrevista, $dataRealizada, $responsavel, $observacao);
        $stmt->execute();
    }

    // Insira os dados da tabela mensal
    foreach ($dadosTabelaMensal as $linha) {
        $idManutencaoSemanal = null; 
        $idManutencaoMensal = $linha['idManutencaoMensal'] ?? null; 
        $dataPrevista = $linha['dataPrevista'];
        $dataRealizada = $linha['dataRealizada'];
        $responsavel = $linha['responsabilidade'];
        $observacao = $linha['observacao'];

        $stmt->bind_param('siissss', $idMaquina, $idManutencaoSemanal, $idManutencaoMensal, $dataPrevista, $dataRealizada, $responsavel, $observacao);
        $stmt->execute();
    }

    echo json_encode(['success' => true, 'message' => 'Dados salvos com sucesso!']);
} catch (Exception $e) {

    echo json_encode(['success' => false, 'message' => 'Erro ao salvar dados: ' . $e->getMessage()]);
}

$stmt->close();
$conn->close();
?>
