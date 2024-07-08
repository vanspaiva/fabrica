<?php
session_start();
date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/vnd.ms-excel");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'db/dbh.php';
require_once 'includes/functions.inc.php';

if (isset($_GET['l'])) {

    $tipo = $_GET["l"];

    if ($tipo == 'atrasados') {
        header("Content-Disposition: attachment; filename=ListaPedidoAtrasados_" . $today . ".xls");
        $arrayEtapasAtrasadas = arrayEtapasAtrasadas($conn);

        $output = "";

        $output .= "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Num Pedido</th>
                        <th>Modalidade</th>
                        <th>Etapa</th>
                        <th>Status</th>
                        <th>Dt</th>
                        <th>Dias em Atraso</th>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach ($arrayEtapasAtrasadas as $key => $value) {

            $value = intval($value);

            $sql = "SELECT 
                r.id AS idRealizacaoProducao,
                r.numOrdem AS ordem,
                r.dataRealizacao AS dt,
                r.idEtapa AS idEtapa,
                e.nome AS nomeEtapa,
                s.nome AS nomeStatus,
                s.id AS idStatus,
                s.cor AS corStatus,
                pd.pedido AS numPed,
                pd.id AS idPed,
                f.nome AS nomeFluxo
                FROM pedidos AS pd 
                RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                WHERE r.id = $value;";

            $ret = mysqli_query($conn, $sql);
            if ($ret) {
                while ($row = mysqli_fetch_assoc($ret)) {
                    $numPed = $row["numPed"];
                    $pedId = $row["idPed"];
                    $nomeFluxo = tirarAcentos($row["nomeFluxo"]);
                    $nomeEtapa = tirarAcentos($row["nomeEtapa"]);
                    $nomeStatus = $row["nomeStatus"];
                    $corStatus = $row["corStatus"];
                    $data = dateFormatByHifen($row["dt"]);
                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                    $output .= "
                        <tr>
                            <td>" . $numPed . "</td>
                            <td>" . $nomeFluxo . "</td>
                            <td>" . $nomeEtapa . "</td>
                            <td>" . $nomeStatus . "</td>
                            <td>" . $data . "</td>
                            <td>" . $diasEmAtraso . "</td>
                        </tr>";
                }
            }
        }

        $output .= "
                </tbody>
            </table>
        ";

        echo $output;
    } else if ($tipo == 'hoje') {
        header("Content-Disposition: attachment; filename=ListaPedidoHoje_" . $today . ".xls");
        $arrayEtapasHoje = arrayEtapasHoje($conn);

        $output = "";

        $output .= "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Num Pedido</th>
                        <th>Modalidade</th>
                        <th>Etapa</th>
                        <th>Status</th>
                        <th>Dt</th>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach ($arrayEtapasHoje as $key => $value) {

            $value = intval($value);

            $sql = "SELECT 
                r.id AS idRealizacaoProducao,
                r.numOrdem AS ordem,
                r.dataRealizacao AS dt,
                r.idEtapa AS idEtapa,
                e.nome AS nomeEtapa,
                s.nome AS nomeStatus,
                s.id AS idStatus,
                s.cor AS corStatus,
                pd.pedido AS numPed,
                pd.id AS idPed,
                f.nome AS nomeFluxo
                FROM pedidos AS pd 
                RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                WHERE r.id = $value;";

            $ret = mysqli_query($conn, $sql);
            if ($ret) {
                while ($row = mysqli_fetch_assoc($ret)) {
                    $numPed = $row["numPed"];
                    $pedId = $row["idPed"];
                    $nomeFluxo = tirarAcentos($row["nomeFluxo"]);
                    $nomeEtapa = tirarAcentos($row["nomeEtapa"]);
                    $nomeStatus = $row["nomeStatus"];
                    $corStatus = $row["corStatus"];
                    $data = dateFormatByHifen($row["dt"]);
                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                    $output .= "
                        <tr>
                            <td>" . $numPed . "</td>
                            <td>" . $nomeFluxo . "</td>
                            <td>" . $nomeEtapa . "</td>
                            <td>" . $nomeStatus . "</td>
                            <td>" . $data . "</td>
                        </tr>";
                }
            }
        }

        $output .= "
                </tbody>
            </table>
        ";

        echo $output;
    }else if ($tipo == 'amanha') {
        header("Content-Disposition: attachment; filename=ListaPedidoAmanha_" . $today . ".xls");
        $arrayEtapasAmanha = arrayEtapasAmanha($conn);

        $output = "";

        $output .= "
            <table border='1'>
                <thead>
                    <tr>
                        <th>Num Pedido</th>
                        <th>Modalidade</th>
                        <th>Etapa</th>
                        <th>Status</th>
                        <th>Dt</th>
                    </tr>
                </thead>
                <tbody>
        ";

        foreach ($arrayEtapasAmanha as $key => $value) {

            $value = intval($value);

            $sql = "SELECT 
                r.id AS idRealizacaoProducao,
                r.numOrdem AS ordem,
                r.dataRealizacao AS dt,
                r.idEtapa AS idEtapa,
                e.nome AS nomeEtapa,
                s.nome AS nomeStatus,
                s.id AS idStatus,
                s.cor AS corStatus,
                pd.pedido AS numPed,
                pd.id AS idPed,
                f.nome AS nomeFluxo
                FROM pedidos AS pd 
                RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
                RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
                RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
                RIGHT JOIN fluxo AS f ON pd.fluxo = f.id 
                WHERE r.id = $value;";

            $ret = mysqli_query($conn, $sql);
            if ($ret) {
                while ($row = mysqli_fetch_assoc($ret)) {
                    $numPed = $row["numPed"];
                    $pedId = $row["idPed"];
                    $nomeFluxo = tirarAcentos($row["nomeFluxo"]);
                    $nomeEtapa = tirarAcentos($row["nomeEtapa"]);
                    $nomeStatus = $row["nomeStatus"];
                    $corStatus = $row["corStatus"];
                    $data = dateFormatByHifen($row["dt"]);
                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                    $output .= "
                        <tr>
                            <td>" . $numPed . "</td>
                            <td>" . $nomeFluxo . "</td>
                            <td>" . $nomeEtapa . "</td>
                            <td>" . $nomeStatus . "</td>
                            <td>" . $data . "</td>
                        </tr>";
                }
            }
        }

        $output .= "
                </tbody>
            </table>
        ";

        echo $output;
    } else {
        echo "Tipo de relatório inválido.";
    }
} else {
    echo "Nenhum parâmetro de tipo fornecido.";
}

mysqli_close($conn);

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}
?>
