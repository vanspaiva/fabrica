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
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } elseif ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Ordem de Serviço foi deletada!</p></div>";
                    } elseif ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } elseif ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço foi criada com sucesso!</p></div>";
                    } elseif ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Ordem de Serviço!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>OP - Planejamento de Etapas da Produção</b></h5>
                                <small class="text-muted">Conferência de datas e prazos das etapas da OP</small>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="" style="overflow-x: scroll;">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tablePedido" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Situação</th>
                                                <th>Num Ped</th>
                                                <th>Dt Aceite</th>
                                                <th>Produto</th>
                                                <th class="text-center">Dias P/ Produzir</th>
                                                <th>Fases</th>
                                                <th>Etapa Atual</th>
                                                <th>Resp</th>
                                                <th>Próx Etapa</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT p.id AS idPedido, 
                                                p.projetista, 
                                                p.dr, 
                                                p.pac, 
                                                p.rep, 
                                                p.pedido AS numPedido, 
                                                p.dt, 
                                                p.produto AS Produto, 
                                                p.dataEntrega AS dataEntrega, 
                                                p.fluxo AS Fluxo, 
                                                p.lote, 
                                                p.cdgprod, 
                                                p.qtds, 
                                                p.descricao, 
                                                MIN(rp.id) AS rp_id, 
                                                MIN(rp.idFluxo) AS idFluxo, 
                                                MIN(rp.numOrdem) AS numOrdem, 
                                                MIN(rp.idEtapa) AS idEtapa, 
                                                MIN(rp.dataRealizacao) AS dataRealizacao,
                                                COUNT(rp.idEtapa) AS qtdEtapas
                                                FROM pedidos p
                                                JOIN realizacaoproducao rp ON p.id = rp.idPedido
                                                GROUP BY p.id;";
                                            $ret = mysqli_query($conn, $sql);
                                            if ($ret) {
                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                    $ID = $row["idPedido"];
                                                    $fluxoID = $row["Fluxo"];
                                                    $dt = $row["dt"];

                                                    // Obter o nome do fluxo com base no ID
                                                    $fluxoQuery = "SELECT nome FROM fluxo WHERE id = '$fluxoID'";
                                                    $fluxoResult = mysqli_query($conn, $fluxoQuery);
                                                    $fluxoData = mysqli_fetch_assoc($fluxoResult);
                                                    $nomeFluxo = $fluxoData ? $fluxoData['nome'] : 'N/A';

                                                    // Calcular a duração se a variável $fluxoID não estiver vazia
                                                    if (!empty($fluxoID)) {
                                                        $duracaoQuery = "
                                                        SELECT SUM(duracao) AS duracaoTotal
                                                        FROM etapa_fluxo
                                                        WHERE idfluxo = '$fluxoID'
                                                    ";
                                                        $duracaoResult = mysqli_query($conn, $duracaoQuery);
                                                        $duracaoData = mysqli_fetch_assoc($duracaoResult);

                                                        if ($duracaoData && isset($duracaoData['duracaoTotal'])) {
                                                            $duracaoHoras = $duracaoData['duracaoTotal'];

                                                            // Converter a Duração Total para Dias Úteis e Horas
                                                            $horasPorDia = 9; // ajuste conforme as horas úteis por dia
                                                            $diasTotal = $duracaoHoras / $horasPorDia;
                                                            $diasInteiros = floor($diasTotal);
                                                            $horasRestantes = ($diasTotal - $diasInteiros) * $horasPorDia;

                                                            // Calcular a Data de Produção
                                                            $timestampPedido = strtotime($dt); // Usando a data do pedido
                                                            $diasCalculados = 0;

                                                            while ($diasCalculados < $diasTotal) {
                                                                $timestampPedido += 24 * 3600; // adicionar um dia
                                                                $diaDaSemana = date('N', $timestampPedido); // 1 (segunda-feira) até 7 (domingo)

                                                                if ($diaDaSemana < 6) { // dias úteis são de segunda a sexta
                                                                    $diasCalculados++;
                                                                }
                                                            }

                                                            // Adicionar as horas restantes ao final do último dia útil
                                                            $timestampPedido += $horasRestantes * 3600;

                                                            // Subtrair um dia para ajustar a data prevista
                                                            $timestampPedido -= 24 * 3600; // subtrair 1 dia (24 horas)

                                                            $dataProducao = date('Y-m-d H:i:s', $timestampPedido);
                                                            $dataProducaoFormatada = date('d/m/Y H:i', strtotime($dataProducao));

                                                            // Exibindo as datas e durações
                                                            $DiasPProduzir = $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas";
                                                            $dataProducaoFormatadaExibida = $dataProducaoFormatada;
                                                        } else {
                                                            $DiasPProduzir = "N/A";
                                                            $dataProducaoFormatadaExibida = "N/A";
                                                        }
                                                    } else {
                                                        $DiasPProduzir = "N/A";
                                                        $dataProducaoFormatadaExibida = "N/A";
                                                    }

                                                    $dataEntrega = $row["dataEntrega"];
                                                    $dtAceite = subtrairDiasUteis($dataEntrega, 20);
                                                    $dataEntregaEstoque = subtrairDiasUteis($dataEntrega, 2);
                                                    $dataEntregaCliente = dateFormatByHifen($dataEntrega);
                                                    $diasFaltantes = diasFaltandoParaData($dataEntrega);
                                                    $DiasFaltantesNumber = $diasFaltantes;
                                                    if ($DiasFaltantesNumber <= 0) {
                                                        $DiasFaltantes = '<b class="text-danger"> Data de entrega excedida! </b>';
                                                    } else {
                                                        $DiasFaltantes = $DiasFaltantesNumber . ' dias';
                                                    }
                                                    $etapasAtrasadas = contarEtapasAtrasadas($conn, $ID);
                                                    if ($etapasAtrasadas == 0) {
                                                        $Situação = "<span class='badge badge-success'>Cumprindo Prazo </span>";
                                                    } elseif ($etapasAtrasadas == 1) {
                                                        $Situação = "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapa atrasada </span>";
                                                    } else {
                                                        $Situação = "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapas atrasadas </span>";
                                                    }
                                                    /* $etapaAtual = getEtapaAtual($conn, $ID);
                                                    $respEtapaAtualId = getRespEtapaAtual($conn, $ID, $etapaAtual);
                                                    $nomeRespEtapaAtual = ($respEtapaAtualId != "N/A") ? $respEtapaAtualId : "N/A";


                                                    if ($respEtapaAtualId == "N/A") {
                                                        $nomeproximaEtapa = $nomeEtapaAtual;
                                                    } else {
                                                        $proximaEtapa = getProximaEtapa($conn, $ID, $etapaAtual);
                                                        $nomeproximaEtapa = ($proximaEtapa != "N/A") ? getNomeEtapa($conn, $proximaEtapa) : "N/A";
                                                    }     */
                                                    // Obter a etapa atual
                                                    // Obter a etapa atual
                                                    $etapasAtrasadas = contarEtapasAtrasadas($conn, $ID);
                                                    $Situação = ($etapasAtrasadas == 0) ? "<span class='badge badge-success'>Cumprindo Prazo </span>" :
                                                                (($etapasAtrasadas == 1) ? "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapa atrasada </span>" :
                                                                "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapas atrasadas </span>");
                                                    
                                                    // Obter a etapa atual
                                                    $etapaAtual = getEtapaAtual($conn, $ID);
                                                    $nomeEtapaAtual = ($etapaAtual != "N/A") ? getNomeEtapa($conn, $etapaAtual) : "N/A";

                                                    // Obter o responsável pela etapa atual
                                                    $respEtapaAtual = getRespEtapaAtual($conn, $ID, $etapaAtual);
                                                    $nomeRespEtapaAtual = ($respEtapaAtual != "N/A") ? $respEtapaAtual : "N/A";

                                                    // Determinar a próxima etapa
                                                    if ($respEtapaAtual == "N/A") {
                                                        $nomeproximaEtapa = $nomeEtapaAtual;
                                                    } else {
                                                        $proximaEtapa = getProximaEtapa($conn, $ID, $etapaAtual);
                                                        $nomeproximaEtapa = ($proximaEtapa != "N/A") ? getNomeEtapa($conn, $proximaEtapa) : "N/A";
                                                    }

                                                    // Definir a cor de fundo com base nos dias faltantes
                                                    $bgAtraso = ($DiasFaltantesNumber <= 5 && $DiasFaltantesNumber > 0) ? '#ebd38b' :
                                                                (($DiasFaltantesNumber <= 0) ? "#edb0b6" : "");



                                            ?>
                                                    <tr style="background-color: <?php echo $bgAtraso; ?>;">
                                                        <td>
                                                            <div class="d-flex">
                                                                <a href="visualizarpedido?id=<?php echo $ID; ?>">
                                                                    <button class="btn btn-success m-1"><i class="fas fa-expand"></i></button></a>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $Situação; ?></td>
                                                        <td><b><?php echo $row["numPedido"]; ?></b></td>
                                                        <td><?php echo $dt; ?></td>
                                                        <td><?php echo htmlspecialchars($nomeFluxo); ?></td>
                                                        <td>
                                                            <div class="d-flex justify-content-center">
                                                                <?php echo $DiasPProduzir; ?>
                                                            </div>
                                                        </td>
                                                        <td><?php echo $row["qtdEtapas"]; ?></td>
                                                        <td><?php echo $nomeEtapaAtual; ?></td>
                                                        <td><?php echo $respEtapaAtual; ?></td>
                                                        <td><?php echo $nomeproximaEtapa; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "Erro na consulta ao banco de dados: " . mysqli_error($conn);
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </body>
    <?php include_once 'php/footer_index.php' ?>
    <script>
        $(document).ready(function() {
            $('#tablePedido').DataTable({
                "lengthMenu": [
                    [20, 40, 80, -1],
                    [20, 40, 80, "Todos"],
                ],
                "language": {
                    "search": "Pesquisar:",
                    "paginate": {
                        "first": "Primeiro",
                        "last": "Último",
                        "next": "Próximo",
                        "previous": "Anterior"
                    },
                    "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                    "lengthMenu": "Mostrar _MENU_ itens",
                    "zeroRecords": "Nenhuma item encontrado"
                },
                "order": []
            });
        });
    </script>
<?php
} else {
    header("location: login");
    exit();
}
?>