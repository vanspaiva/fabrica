<?php 
session_start();

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {
    
    include("php/head_index.php");
    
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';
    $id = $_GET['id'];

    deleteProd($conn, $id);

} else {
    header("location: index");
    exit();
}
