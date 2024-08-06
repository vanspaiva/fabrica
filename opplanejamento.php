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
                                            <th>Produto</th> <!-- Alterado para Fluxo -->
                                            <th class="text-center">Dias P/ Produzir</th>
                                            <th>Fases</th>
                                            <th>Etapa Atual</th>
                                            <th>Resp</th>
                                            <th>Próx Etapa</th>
                                            <th>Dias Faltantes</th>
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
                                                COUNT(rp.idEtapa) AS qtdEtapas,
                                                fx.nome AS NomeFluxo
                                                FROM pedidos p
                                                JOIN realizacaoproducao rp ON p.id = rp.idPedido
                                                JOIN fluxo fx ON p.fluxo = fx.id
                                                GROUP BY p.id;";
                                        $ret = mysqli_query($conn, $sql);
                                        if ($ret) {
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $ID = $row["idPedido"];
                                                $NumPed = $row["numPedido"];
                                                $Produto = $row["NomeFluxo"]; // Usando o nome do fluxo no lugar de Produto
                                                $Fluxo = $row["NomeFluxo"];
                                                $dt = $row["dt"]; // Certifique-se de que esta coluna existe na sua tabela
                                                $qtdFasesRealizadas = contarEtapasConcluidas($conn, $ID);
                                                $Fases =  $qtdFasesRealizadas . "/" . $row["qtdEtapas"];
                                                
                                                // Obtendo a duração total das etapas do fluxo
                                                $sqlDuracao = "SELECT SUM(e.duracao) AS total_duracao
                                                               FROM etapa_fluxo e
                                                               WHERE e.idfluxo = " . $row['idFluxo'];
                                                $retDuracao = mysqli_query($conn, $sqlDuracao);
                                                $rowDuracao = mysqli_fetch_assoc($retDuracao);
                                                $totalDuracaoHoras = isset($rowDuracao['total_duracao']) ? $rowDuracao['total_duracao'] : 0;
                                                
                                                // Converte duração em dias
                                                $totalDuracaoDias = floor($totalDuracaoHoras / 24);
                                                $DiasPProduzir = $totalDuracaoDias . ' dias';
                                                $dataEntrega = $row["dataEntrega"];
                                                $dtAceite = subtrairDiasUteis($dataEntrega, 20);
                                                $dataEntregaEstoque = subtrairDiasUteis($dataEntrega, 2);
                                                $dataEntregaCliente = dateFormatByHifen($dataEntrega);
                                                // Calcular os dias faltantes
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
                                                $etapaAtual = getEtapaAtual($conn, $ID);
                                                $nomeEtapaAtual = getNomeEtapa($conn, $etapaAtual);
                                                $respEtapaAtual = getRespEtapaAtual($conn, $ID, $etapaAtual);
                                                if ($respEtapaAtual == "N/A") {
                                                    $nomeproximaEtapa = $nomeEtapaAtual;
                                                } else {
                                                    $proximaEtapa = getProximaEtapa($conn, $ID, $etapaAtual);
                                                    $nomeproximaEtapa = getNomeEtapa($conn, $proximaEtapa);
                                                }
                                                if (($DiasFaltantesNumber <= 5) && ($DiasFaltantesNumber > 0)) {
                                                    $bgAtraso = '#ebd38b';
                                                } elseif ($DiasFaltantesNumber <= 0) {
                                                    $bgAtraso = "#edb0b6";
                                                } else {
                                                    $bgAtraso = "";
                                                }
                                        ?>
                                                <tr style="background-color: <?php echo $bgAtraso; ?>;">
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="visualizarpedido?id=<?php echo $ID; ?>">
                                                                <button class="btn btn-success m-1"><i class="fas fa-expand"></i></button></a>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $Situação; ?></td>
                                                    <td><b><?php echo $NumPed; ?></b></td>
                                                    <td><?php echo $dt; ?></td>
                                                    <td><?php echo $Produto; ?></td> <!-- Alterado para exibir o nome do fluxo -->
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <?php echo $DiasPProduzir; ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $Fases; ?></td>
                                                    <td><?php echo $nomeEtapaAtual; ?></td>
                                                    <td><?php echo $respEtapaAtual; ?></td>
                                                    <td><?php echo $nomeproximaEtapa; ?></td>
                                                    <td><?php echo $DiasFaltantes; ?></td>
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
