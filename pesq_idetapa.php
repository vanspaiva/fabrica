<?php
//Incluir a conexão com banco de dados
require_once 'db/dbh.php';

$id = $_POST['id'];


//Pesquisar no banco de dados nome do usuario referente a palavra digitada
$result = "SELECT * FROM op_etapa WHERE id='$id';";
$resultado = mysqli_query($conn, $result);
if (($resultado) and ($resultado->num_rows != 0)) {
    while ($row = mysqli_fetch_assoc($resultado)) {
        $id  = $row['id'];
        $nome  = $row['nome'];
        $parametro1  = $row['parametro1'];
        $parametro2  = $row['parametro2'];
        $iterev  = $row['iterev'];
    }

    $result = $id . ',' . $nome . ',' . $parametro1 . ',' . $parametro2 . ',' . $iterev;

    echo $result;
}
