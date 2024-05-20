<?php


if (isset($_POST["submit"])) {
    $categoria = addslashes($_POST["categoria"]);
    $cdg = addslashes($_POST["cdg"]);
    $descricao = addslashes($_POST["descricao"]); 
    $anvisa = addslashes($_POST["anvisa"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    createProduto($conn, $categoria, $cdg, $descricao, $anvisa);

} else if (isset($_POST["update"])) {
    $prodid = addslashes($_POST["prodid"]);
    $categoria = addslashes($_POST["categoria"]);
    $cdg = addslashes($_POST["cdg"]);
    $descricao = addslashes($_POST["descricao"]);
    $anvisa = addslashes($_POST["anvisa"]);

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    editProduto($conn, $prodid, $categoria, $cdg, $descricao, $anvisa);
} else {
    header("location: ../produtos");
    exit();
}
