<?php
     require_once("db/dbh.php");

    if (isset($_GET["id"])) {

        $id = intval($_GET["id"]);
    
        // Preparar e executar a query de exclusão
        $sql = "DELETE FROM form_inf_003 WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
    
        if ($stmt->execute()) {
            echo "Registro deletado com sucesso.";
            header("location: showForm003.php");
        } else {
            echo "Erro ao deletar registro: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        echo "ID do registro não fornecido.";
    }
    
    $conn->close();

