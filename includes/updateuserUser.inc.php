<?php
if (isset($_POST["update"])) {

    $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $identificador = addslashes($_POST["identificador"]);

   

    require_once '../db/dbh.inc.php';
    require_once 'functions.inc.php';

    editUserFromUser($conn, $usersid, $nome, $uf, $email, $uid, $celular, $identificador);
} else {
    header("location: ../index");
    exit();
}
