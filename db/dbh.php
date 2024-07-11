<?php


//$serverName = "localhost";
//$dbUsername = "u777557116_adminfabrica";
//$dbPassword = "CcIB8WQT36a";
//$dbName = "u777557116_bdcpmhfabrica";

$serverName = "localhost:3307";
$dbUsername = "root";
$dbPassword = "";
$dbName = "fabrica";


$conn = mysqli_connect($serverName, $dbUsername, $dbPassword, $dbName);
// $mysqli = new mysqli($serverName, $dbUsername, $dbPassword, $dbName) or die(mysqli_error($mysqli));
if(mysqli_connect_errno())
{
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}