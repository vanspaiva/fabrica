<?php
require 'db/dbh.php';
require 'includes/functions.inc.php';
// print_r($_POST);
// exit();

// Função para inserir etapas selecionadas

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
