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
                                                <!-- <th>ID</th> -->
                                                <th>Num Ped</th>
                                                <th>Dt Aceite</th>
                                                <!-- <th>Dt Entrega (Estoque)</th>
                                                <th>Dt Entrega (Cliente)</th> -->
                                                <th>Produto</th>
                                                <!-- <th>Fluxo</th> -->
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
                                            p.fluxo AS Fluxo, 
                                            p.lote, 
                                            p.cdgprod, 
                                            p.qtds, 
                                            p.descricao, 
                                            fx.nome AS NomeFluxo
                                            FROM pedidos p
                                            JOIN fluxo fx ON p.fluxo = fx.id
                                            GROUP BY p.id;
                                            ";
                                            $ret = mysqli_query($conn, $sql);
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $ID = $row["idPedido"];
                                                $NumPed = $row["numPedido"];
                                                $Produto = $row["Produto"];
                                                $Fluxo = $row["NomeFluxo"];
                                            
                                             /*    $dataEntregaEstoque = subtrairDiasUteis($dataEntrega, 2);
                                                $dataEntregaCliente = dateFormatByHifen($dataEntrega); */
/* 
                                                $DiasFaltantes = diasFaltandoParaData($row['dataEntrega']);
                                                $DiasFaltantesNumber = diasFaltandoParaData($row['dataEntrega']); */
                                                // $dtEx = '2024-07-05';
                                                // $diasFaltantes = diasFaltandoParaData($dtEx);
                                                // $diasFaltantesNumber = diasFaltandoParaData($dtEx);

                                               /*  if ($DiasFaltantes <= 0) {
                                                    $DiasFaltantes = '<b class="text-danger"> Data de entrega excedida! </b>';
                                                } else {
                                                    $DiasFaltantes = $DiasFaltantes . ' dias';
                                                }

                                                $etapasAtrasadas = contarEtapasAtrasadas($conn, $ID);
                                                if ($etapasAtrasadas == 0) {
                                                    $Situação = "<span class='badge badge-success'>Cumprindo Prazo </span>";
                                                } elseif ($etapasAtrasadas == 1) {
                                                    $Situação = "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapa atrasada </span>";
                                                } else {
                                                    $Situação = "<span class='badge badge-warning'>" . $etapasAtrasadas . " etapas atrasadas </span>";
                                                } */

                                                $etapaAtual = getEtapaAtual($conn, $ID);
                                                $nomeEtapaAtual = getNomeEtapa($conn, $etapaAtual);
                                                $respEtapaAtual = getRespEtapaAtual($conn, $ID, $etapaAtual);
                                               /*  if ($respEtapaAtual == "N/A") {
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
                                                } */

                                            ?>
                                                <tr style="background-color: <?php echo $bgAtraso; ?>;">
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="visualizarpedido?id=<?php echo $ID; ?>">
                                                                <button class="btn btn-success m-1"><i class="fas fa-expand"></i></button></a>
                                                        </div>
                                                    </td>
                                                    <!-- <td><?php // echo $ID; ?></td> -->
                                                   <!--  <td><?php echo $Situação; ?></td> -->
                                                    <td><b><?php echo $NumPed; ?></b></td>
                                                   <!--  <td><?php echo $dtAceite; ?></td> -->
                                                    <!-- <td><?php echo $dataEntregaEstoque; ?></td>
                                                    <td><?php echo $dataEntregaCliente; ?></td> -->
                                                    <td><?php echo $Produto; ?></td>
                                                    <!-- <td><?php //echo $Fluxo; 
                                                                ?></td> -->
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