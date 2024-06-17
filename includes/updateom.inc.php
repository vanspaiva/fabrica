<?php
ob_start();
require_once '../db/dbh.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $osid = addslashes($_POST["osid"]);
    $status = addslashes($_POST["status"]);
    $grau = addslashes($_POST["grau"]);
    $setor = addslashes($_POST["setor"]);
    $dtentrega = addslashes($_POST["dtentrega"]);
    $dtrealentrega = addslashes($_POST["dtrealentrega"]);
    $descricao = addslashes($_POST["descricao"]);
    $user = addslashes($_POST["user"]);

    if (empty($_POST["dtexecucao"])) {
        $dtexecucao = null;
    } else {
        $dtexecucao = addslashes($_POST["dtexecucao"]);
    }

    if (empty($_POST['nmaquina'])) {
        $nmaquina = null;
    } else {
        $nmaquina = addslashes($_POST["nmaquina"]);
    }

    if (empty($_POST['nomemaquina'])) {
        $nomemaquina = null;
    } else {
        $nomemaquina = addslashes($_POST["nomemaquina"]);
    }

    if (empty($_POST["obs"])) {
        $obs = null;
    } else {
        $obs = addslashes($_POST["obs"]);
    }

   
    editOM($conn, $osid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $nmaquina, $nomemaquina, $obs, $user);
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
