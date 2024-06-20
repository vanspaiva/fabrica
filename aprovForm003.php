<?php

print_r($_GET);

require_once("db/dbh.php");

if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);

    // Preparar e executar a query de atualização
    $sql = "UPDATE form_inf_003 SET conferido = 'APROV' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        echo "Registro Aprovado com sucesso.";
        header("location: showForm003Pendentes.php");
    } else {
        echo "Erro ao aprovar registro: " . mysqli_stmt_error($stmt);
    }

    mysqli_stmt_close($stmt);
} else {
    echo "ID do registro não fornecido.";
}

mysqli_close($conn);
