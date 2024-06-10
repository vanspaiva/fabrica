<?php
//verificar se esta logado

if (isset($_POST) && isset($_POST["submit"])) {
    $descricao = addslashes($_POST["descricao"]);
    $codigoCilisto = addslashes($_POST["cdg"]); 
    $fluxo = addslashes($_POST["fluxo"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    createProduto($conn, $descricao, $cdg, $fluxo);

} else if (isset($_POST["update"])) {
    $prodid = addslashes($_POST["prodid"]);
    $produto= addslashes($_POST["subproduto"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editProduto($conn, $prodid, $produto, $subproduto);
} else {
    header("location: ../produtos");
    exit();
}
