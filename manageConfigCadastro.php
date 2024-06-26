<?php 
session_start();

if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    // include("php/head_index.php");
    
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    if (!empty($_GET['deleteestado'])){
        $id = $_GET['deleteestado'];
        deleteEstado($conn, $id);
    }

    if (!empty($_GET['deletecadin'])){
        $id = $_GET['deletecadin'];
        deleteCadin($conn, $id);
    }

    if (!empty($_GET['deletecadex'])){
        $id = $_GET['deletecadex'];
        deleteCadex($conn, $id);
    }

    if (!empty($_GET['deleteetapaos'])){
        $id = $_GET['deleteetapaos'];
        deleteEtapaOs($conn, $id);
    }

    if (!empty($_GET['deletestatus'])){
        $id = $_GET['deletestatus'];
        deleteStatus($conn, $id);
    }

    if (!empty($_GET['deletedep'])){
        $id = $_GET['deletedep'];
        deleteDepartamento($conn, $id);
    }


} else {
    header("location: index");
    exit();
}
