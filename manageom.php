<?php 

session_start();

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    $id = $_GET['id'];

    deleteOM($conn, $id);
} else {
    header("location: index");
    exit();
}
