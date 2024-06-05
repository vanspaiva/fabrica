<?php
session_start();

if (isset($_POST["nvetapa"])) {

    $nome = addslashes($_POST['nome']);

    if (empty($_POST['parametro1'])) {
        $parametro1 = null;
    } else {
        $parametro1 = addslashes($_POST['parametro1']);
    }

    if (empty($_POST['parametro2'])) {
        $parametro2 = null;
    } else {
        $parametro2 = addslashes($_POST['parametro2']);
    }

    if (empty($_POST['iterev'])) {
        $iterev = null;
    } else {
        $iterev = addslashes($_POST['iterev']);
    }

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    novaEtapa($conn, $nome, $parametro1, $parametro2, $iterev);

    header("location: ../config_etapas");
} else if (isset($_POST["edetapa"])) {

    $id = addslashes($_POST['editid']);
    $nome = addslashes($_POST['editnome']);

    if (empty($_POST['editparametro1'])) {
        $parametro1 = null;
    } else {
        $parametro1 = addslashes($_POST['editparametro1']);
    }

    if (empty($_POST['editparametro2'])) {
        $parametro2 = null;
    } else {
        $parametro2 = addslashes($_POST['editparametro2']);
    }

    if (empty($_POST['edititerev'])) {
        $iterev = null;
    } else {
        $iterev = addslashes($_POST['edititerev']);
    }

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editarEtapa($conn, $id, $nome, $parametro1, $parametro2, $iterev);

    header("location: ../config_etapas");
} else if (!empty($_GET['dltetapa'])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $id = addslashes($_GET['dltetapa']);
    deleteEtapa($conn, $id);

    header("location: ../config_etapas");
} else if (isset($_POST["nvfluxo"])) {

    $nome = addslashes($_POST['nome']);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    novaFluxo($conn, $nome);

    header("location: ../config_fluxo");
} else if (isset($_POST["edfluxo"])) {

    $id = addslashes($_POST['editid']);
    $nome = addslashes($_POST['editnome']);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editarFluxo($conn, $id, $nome);

    header("location: ../config_fluxo");
} else if (!empty($_GET['dltfluxo'])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $id = addslashes($_GET['dltfluxo']);
    deleteFluxo($conn, $id);

    header("location: ../config_fluxo");
} else if (isset($_POST["addEtapaToFluxo"])) {

    $idfluxo = addslashes($_POST["idfluxo"]);
    $idetapa = addslashes($_POST["idetapa"]);
    // $ordem = addslashes($_POST["ordem"]);
    $duracao = addslashes($_POST["duracao"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    novaEtapaEmFluxo($conn, $idfluxo, $idetapa, $duracao);

    $idEncrypted = hashItemNatural($idfluxo);

    header("location: ../descricaofluxo?id=" . $idEncrypted);
} else if (isset($_POST["editEtapaToFluxo"])) {

    $id = addslashes($_POST["editid"]);
    $idfluxo = addslashes($_POST["editidfluxo"]);
    $idetapa = addslashes($_POST["editidetapa"]);
    // $ordem = addslashes($_POST["editordem"]);
    $duracao = addslashes($_POST["editduracao"]);

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editEtapaEmFluxo($conn, $id, $idetapa, $duracao);

    $idEncrypted = hashItemNatural($idfluxo);

    header("location: ../descricaofluxo?id=" . $idEncrypted);
} else if (!empty($_GET['dltetapaemfluxo'])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $id = addslashes($_GET['dltetapaemfluxo']);
    $idfluxo = addslashes($_GET['idfluxo']);
    deleteEtapaEmFluxo($conn, $id);

    $idEncrypted = hashItemNatural($idfluxo);

    header("location: ../descricaofluxo?id=" . $idEncrypted);
} else {
    header("location: ../dash");
    exit();
}

