<?php
ob_start();
require_once '../db/dbh.inc.php';
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

    if (empty($_POST["lote"])) {
        $lote = null;
    } else {
        $lote = addslashes($_POST["lote"]);
    }

    if (empty($_POST["nped"])) {
        $nped = null;
    } else {
        $nped = addslashes($_POST["nped"]);
    }

    if (empty($_POST["obs"])) {
        $obs = null;
    } else {
        $obs = addslashes($_POST["obs"]);
    }

   
    editOs($conn, $osid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $lote, $nped, $obs, $user);
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
