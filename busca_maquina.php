<?php
header('Content-Type: application/json');
require 'db/dbh.php';

if (isset($_GET['idMaquina'])) {
    $idMaquina = $_GET['idMaquina'];

    if ($conn->connect_error) {
        die(json_encode(array('error' => 'Connection failed: ' . $conn->connect_error)));
    }

    $sql = $conn->prepare("SELECT omNomeMaquina, omIdentificadorMaquina FROM om_maquina WHERE idMaquina = ?");
    $sql->bind_param("s", $idMaquina);
    $sql->execute();
    $result = $sql->get_result();

    $data = array();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $data = array(
            'omNomeMaquina' => $row['omNomeMaquina'],
            'omIdentificadorMaquina' => $row['omIdentificadorMaquina']
        );

        // Buscar atividades semanais
        $sqlAtividadesSemanal = $conn->prepare("
            SELECT oms.descricaoSemanal 
            FROM ommanutencaosemanal oms
            JOIN maquina_manutencao_semanal mms ON oms.id = mms.idManutencaoSemanal
            WHERE mms.idMaquina = ?
        ");
        $sqlAtividadesSemanal->bind_param("s", $idMaquina);
        $sqlAtividadesSemanal->execute();
        $resultAtividadesSemanal = $sqlAtividadesSemanal->get_result();

        $atividadesSemanal = array();
        while ($rowAtividade = $resultAtividadesSemanal->fetch_assoc()) {
            $atividadesSemanal[] = $rowAtividade['descricaoSemanal'];
        }
        $data['atividadesSemanal'] = $atividadesSemanal;
        $sqlAtividadesSemanal->close();

        // Buscar atividades mensais
        $sqlAtividadesMensal = $conn->prepare("
            SELECT omm.descricaoMensal 
            FROM ommanutencaomensal omm
            JOIN maquina_manutencao_mensal mmm ON omm.id = mmm.idManutencaoMensal
            WHERE mmm.idMaquina = ?
        ");
        $sqlAtividadesMensal->bind_param("s", $idMaquina);
        $sqlAtividadesMensal->execute();
        $resultAtividadesMensal = $sqlAtividadesMensal->get_result();

        $atividadesMensal = array();
        while ($rowAtividade = $resultAtividadesMensal->fetch_assoc()) {
            $atividadesMensal[] = $rowAtividade['descricaoMensal'];
        }
        $data['atividadesMensal'] = $atividadesMensal;
        $sqlAtividadesMensal->close();
    } else {
        $data = array(
            'omNomeMaquina' => 'Máquina não encontrada',
            'omIdentificadorMaquina' => '',
            'atividadesSemanal' => [],
            'atividadesMensal' => []
        );
    }

    echo json_encode($data);
    $sql->close();
} else {
    echo json_encode(array('error' => 'Parâmetro idMaquina não fornecido.'));
}

$conn->close();
?>
