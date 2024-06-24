<?php
ob_start();
require_once '../db/dbh.php';
require_once 'functions.inc.php';

if (isset($_POST["update"])) {

    $id = addslashes($_POST["id"]);
    $dataManutencao = addslashes($_POST["dataManutencao"]);
    $executado = array(); // Inicialize um array para guardar os valores de executado

    // Recupere os valores de executado do $_POST usando um loop
    for ($i = 1; $i <= 12; $i++) {
        $executado[$i] = addslashes($_POST["executado$i"]);
    }
    $user = addslashes($_POST["user"]);
   
    editFrm($conn, $id, $dataPublicacao, $dataValidade, $dataPublicacao, $identificadorAmbiente, $tipoAtividade, $dataManutencao, $marcaModelo, $executado1, $executado2, $executado3, $executado4, $executado5, $executado6, $executado7, $executado8, $executado9, $executado10, $executado11, $executado12, $user);
} 
// else {
//     header("location: ../comercial");
//     exit();
// }
