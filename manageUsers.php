<?php ob_start();
include("php/head_index.php");

require_once 'includes/dbh.inc.php';
require_once 'includes/functions.inc.php';

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {

    $id = $_GET['id'];

    deleteUser($conn, $id);

} else {
    header("location: index");
    exit();
}
