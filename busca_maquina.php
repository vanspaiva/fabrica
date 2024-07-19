<?php
header('Content-Type: application/json');
require 'db/dbh.php'; 

if (isset($_GET['idMaquina'])) {
    $idMaquina = $_GET['idMaquina'];

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
    } else {
        $data = array(
            'omNomeMaquina' => 'Máquina não encontrada',
            'omIdentificadorMaquina' => ''
        );
    }

    echo json_encode($data);

    $sql->close();
} else {
    echo json_encode(array('error' => 'Parâmetro idMaquina não fornecido.'));
}

$conn->close();
?>
