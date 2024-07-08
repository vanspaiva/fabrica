<?php
ob_start();
require_once '../db/dbh.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $omid = addslashes($_POST["omid"]);
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

    $tipomanutencao = addslashes(($_POST["tipomanutencao"]));
    $operacional = addslashes(($_POST["operacional"]));
    $acaoquali = addslashes(($_POST["acaoquali"]));
    $requalificar = addslashes(($_POST["requalificar"]));
    $resprequali = addslashes(($_POST["resprequali"]));
    $respmanutencao = addslashes(($_POST["manutencao"]));

    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit();

    editOM($conn, $omid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $nmaquina, $nomemaquina, $obs, $user, $tipomanutencao, $operacional, $acaoquali, $requalificar, $resprequali, $respmanutencao);
    header("location: ../editarom?id=" . $omid);
    exit();
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
