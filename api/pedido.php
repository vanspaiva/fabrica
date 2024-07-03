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
    $lote = $_POST['lote'];

    $cdgprod = $_POST['cdgprod'];
    $qtds = $_POST['qtds'];
    $descricao = $_POST['descricao'];

    $fluxo = buscarFluxoPorProduto($conn, $produto);
    
    // Se não encontrar um fluxo correspondente, definir fluxo como NULL
    if (!$fluxo) {
        $fluxo = null;
    }
    
    $diasparaproduzir = diasFaltandoParaData($dataEntrega);

    inserirPedido($conn, $projetista, $dr, $pac, $rep, $pedido, $dt, $produto, $dataEntrega, $fluxo, $lote, $cdgprod, $qtds, $descricao, $diasparaproduzir);

} else {
    echo json_encode(["status" => "error", "message" => "Método de requisição não suportado!"]);
}

$conn->close();
