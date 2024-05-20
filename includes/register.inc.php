<?php


if (isset($_POST["submit"])) {

    // $username = addslashes($_POST["username"]);
    // $identificador = addslashes($_POST["identificador"]);
    // $uf = addslashes($_POST["uf"]);
    
    $name = addslashes($_POST["name"]);
    $email = addslashes($_POST["email"]);
    $celular = addslashes($_POST["celular"]);
    $identificador = null;
    $uf = 'DF';


    $terms = addslashes($_POST["termsCheck"]);

    if(empty($_POST["termsCheck"])){
        header("location: ../cadastro?error=termserror");
        exit();
    }


    $pwd = addslashes($_POST["password"]);
    $pwdrepeat = addslashes($_POST["confirmpassword"]);
    $permission = "3COL";
    $aprovacao = "APROV";    
    

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    $username = extrairNomeUsuario($email);

    if (emptyInputSignup($name, $username, $email, $celular, $identificador, $uf, $pwd ,$pwdrepeat) !== false) {
        header("location: ../cadastro?error=emptyinput");
        exit();
    }

    if (invalidUid($username) !== false) {
        header("location: ../cadastro?error=invaliduid");
        exit();
    }

    if (invalidEmail($email) !== false) {
        header("location: ../cadastro?error=invalidemail");
        exit();
    }

    if (pwdMatch($pwd, $pwdrepeat) !== false) {
        header("location: ../cadastro?error=passworddontmatch");
        exit();
    }

    if (uidExists($conn, $username, $email) !== false) {
        header("location: ../cadastro?error=usernametaken");
        exit();
    }

    createUser($conn, $name, $username, $email, $celular, $identificador, $uf, $pwd, $permission, $aprovacao);

} else {
    header("location: ../cadastro");
    exit();
}
