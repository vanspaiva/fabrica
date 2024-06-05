<?php
if (isset($_POST["submit"])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $tp_contacriador = addslashes($_POST["tp_contacriador"]);
    $nomecriador = addslashes($_POST["nomecriador"]);
    $emailcriacao = addslashes($_POST["emailcriacao"]);
    $dtcriacao = addslashes($_POST["dtcriacao"]);
    $userip = addslashes($_POST["userip"]);

    $dtentrega = addslashes($_POST["dtentrega"]);
    $setor = addslashes($_POST["setor"]);
    $descricao = addslashes($_POST["descricao"]);
    $grauurgencia = addslashes($_POST["grauurgencia"]);

    $urlArquivo = addslashes($_POST["urlThrowback"]);

    if (empty($_POST['lote'])) {
        $lote = null;
    } else {
        $lote = addslashes($_POST["lote"]);
    }

    if (empty($_POST['nped'])) {
        $nped = null;
    } else {
        $nped = addslashes($_POST["nped"]);
    }

    if (empty($_POST['obs'])) {
        $obs = null;
    } else {
        $obs = addslashes($_POST["obs"]);
    }

    if (empty($_FILES["formFile"]["name"])) {
        $pname = null;
        $tname = null;
    } else {
        #file name with a random number so that similar dont get replaced
        $pname = rand(1000, 10000) . "-" . $_FILES["formFile"]["name"];

        #temporary file name to store file
        $tname = $_FILES["formFile"]["tmp_name"];
    }



    createOS($conn, $tp_contacriador, $nomecriador, $emailcriacao, $dtcriacao, $userip, $dtentrega, $setor, $descricao, $grauurgencia, $lote, $nped, $obs, $tname, $urlArquivo);
} else {
    header("location: ../solicitacao");
    exit();
}
