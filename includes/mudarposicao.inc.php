<?php

if (!empty($_GET['acao'])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $acao = addslashes($_GET['acao']);
    $id = addslashes($_GET['id']);
    $array = addslashes($_GET['array']);

    $array = explode(",", $array);

    $index = array_search($id, $array);

    $idfluxo = addslashes($_GET["idfluxo"]);

    // echo "id: " . $id . "<br>";
    // echo "index: " . $index . "<br>";
    // echo "item p trocar: " . $array[$index + 1] . "<br>";
    // print_r($_GET);
    // echo "<br>";
    
    switch ($acao) {
        case 'mais':
            trocarposicaostatus($conn, $id, $array[$index - 1]);
            break;

        case 'menos':
            trocarposicaostatus($conn, $id, $array[$index + 1]);

            break;

        default:
            # code...
            break;
    }


    $idEncrypted = hashItemNatural($idfluxo);

    header("location: ../descricaofluxo?id=" . $idEncrypted);
} else {
    header("location: ../config_fluxo");
    exit();
}
