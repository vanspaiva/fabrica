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
        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Ordem de Serviço foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço foi criada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
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
                                <h5 class="text-muted"><b>PCP - Planejamento e Controle da Produção</b></h5>
                                <small class="text-muted">Chegada de pedidos e encaminhamento para produção</small>
                            </div>
                        </div>
                        <hr>
                        <br>
                        <div class="">
                            <div class="card-body">
                                <div class="content-panel" style="overflow-x: scroll;">
                                    <table id="tablePedido" class="table table-striped table-advance table-hover">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Dt Chegada</th>
                                                <th>Produto</th>
                                                <th>Dr(a)</th>
                                                <th>Pac</th>
                                                <th>Num Ped</th>
                                                <th>Lote</th>
                                                <th>Dias P/ Prod</th>
                                                <!--<th>Dt Entrega</th>
                                                <th>Situação</th> -->
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            // Ajuste a consulta para incluir o nome do fluxo
                                            $sql = "
                                            SELECT p.*, f.nome AS nome_fluxo,
                                                   COALESCE(SUM(e.duracao), 0) AS total_duracao
                                            FROM pedidos p
                                            LEFT JOIN realizacaoproducao rp ON p.id = rp.idPedido
                                            LEFT JOIN fluxo f ON p.fluxo = f.id
                                            LEFT JOIN etapa_fluxo e ON p.fluxo = e.idfluxo
                                            WHERE rp.idPedido IS NULL
                                            GROUP BY p.id
                                            ORDER BY p.dt ASC;
                                        ";
                                            $ret = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $dt = dateFormatByHifen($row["dt"]);
                                                $produto = reduzirString($row["produto"], 15);
                                                $dr = reduzirString($row["dr"], 15);
                                                $pac = $row["pac"];
                                                $pedido = $row["pedido"];
                                                $nomeFluxo = $row['nome_fluxo']; // Nome do fluxo obtido da junção
                                                /*  $dataEntregaOriginal = dateFormatByHifen($row["dataEntrega"]); */
                                                $lote = $row["lote"];
                                                $totalDuracaoHoras = $row["total_duracao"]; // Total duração em horas
                                                $fluxo = $row['fluxo'];
                                                $numPed = $row['pedido'];
                                                // Calcular os dias e horas no fluxo
                                                if ($fluxo) {
                                                    $duracaoQuery = "
                                                    SELECT SUM(duracao) AS duracaoTotal
                                                    FROM etapa_fluxo
                                                    WHERE idfluxo = '$fluxo'
                                                ";
                                                    $duracaoResult = mysqli_query($conn, $duracaoQuery);
                                                    $duracaoData = mysqli_fetch_assoc($duracaoResult);
                                    
                                                    if ($duracaoData) {
                                                        $duracaoHoras = $duracaoData['duracaoTotal'];
                                    
                                                        $horasPorDia = 9;
                                                        $diasInteiros = floor($duracaoHoras / $horasPorDia);
                                                        $horasRestantes = $duracaoHoras % $horasPorDia;
                                    
                                                        $timestampPedido = strtotime($dt);
                                                        $diasUteisAdicionados = 0;
                                    
                                                        // Adicionar dias úteis
                                                        while ($diasUteisAdicionados < $diasInteiros) {
                                                            $timestampPedido += 24 * 3600;
                                                            $diaDaSemana = date('N', $timestampPedido);
                                                            if ($diaDaSemana < 6) { // Segunda a sexta
                                                                $diasUteisAdicionados++;
                                                            }
                                                        }
                                    
                                                        // Adicionar as horas restantes
                                                        $horaAtual = date('G', $timestampPedido); // Hora atual no dia
                                                        $horaFinal = $horaAtual + $horasRestantes;
                                    
                                                        if ($horaFinal > 18) { // Se ultrapassar 18h, mover para o próximo dia útil
                                                            $horaFinal -= 18; // Subtrai 18h para ajustar as horas restantes
                                                            do {
                                                                $timestampPedido += 24 * 3600;
                                                            } while (date('N', $timestampPedido) >= 6); // Pula fins de semana
                                                            $timestampPedido += $horaFinal * 3600; // Adiciona horas restantes do próximo dia
                                                        } else {
                                                            $timestampPedido += $horasRestantes * 3600; // Adiciona horas restantes ao mesmo dia
                                                        }
                                    
                                                        $dataProducao = date('Y-m-d', $timestampPedido);
                                                        $dataProducaoFormatada = date('d/m/Y', strtotime($dataProducao));
                                    
                                                       /*  echo "Data do Pedido: " . date('d/m/Y', strtotime($dt)) . "<br>";
                                                        echo "Duração Total para Produzir: " . $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas<br>";
                                                        echo "Data Prevista para Produção Completa: " . $dataProducaoFormatada; */
                                                    } else {
                                                        echo "Nenhuma duração encontrada para o fluxo especificado.";
                                                    }
                                                }

                                             /*    
                                                $statusEntrega = $diasFaltantes <= 0 ? '<b class="text-danger"> Data de entrega excedida! </b>' : $diasFaltantes . ' dias faltantes';
                                                $diasNoFluxo = $diasFuturos['dias'] . " dias e " . $diasFuturos['horas'] . " horas";
                                                $dataAtual = date('d-m-Y');
                                                $dataProducaoFormatada= adicionarHorasUteis($dataAtual, $totalDuracaoHoras);
                                                // Converter a duração total em dias e horas
                                                $dias = floor($totalDuracaoHoras / 24);
                                                $horas = $totalDuracaoHoras % 24;
                                                // Exibir o status
                                                if ($dias < 1 && $horas < 20) {
                                                    $statusPrevio = "<span class='badge badge-warning text-black'><b class='text-white'> FORA DO PRAZO </b></span>";
                                                } else {
                                                    $statusPrevio = "<span class='badge badge-secondary'><b> NORMAL </b></span>";
                                                } */
                                                // $diasOnPCP = calcularDiasAteHoje($conn, $dt);
                                                // $diasFaltantes = diasFaltandoParaData($row['dataEntrega']);
                                                // $diasFaltantesNumber = diasFaltandoParaData($row['dataEntrega']);
                                                // // $dtEx = '2024-07-09';
                                                // // $diasFaltantes = diasFaltandoParaData($dtEx);
                                                // // $diasFaltantesNumber = diasFaltandoParaData($dtEx);
                                                // if ($diasFaltantes <= 0) {
                                                //     $diasFaltantes = '<b class="text-danger"> Data de entrega excedida! </b>';
                                                // } else {
                                                //     $diasFaltantes = $diasFaltantes . ' dias';
                                                // }
                                                 /* $diasFuturosNumber = diasDentroFluxo($conn, $fluxo);
                                                 $diasFuturos = diasDentroFluxo($conn, $fluxo) . " dias";
                                                 if (($diasFuturosNumber >= $diasFaltantesNumber)) {
                                                     $statusPrevio = "<span class='badge badge-danger'><b class='text-white'> ATRASADO </b></span>";
                                                 } else {
                                                     if ($diasFaltantes < 21) {
                                                        $statusPrevio = "<span class='badge badge-warning'><b class='text-white'> POSSÍVEL ATRASO </b></span>";
                                                   } else {
                                                         $statusPrevio = "<span class='badge badge-success'><b class='text-white'> DENTRO DO PRAZO </b></span>";
                                                     }
                                                 } */
                                            ?>
                                                <tr>
                                                    <th><?php echo $id; ?></th>
                                                    <th><?php echo $dt; ?></th>
                                                    <!-- <th><?php //echo $diasOnPCP; 
                                                                ?></th> -->
                                                    <td><?php echo $nomeFluxo; ?></td>
                                                    <th><?php echo $dr; ?></th>
                                                    <th><?php echo $pac; ?></th>
                                                    <th><?php echo $pedido; ?></th>
                                                    <th><?php echo $lote; ?></th>
                                                    <th class="text-center"><?php echo$diasInteiros . " dias e " . round($horasRestantes, 2) . " horas<br>"?></th>
                                                    <!--  <th><?php echo $dataEntregaFormatada; ?></th>
                                                    <th>
                                                        <div class="d-flex"><?php echo $statusPrevio; ?></div>
                                                    </th> -->
                                                    <th>
                                                        <div class="d-flex">
                                                            <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                <a href="evolucaopcp?id=<?php echo $id; ?>">
                                                                    <button class="btn btn-success m-1"><i class="fas fa-calendar-plus"></i></button>
                                                                </a>
                                                                <a href="evolucaopcpPDF?id=<?php echo $id; ?>">
                                                                    <button class="btn btn-warning m-1"><i class="bi bi-file-earmark-pdf-fill"></i></button>
                                                                </a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </th>
                                                </tr>
                                            <?php
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
F