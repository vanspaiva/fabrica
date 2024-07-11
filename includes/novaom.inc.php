<?php


echo "<pre>";
print_r($_POST);
echo "</pre>";



if (isset($_POST["submit"])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';


    $tpManutenção = addslashes($_POST['tipo_manutencao']);
    $mqOperacinal = addslashes($_POST['maqOperavel']);


    $tp_contacriador = addslashes($_POST["tp_contacriador"]);
    $nomecriador = addslashes($_POST["nomecriador"]);
    $emailcriacao = addslashes($_POST["emailcriacao"]);
    $dtcriacao = addslashes($_POST["dtcriacao"]);
    $userip = addslashes($_POST["userip"]);

    //$dtentrega = addslashes($_POST["dtentrega"]);
    $dtentrega = "None";
    //$setor = addslashes($_POST["setor"]);
    $setor = "None";
    $descricao = addslashes($_POST["descricao"]);
    $grauurgencia = addslashes($_POST["grauurgencia"]);

    $urlArquivo = addslashes($_POST["urlThrowback"]);

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



    createOM($conn, $tp_contacriador, $nomecriador, $emailcriacao, $dtcriacao, $userip, $dtentrega, $setor, $descricao, $grauurgencia, $nmaquina, $nomemaquina, $obs, $tname, $urlArquivo, $tpManutenção, $mqOperacinal);
} else {
    header("location: ../solicitacao");
    exit();
}
