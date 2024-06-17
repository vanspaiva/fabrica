<?php
session_start();


date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/xls");

header("Pragma: no-cache");
header("Expires: 0");

require_once 'db/dbh.php';

$output = "";

if (isset($_GET["t"]) && ($_GET["t"] == "om")) {
    header("Content-Disposition: attachment; filename=OrdensManutencao_" . $today . ".xls");

    $output .= "
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>usuario criador</th>
                    <th>e-mail</th>
                    <th>data criacao</th>
                    <th>ultima atualizacao</th>
                    <th>IP criacao</th>
                    <th>setor</th>
                    <th>descricao</th>
                    <th>num maquina</th>
                    <th>nome maquina</th>
                    <th>nome arquivo</th>
                    <th>grau urgencia</th>
                    <th>data entrega solicitada</th>
                    <th>data entrega fabrica</th>
                    <th>data execucao</th>
                    <th>obs</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
    ";

    $query = $conn->query("SELECT * FROM `ordenmanutencao`") or die(mysqli_errno());
    while ($fetch = $query->fetch_array()) {

        $output .= "
            <tr>
                <td>" . $fetch['omId'] . "</td>
                <td>" . $fetch['omNomeCriador'] . "</td>
                <td>" . $fetch['omEmailCriador'] . "</td>
                <td>" . $fetch['omDtCriacao'] . "</td>
                <td>" . $fetch['omDtUpdate'] . "</td>
                <td>" . $fetch['omUserIp'] . "</td>
                <td>" . tirarAcentos($fetch['omSetor']) . "</td>
                <td>" . tirarAcentos($fetch['omDescricao']) . "</td>
                <td>" . $fetch['omNumMaquina'] . "</td>
                <td>" . $fetch['omNomeMaquina'] . "</td>
                <td>" . tirarAcentos($fetch['omNomeArquivo']) . "</td>
                <td>" . $fetch['omGrauUrgencia'] . "</td>
                <td>" . $fetch['omDtEntregasDesejada'] . "</td>
                <td>" . $fetch['omDtEntregaReal'] . "</td>
                <td>" . $fetch['dtExecucao'] . "</td>
                <td>" . tirarAcentos($fetch['omObs']) . "</td>
                <td>" . tirarAcentos($fetch['omStatus']) . "</td>

            </tr>
        ";
    }

    $output .= "
            </tbody>
        </table>
    ";
} else if (isset($_GET["t"]) && ($_GET["t"] == "os")) {
    header("Content-Disposition: attachment; filename=OrdensServico_" . $today . ".xls");

    $output .= "
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>usuario criador</th>
                    <th>e-mail</th>
                    <th>data criacao</th>
                    <th>ultima atualizacao</th>
                    <th>IP criacao</th>
                    <th>setor</th>
                    <th>descricao</th>
                    <th>lote</th>
                    <th>num pedido</th>
                    <th>nome arquivo</th>
                    <th>grau urgencia</th>
                    <th>data entrega solicitada</th>
                    <th>data entrega fabrica</th>
                    <th>data execucao</th>
                    <th>obs</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
    ";

    $query = $conn->query("SELECT * FROM `ordenservico`") or die(mysqli_errno());
    while ($fetch = $query->fetch_array()) {

        $output .= "
            <tr>
                <td>" . $fetch['osId'] . "</td>
                <td>" . $fetch['osNomeCriador'] . "</td>
                <td>" . $fetch['osEmailCriador'] . "</td>
                <td>" . $fetch['osDtCriacao'] . "</td>
                <td>" . $fetch['osDtUpdate'] . "</td>
                <td>" . $fetch['osUserIp'] . "</td>
                <td>" . tirarAcentos($fetch['osSetor']) . "</td>
                <td>" . tirarAcentos($fetch['osDescricao']) . "</td>
                <td>" . $fetch['osLote'] . "</td>
                <td>" . $fetch['osNPed'] . "</td>
                <td>" . tirarAcentos($fetch['osNomeArquivo']) . "</td>
                <td>" . $fetch['osGrauUrgencia'] . "</td>
                <td>" . $fetch['osDtEntregasDesejada'] . "</td>
                <td>" . $fetch['osDtEntregaReal'] . "</td>
                <td>" . $fetch['dtExecucao'] . "</td>
                <td>" . tirarAcentos($fetch['osObs']) . "</td>
                <td>" . tirarAcentos($fetch['osStatus']) . "</td>

            </tr>
        ";
    }

    $output .= "
            </tbody>
        </table>
    ";
}

echo $output;

function tirarAcentos($string)
{
    return preg_replace(array("/(á|à|ã|â|ä)/", "/(Á|À|Ã|Â|Ä)/", "/(é|è|ê|ë)/", "/(É|È|Ê|Ë)/", "/(í|ì|î|ï)/", "/(Í|Ì|Î|Ï)/", "/(ó|ò|õ|ô|ö)/", "/(Ó|Ò|Õ|Ô|Ö)/", "/(ú|ù|û|ü)/", "/(Ú|Ù|Û|Ü)/", "/(ñ)/", "/(Ñ)/"), explode(" ", "a A e E i I o O u U n N"), $string);
}
