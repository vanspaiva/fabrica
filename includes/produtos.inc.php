<?php
//verificar se esta logado

if (isset($_POST) && isset($_POST["submit"])) {
    $descricao = addslashes($_POST["descricao"]);
    $codigoCllisto = addslashes($_POST["codigoCllisto"]); 

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    createProduto($conn, $descricao, $codigoCllisto);

} else if (isset($_POST["submit_correlacao"])) {
    $idMaster = addslashes($_POST["idMaster"]);
    $IdSecundario = addslashes($_POST["IdSecundario"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    criarCorrelacaoProduto($conn, $idMaster, $IdSecundario);

} else if (isset($_POST["update"])) {
    $prodid = addslashes($_POST["prodid"]);
    $parametro1= addslashes($_POST["parametro1"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editProduto($conn, $prodid, $parametro1);
} else {
    header("location: ../produtos");
    exit();
}
