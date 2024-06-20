<?php
if (isset($_POST["update"])) {

    $usersid = addslashes($_POST["usersid"]);
    $nome = addslashes($_POST["nome"]);
    $uf = addslashes($_POST["uf"]);
    $email = addslashes($_POST["email"]);
    $uid = addslashes($_POST["uid"]);
    $celular = addslashes($_POST["celular"]);
    $identificador = null;
    $aprov = addslashes($_POST["aprov"]);
    $perm = addslashes($_POST["perm"]);
    $dep = addslashes($_POST["dep"]);

    
    
    
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editUser($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $dep, $usersid);
}  else {
    header("location: ../users");
    exit();
}
