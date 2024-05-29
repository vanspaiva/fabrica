<?php
$serverName = "localhost";
$dbUsername = "u777557116_adminconecta";
$dbPassword = "YDT8HJPHc!";
$dbName = "u777557116_bdcpmhconecta";

// $serverName_b = "localhost";
// $dbUsername_b = "root";
// $dbPassword_b = "";
// $dbName_b = "conecta";

$conn_b = mysqli_connect($serverName_b, $dbUsername_b, $dbPassword_b, $dbName_b);

if (mysqli_connect_errno()) {
    echo "Error: Falha ao conectar-se com o banco de dados MySQL." . PHP_EOL;
    echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
