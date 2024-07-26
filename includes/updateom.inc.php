<?php
ob_start();
require_once '../db/dbh.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $omid = addslashes($_POST["omid"]);
    $status = addslashes($_POST["status"]);
    $grau = addslashes($_POST["grau"]);
    $setor = addslashes($_POST["setor"]);
    $descricao = addslashes($_POST["descricao"]);
    $user = addslashes($_POST["user"]);


    $idMaquinaInput = addslashes($_POST["idMaquina"]);
    $omNomeMaquina = addslashes($_POST["omNomeMaquina"]);
    $omIdentificadorMaquina = addslashes($_POST["omIdentificadorMaquina"]);

    // Normaliza o ID da máquina
    $normalizedId = preg_replace('/\D/', '', $idMaquinaInput); // Remove tudo que não é dígito
    $formattedIdMaquina = "MAQ." . str_pad($normalizedId, 3, '0', STR_PAD_LEFT);

    // Buscar o ID da máquina na tabela om_maquina
    $stmt = $conn->prepare("SELECT idMaquina FROM om_maquina WHERE idMaquina = ? OR REPLACE(idMaquina, 'MAQ.', '') = ?");
    $stmt->bind_param("ss", $formattedIdMaquina, $normalizedId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idMaquina = $row['idMaquina'];
    } else {
        $idMaquina = null;
    }

    $stmt->close();


    if (empty($_POST["obs"])) {
        $obs = null;
    } else {
        $obs = addslashes($_POST["obs"]);
    }


    /* 
        echo "<pre>";
        print_r($_POST);
         echo "</pre>";
        exit();
     */
    $obs = !empty($_POST["obs"]) ? addslashes($_POST["obs"]) : null;
    $acaoquali = addslashes($_POST["acaoquali"]);
    $requalificar = addslashes($_POST["requalificar"]);
    $resprequali = addslashes($_POST["resprequali"]);
    $respmanutencao = addslashes($_POST["manutencao"]);
    $desAlinhamento = addslashes($_POST["desAlinhamento"]);
    $dataAlinhamento = addslashes($_POST["dataAlinhamento"]);

    editOM($conn, $omid, $status, $grau, $setor, $descricao, $obs, $user, $acaoquali, $requalificar, $resprequali, $respmanutencao, $idMaquina, $omNomeMaquina, $desAlinhamento, $dataAlinhamento);

    header("location: ../editarom?id=" . $omid);
    exit();
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
