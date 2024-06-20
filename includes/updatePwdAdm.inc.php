<?php
if (isset($_POST["novasenha"])) {

    $pwd = addslashes($_POST["pwd"]);
    $user = addslashes($_POST["usuario"]);
    
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    editPwdAdm($conn, $user, $pwd);

} else {
    header("location: ../mudarsenha");
    exit();
}

