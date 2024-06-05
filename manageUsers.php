<?php 
session_start();

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    include("php/head_index.php");
    
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';
    
    $id = $_GET['id'];

    deleteUser($conn, $id);

} else {
    header("location: index");
    exit();
}
