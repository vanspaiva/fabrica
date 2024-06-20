<?php
session_start();

require_once 'db/dbh.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"])) {

    $idPedido = $_GET["idPed"];
    $user = $_SESSION["userid"];
    $hoje = hoje();
    $agora = agora();
    $type = $_GET['a'];
    $idR = $_GET['idR'];
    $etapa = $_GET["etapa"];
    $statual = $_GET["statual"];

    $idStatus = getProximoStatus($statual, $type);
    // $idStatus = getIdStatusByName($conn, $status);

    // print_r($_GET);
    // echo "<br>" . $status;
    // echo "<br>" . $idStatus;
    // exit();
    // inserirLogAtividade($conn, $idRealizacaoProducao, $idUsuario, $idStatus, $data, $hora);
    // inserirTempoCorrido($conn, $idPedido, $idEtapa, $tempoCorrido);

    if ($type == 'play') {
        iniciarAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido);
    }
    if ($type == 'pause') {
        pausarAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido);
    }
    if ($type == 'check') {
        concluirAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido);
    }

    if ($type == 'aprov') {
        aprovAtividadeQuali($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido);
    }

    if ($type == 'reprov') {
        reprovAtividadeQuali($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido);
    }


    if (($_SESSION["usernomedep"] == 'Qualidade')) {
        header("location: inspecaopedido?id=" . $idPedido);
        exit();
    }
} else {
    header("location: dash");
    exit();
}
