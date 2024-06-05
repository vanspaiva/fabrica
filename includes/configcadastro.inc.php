<?php


if (isset($_POST["novoestado"])) {

    $nome = addslashes($_POST['nome']);
    $abrev = addslashes($_POST['abrev']);


    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    addEstado($conn, $nome, $abrev);

} else if (isset($_POST["novocadin"])) {

    $nome = addslashes($_POST['nome']);
    $codigo = addslashes($_POST['codigo']);
   

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    addCadin($conn, $nome, $codigo);

} else if (isset($_POST["novocadex"])) {

    $nome = addslashes($_POST['nome']);
    $codigo = addslashes($_POST['codigo']);
   

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    addCadex($conn, $nome, $codigo);

} else if (isset($_POST["novoetapaos"])) {

    $nome = addslashes($_POST['nome']);
   

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    addEtapaOs($conn, $nome);

}else if (isset($_POST["novostatus"])) {

    $nome = addslashes($_POST['nome']);
    $posicao = addslashes($_POST['posicao']);
   

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    addStatusOs($conn, $nome, $posicao);

} else{
    header("location: ../gercadastro");
    exit();
} 

