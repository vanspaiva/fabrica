<?php
ob_start();
require_once '../db/dbh.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $id = addslashes($_POST["id"]);
    $data_manutenção = addslashes($_POST["data_manutencao"]);
    $executado = addslashes($_POST["executado"]);

    if (empty($_POST["execucao"])) {
        $dtexecucao = null;
    } else {
        $dtexecucao = addslashes($_POST["execucao"]);
    }

    if (empty($_POST["data_manutencao"])) {
        $lote = null;
    } else {
        $lote = addslashes($_POST["data_manutencao"]);
    }


   
    editfrm($conn, $id, $data_manutencao, $executado);
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
