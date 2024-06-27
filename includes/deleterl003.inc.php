<?php

    if (isset($_GET['id'])) {

        require_once '../db/dbh.php';
        require_once 'functions.inc.php';

        $id = $_GET["id"];

        deleteForm003($conn,$id);
    }
    else{
        header('Location: ../showForm003.php');
        exit();
    }


