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
                    <div class="col-sm-10">
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
                                <div class="content-panel">
                                    <table id="tablePedido" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <!-- <th>ID</th>
                                                <th>Dt Chegada</th>
                                                <th>Cód Produto</th>
                                                <th>Produto</th>
                                                <th>Fluxo</th>
                                                <th>Dr(a)</th>
                                                <th>Pac</th>
                                                <th>Dt Entrega</th>
                                                <th></th> -->

                                                <th>ID</th>
                                                <th>Dt Chegada</th>
                                                <!-- <th>Dias no PCP</th> -->
                                                <th>Produto</th>
                                                <th>Dr(a)</th>
                                                <th>Pac</th>
                                                <th>Num Ped</th>
                                                <th>Dt Entrega</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            $ret = mysqli_query($conn, "SELECT * FROM pedidos ORDER BY dt ASC;");
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $dt = dateFormatByHifen($row["dt"]);
                                                $produto = $row["produto"];
                                                $dr = $row["dr"];
                                                $pac = $row["pac"];
                                                $pedido = $row["pedido"];
                                                $dataEntrega = dateFormatByHifen($row["dataEntrega"]);

                                                // $diasOnPCP = calcularDiasAteHoje($conn, $dt);

                                            ?>
                                                <tr>
                                                    <th><?php echo $id; ?></th>
                                                    <th><?php echo $dt; ?></th>
                                                    <!-- <th><?php //echo $diasOnPCP; 
                                                                ?></th> -->
                                                    <th><?php echo $produto; ?></th>
                                                    <th><?php echo $dr; ?></th>
                                                    <th><?php echo $pac; ?></th>
                                                    <th><?php echo $pedido; ?></th>
                                                    <th><?php echo $dataEntrega; ?></th>
                                                    <th>
                                                        <div class="d-flex">
                                                            <a href="evolucaopcp?id=<?php echo $id; ?>">
                                                                <button class="btn btn-success m-1"><i class="fas fa-calendar-plus"></i></button></a>
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