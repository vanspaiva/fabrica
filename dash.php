<?php

session_start();

if (isset($_SESSION["useruid"])) {
    
    include("php/head_tables.php");
    $user = $_SESSION["useruid"];
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    

?>


    <body class="bg-light-gray2">

        <?php

        include_once("dashboard/dash.view.php");

        ?>

    </body>



    <?php include_once 'php/footer_index.php' ?>

<?php
} else {
    header("location: login");
    exit();
}
?>