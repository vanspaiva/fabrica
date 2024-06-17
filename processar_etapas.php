<?php
require 'db/dbh.php';

// print_r($_POST);
// exit();

// Função para inserir etapas selecionadas
function inserirEtapasColaborador($conn, $userId, $etapas)
{
    foreach ($etapas as $idEtapa) {
        $sql = "INSERT INTO colaborador_etapas (idUser, idEtapa) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $userId, $idEtapa);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $etapas = $_POST['setor'];

    if (!empty($etapas)) {
        // Verifica se há registros existentes para o colaborador e exclui-os
        $sqlDelete = "DELETE FROM colaborador_etapas WHERE idUser = ?";
        $stmtDelete = mysqli_prepare($conn, $sqlDelete);
        mysqli_stmt_bind_param($stmtDelete, "i", $userId);
        mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);

        // Insere as novas etapas
        inserirEtapasColaborador($conn, $userId, $etapas);
        header("location: editUser?id=" . $userId . "&error=successetapas");
        exit();
    } else {
        header("location: editUser?id=" . $userId . "&error=emptyinput");
        exit();
    }
}

mysqli_close($conn);
