<?php
    header('Content-Type: application/json');
    require "db/dbh.php"; 

    if (!empty($_GET['value'])) {
        
        $value = '%' . substr($_GET['value'], -7) . '%';

        $sql = "SELECT d.nome_departamento 
        FROM setores_form_inf_003 AS s 
        JOIN departamentos_form_inf_003 AS d ON d.id_setor = s.id_setor 
        WHERE s.nome_setor LIKE ? ORDER BY d.nome_departamento;";
        
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $value);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        
        $departamentos = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $departamentos[] = $row["nome_departamento"];
        }
        
        echo json_encode($departamentos);
    }
    else{
        echo "ID não encontrado";
    }


