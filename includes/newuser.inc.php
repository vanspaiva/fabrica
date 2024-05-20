<?php
if (isset($_POST["new"])) {

    $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $identificador = addslashes($_POST["identificador"]);
    $aprov = addslashes($_POST["aprov"]);
    $perm = addslashes($_POST["perm"]);    
    $pwd = addslashes($_POST["pwd"]);    

    require_once '../db/dbh.inc.php';
    require_once 'functions.inc.php';

    createNewUserAdm($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $pwd);
} else {
    header("location: ../users");
    exit();
}
