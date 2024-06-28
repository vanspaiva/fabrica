<?php

if (isset($_POST["submit"])) {
    require_once '../db/dbh.php'; 

     // Captura os valores do formulário
     $dataPublicacao = $_POST["dataPublicacao"];
     $dataValidade = date('Y-m-d', strtotime($dataPublicacao . ' + 2 years'));
     $marcaModelo = "Springer";
     $setorId = $_POST["setor_id"];
     $checkboxSelecionados = isset($_POST["checkbox_selecionados"]) ? $_POST["checkbox_selecionados"] : [];
     $userId = 3; 
     $dataManutencao = $_POST['dataManutencao'];
     $executado = isset($_POST["executado"]) ? $_POST["executado"] : [];


     echo "<pre>";
     print_r($_POST);
     echo "</pre>";
 

     $sql = "INSERT INTO frm_inf_004 (data_publicacao, data_validade, modelo, data_manutencao, setor_id, id_checkbox_selecionados) VALUES (?, ?, ?, ?, ?, ?)";
     $stmt = mysqli_prepare($conn, $sql);
     mysqli_stmt_bind_param($stmt, "ssssii", $dataPublicacao, $dataValidade, $marcaModelo, $dataManutencao, $setorId, $checkboxSelecionados[0]);
     mysqli_stmt_execute($stmt);
 
         // Captura o ID da inserção
         $frmInfId = mysqli_insert_id($conn);
         if (!$frmInfId) {
             throw new Exception("Erro ao capturar o ID da inserção na tabela frm_inf_004");
         }
 
    
         echo "frmInfId: " . $frmInfId . "<br>";


         if (!empty($executado)) {
            $ids_descricoes = implode(",", $executado);
            $sql = "INSERT INTO checkbox_selecionados (ids_descricoes_selecionadas) VALUES (?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $ids_descricoes);
            $stmt->execute();
        }

         // Confirma a transação
         mysqli_commit($conn);
         echo "Dados inseridos com sucesso!";
 
     } 

?>