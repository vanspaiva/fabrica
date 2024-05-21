<?php
require_once 'includes/functions.inc.php';

$destino = 'vanespaiva@gmail.com';
$assunto = "Assunto teste";
$arquivo = "teste 2024";
$returnTrue = "";
$returnFalse = "";

geralSendEmailNotification($destino, $assunto, $arquivo, $returnTrue, $returnFalse);
