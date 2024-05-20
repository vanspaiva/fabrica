<?php

use function PHPSTORM_META\type;

ob_start();
include("php/head_index.php");

require_once 'db/dbh.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"])){

    $id = $_GET['id'];
    $type = $_GET['st'];
    $user = $_SESSION["useruid"];
    
    if($type == 'start'){
        iniciarAtividade($conn, $id, $user);
    }
    if($type == 'stop'){
        concluirAtividade($conn, $id, $user);
    }
    if($type == 'pause'){
        pausarAtividade($conn, $id, $user);
    }

} else {
    header("location: index");
    exit();
}
