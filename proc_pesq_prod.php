<?php
//Incluir a conexão com banco de dados
require_once 'db/dbh.php';


$cdg = $_POST['cdg'];

$result_prod = "SELECT DISTINCT * FROM produtos WHERE prodCodCallisto LIKE '%$cdg%';";
$resultado_prod = mysqli_query($conn, $result_prod);
if (($resultado_prod) and ($resultado_prod->num_rows != 0)) {
    // $prod = $resultado_prod['prodCodCallisto'];
    while ($row = mysqli_fetch_array($resultado_prod)) {
        $cdg = $row['prodCodCallisto'];
        $descricao = $row['prodDescricao'];

        echo '
        <tr id="trNew">
            <td><input type="text" class="form-control" id="itemCdg" name="itemCdg" value="' . $row['prodCodCallisto'] . '" readonly></td>
            <td><input type="text" class="form-control" id="itemNome" name="itemNome" value="' . $row['prodDescricao'] . '" readonly></td>
            <td><span class="btn" onclick="adicionarnalista(this)"><i class="far fa-plus-square" style="color: #000;"></i></span></td>
        </tr>
        ';
    }
    // echo $cdg . '/' . $descricao;
} else {
    echo '';
}
