<?php
session_start();

$_SESSION["userid"];

/* echo "Sessão ID: " . session_id() . "<br>";
echo "Conteúdo da Sessão: ";
var_dump($_SESSION); */

include_once '../db/dbh.php'; 

if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}


if (!isset( $_SESSION["userid"] )) {
    die("Erro: ID do responsável não definido.");
}

$idResp = $_SESSION['userid']; // Obtém o ID do responsável

function updateCadSetor($conn, $setores, $idResp) {
    foreach ($setores as $idSetor) {
        $sql = "INSERT INTO setor_resp (idSetor, idResp) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);

        if (!$stmt) {
            die("Erro na preparação da consulta: " . mysqli_error($conn));
        }

        mysqli_stmt_bind_param($stmt, 'ii', $idSetor, $idResp);

        if (!mysqli_stmt_execute($stmt)) {
            die("Erro na execução da consulta: " . mysqli_stmt_error($stmt));
        }

        mysqli_stmt_close($stmt);
    }

   $_SESSION['successMessage'] = "Dados inseridos com sucesso.";
     header("Location: ../cadastro_setor.php");  // Redirecione para a página onde a mensagem será exibida
    exit();
}

if (isset($_POST["update"])) {
    if (isset($_POST['dep'])) {
        $setores = $_POST['dep'];
        var_dump($setores); // Verifica se os dados estão sendo recebidos corretamente
        updateCadSetor($conn, $setores, $idResp);
    } else {
        echo "Nenhum setor foi selecionado.";
    }
}
?>

