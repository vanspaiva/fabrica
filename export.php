<?php

date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=OrdensServico_".$today.".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'db/dbh.inc.php';

$output = "";

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

echo $output;

function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}
