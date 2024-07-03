<?php
if (isset($_POST["new"])) {    

    $nome = addslashes($_POST["nome"]);
    $email = addslashes($_POST["email"]);
    $celular = addslashes($_POST["celular"]);
    $aprov = addslashes($_POST["aprov"]);
    $perm = addslashes($_POST["perm"]);
    $dep = addslashes($_POST["dep"]);
    $pwd   = addslashes($_POST["pwd"]);

    $identificador = null;
    $uf = 'DF';

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $username = cleanString(extrairNomeUsuario($email));

    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../users?error=emailtaken");
        exit();
    }

    createNewUserAdm($conn, $nome, $uf, $email, $username, $celular, $identificador, $aprov, $perm, $pwd, $dep);

} else {
    header("location: ../users");
    exit();
}
