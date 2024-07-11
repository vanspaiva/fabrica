<?php
session_start();

if (isset($_SESSION["useruid"]) && $_SESSION["userperm"] == 'Administrador') {
    require_once 'db/dbh.php'; 

    if (isset($_GET['id'])) {
        $id = $_GET['id'];


        if ($conn) {
            $sql = "DELETE FROM frm_inf_004 WHERE id = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("i", $id);
                if ($stmt->execute()) {
                    header("Location: lista-frm.php?message=success");
                    exit();
                } else {
                    echo "Erro ao deletar formulário: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Erro ao preparar a consulta: " . $conn->error;
            }
        } else {
            echo "Erro na conexão com o banco de dados.";
        }
    } else {
        echo "ID do formulário não fornecido.";
    }
} else {
    header("Location: index.php");
    exit();
}
?>
