<?php
session_start();
// include("php/head_index.php");

require_once 'db/dbh.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"])) {

    $id = $_GET['id'];
    $type = $_GET['st'];
    $user = $_SESSION["useruid"];
    $form = $_GET["type"];

    

    if ($form == 'os') {
        if ($type == 'start') {
            iniciarAtividade($conn, $id, $user);
        }
        if ($type == 'stop') {
            concluirAtividade($conn, $id, $user);
        }
        if ($type == 'pause') {
            pausarAtividade($conn, $id, $user);
        }

        // echo "1";
        // exit();
    } else {
        if ($type == 'start') {
            iniciarAtividadeOM($conn, $id, $user);
        }
        if ($type == 'stop') {
            concluirAtividadeOM($conn, $id, $user);
        }
        if ($type == 'pause') {
            pausarAtividadeOM($conn, $id, $user);
        }
        // echo "2";
        // exit();
    }
} else {
    header("location: dash");
    exit();
}
