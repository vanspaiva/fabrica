<?php
header("Content-Type: application/json");

require_once '../db/dbh.php';
require_once '../includes/functions.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $dataAtual = hoje();

    $projetista = $_POST['projetista'];
    $dr = $_POST['dr'];
    $pac = $_POST['pac'];
    $rep = $_POST['rep'];
    $pedido = $_POST['pedido'];
    $dt = $dataAtual;
    $produto = $_POST['produto'];
    $dataEntrega = $_POST['dataEntrega'];

    // Procurar na tabela fluxo um nome parecido com o nome $_POST['produto']
    $stmtFluxo = $conn->prepare("SELECT id FROM fluxo WHERE nome LIKE CONCAT('%', ?, '%') LIMIT 1");
    $stmtFluxo->bind_param("s", $produto);
    $stmtFluxo->execute();
    $stmtFluxo->bind_result($fluxo);
    $stmtFluxo->fetch();
    $stmtFluxo->close();

    // Se não encontrar um fluxo correspondente, definir fluxo como NULL
    if (!$fluxo) {
        $fluxo = null;
    }

    // Inserir os dados na tabela pedidos
    $stmt = $conn->prepare("INSERT INTO pedidos (projetista, dr, pac, rep, pedido, dt, produto, dataEntrega, fluxo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $projetista, $dr, $pac, $rep, $pedido, $dt, $produto, $dataEntrega, $fluxo);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Pedido inserido com sucesso!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Erro ao inserir o pedido!"]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Método de requisição não suportado!"]);
}

$conn->close();

// Função para gerar variações da string
function generateStringVariations($string)
{
    // Uppercase
    $upper = strtoupper($string);
    // Lowercase
    $lower = strtolower($string);
    // Capitalized (first letter of each word)
    $capitalized = ucwords(strtolower($string));

    return array($upper, $lower, $capitalized);
}
