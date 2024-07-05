<?php
session_start();

date_default_timezone_set('UTC');
$dtz = new DateTimeZone("America/Sao_Paulo");
$dt = new DateTime("now", $dtz);
$today = $dt->format("d.m.Y") . "_" . $dt->format("H'i's");

header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=RegistroDeManutencao _".$today.".xls");
header("Pragma: no-cache");
header("Expires: 0");

require_once 'db/dbh.php';

$output = "";

$output .= "
	<table>
		<thead>
			<tr>
				<th>ID</th>
				<th>Responsável</th>
				<th>Data de Publicação</th>
				<th>Data de Manutenção</th>
				<th>Marca/Modelo</th>
				<th>Setor</th>
				<th>Descrição</th>
				<th>Status</th>
			</tr>
		</thead>
		<tbody>
";

$query = $conn->query("SELECT * FROM `frm_inf_004`") or die(mysqli_error($conn));
while ($fetch = $query->fetch_array()) {
    $output .= "
		<tr>
			<td>" . $fetch['id'] . "</td>
			<td>" . $fetch[' userId'] . "</td>
			<td>" . $fetch['data_publicacao'] . "</td>
			<td>" . $fetch['data_manutencao'] . "</td>
			<td>" . $fetch['modelo'] . "</td>
			<td>" . tirarAcentos($fetch['descricao_setores']) . "</td>
			<td>" . tirarAcentos($fetch['descricao_atividades']) . "</td>
			<td>" . tirarAcentos($fetch['frmStatus']) . "</td>
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
?>
