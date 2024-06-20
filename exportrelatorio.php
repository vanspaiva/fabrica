<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");

    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

?>
    <style>
        <?php
        echo require_once 'css/styleOP.css';
        ?>
    </style>

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
            <div class="container-fluid py-4">
                <div class="row d-flex justify-content-center d-print-none">

                    <div class="col-sm-10">
                        <div class="">
                            <div class="row">
                                <div class="col-lg col-md col-sm p-3">
                                    <div class="container-fluid">
                                        <div class="row mb-2">
                                            <div class="col d-flex justify-content-center">
                                                <form class="w-100" action="exportrelatorio" method="POST">
                                                    <div class="col d-flex justify-content-end">
                                                        <input type="search" name="searchInput" class="form-control rounded p-2" placeholder="Pesquise aqui um pedido..." aria-label="Pesquise aqui um pedido..." aria-describedby="search-addon" />
                                                        <div class="px-2 d-flex justify-content-center align-items-center">
                                                            <button class="btn btn-fab input-group-text border-0 p-2" id="search-addon" type="search" value="search" name="search">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>


                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">

                        <?php
                        if (isset($_POST["search"])) {

                            //get the post value
                            $valorPesquisado = $_POST["searchInput"];

                            $valorPesquisado = preg_replace("#[^0-9a-z]#i", "", $valorPesquisado);
                            $sql = "SELECT p.*,
                            f.nome AS nomeFluxo
                            FROM pedidos AS p
                            JOIN fluxo AS f ON p.fluxo = f.id
                            WHERE p.pedido LIKE '%$valorPesquisado%' 
                            ORDER BY p.id ASC
                            LIMIT 1;";
                            $query = mysqli_query($conn, $sql) or die("Aconteceu algo errado!");
                            $count =  mysqli_num_rows($query);

                            if ($count == 0) {
                        ?>
                                <div class="container-fluid py-4">
                                    <div class="row">
                                        <div class="col">
                                            <div class="alert alert-warning text-center" role="alert">
                                                Nenhum pedido encontrado!
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            } else {
                                while ($rowFaq = mysqli_fetch_array($query)) {
                                    $numped = $rowFaq["pedido"];
                                    $datainicial = dateFormatByHifen($rowFaq["dt"]);
                                    $dataentrega = dateFormatByHifen($rowFaq["dataEntrega"]);
                                    $modalidade = $rowFaq["nomeFluxo"];
                                    $loteop = $rowFaq["lote"];
                                    $taxaextra = $rowFaq["taxa_extra"];
                                    $nacionalinternacional = $rowFaq["nacional_internacional"];
                                    $dr = $rowFaq["dr"];
                                    $pac = $rowFaq["pac"];
                                    $obs = $rowFaq["obs"];

                                    if ($taxaextra == 0) {
                                        $taxaextra = "não";
                                    } else {
                                        $taxaextra = "sim";
                                    }

                                ?>
                                    <div class="container-fluid m-0 p-0 overflow-hidden">
                                        <div class="row w-100 m-0 p-0">
                                            <div class="col m-0 p-0">
                                                <div class="bannerImpressao d-print-none d-flex justify-content-center p-3">
                                                    <button class="btn btn-light m-2" onclick="window.print();return false;"> <i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="op-header row pt-3">
                                            <div class="logo">
                                                <!-- <h3>CPMH</h3> -->
                                                <img src="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_0906db058ec5ee8cc4bcd93d25503562.png" alt="CPMH Digital" style="width: 15vw;">
                                            </div>
                                            <div class="titulo">
                                                <h3>Procedimento do Sistema de Gestão da Qualidade</h3>

                                                <p>

                                                    RELATÓRIO DE PRODUÇÃO DO PEDIDO
                                                </p>
                                            </div>
                                            <div class="revisao">
                                                <p>
                                                    Revisão: 1.0
                                                    <br>
                                                    Página. 1 de 1
                                                </p>
                                            </div>
                                        </div>

                                        <div class="op-cabecalho">
                                            <div class="linha">
                                                <div class="item-codigo">
                                                    <div class="itemName">Nº PEDIDO</div>
                                                    <div class="itemDescricao"><?php echo $numped; ?></div>
                                                </div>
                                                <div class="item-produto">
                                                    <div class="itemName">DATA INICIAL</div>
                                                    <div class="itemDescricao"><?php echo $datainicial; ?></div>
                                                </div>
                                                <div class="item-anvisa">
                                                    <div class="itemName">DATA ENTREGA</div>
                                                    <div class="itemDescricao"><?php echo $dataentrega; ?></div>
                                                </div>
                                                <div class="item-qtd">
                                                    <div class="itemName">MODALIDADE</div>
                                                    <div class="itemDescricao"><?php echo $modalidade; ?></div>
                                                </div>
                                            </div>
                                            <div class="linha">
                                                <div class="item-lote">
                                                    <div class="itemName">LOTE</div>
                                                    <div class="itemDescricao"><?php echo $loteop; ?></div>
                                                </div>
                                                <div class="item-npedido">
                                                    <div class="itemName">TAXA EXTRA</div>
                                                    <div class="itemDescricao"><?php echo $taxaextra; ?></div>
                                                </div>
                                                <div class="item-npedido">
                                                    <div class="itemName">NACIONAL/INTERNACIONAL</div>
                                                    <div class="itemDescricao"><?php echo $nacionalinternacional; ?></div>
                                                </div>
                                            </div>
                                            <div class="linha-2">
                                                <div class="item-titulos-juntos">
                                                    <div class="itemName2">Doutor(a): </div>
                                                    <div class="itemName2">Paciente: </div>
                                                </div>
                                                <div class="item-descricoes-juntas">
                                                    <div class="itemDescricao2"><?php echo $dr; ?></div>
                                                    <div class="itemDescricao2"><?php echo $pac; ?></div>
                                                </div>
                                                <div class="item-titulos-juntos pl-2">
                                                    <div class="itemName2">OBS: </div>
                                                </div>
                                                <div class="item-descricoes-juntas">
                                                    <div class="itemDescricao2"><?php echo $obs; ?></div>
                                                </div>
                                            </div>

                                            <div class="op-atividades table-responsive">
                                                <div class="titulo-atividades">
                                                    <h3>REGISTRO DAS ETAPAS DE PRODUÇÃO</h3>
                                                </div>
                                                <table id="" class="table table-striped table-advance table-hover">

                                                    <thead>
                                                        <tr>
                                                            <th><b>ID</b></th>
                                                            <th><b>Data/Hora</b></th>
                                                            <th><b>Responsável</b></th>
                                                            <!-- <th>Pedido</th> -->
                                                            <th><b>Etapa</b></th>
                                                            <th><b>Status</b></th>
                                                            <th><b>Ass</b></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $sql = "SELECT 
                                                            l.id AS Id,
                                                            l.data AS DataLog,
                                                            l.hora AS HoraLog,
                                                            u.usersName AS Responsavel,
                                                            p.pedido AS numPedido,
                                                            e.nome AS Etapa,
                                                            s.nome AS Status
                                                            FROM log_atividades_producao AS l 
                                                            JOIN realizacaoproducao AS r ON l.idRealizacaoProducao = r.id
                                                            JOIN pedidos AS p ON r.idPedido = p.id
                                                            JOIN etapa AS e ON l.idEtapa = e.id
                                                            JOIN users AS u ON l.idUsuario = u.usersId
                                                            JOIN statusetapa AS s ON l.idStatus = s.id
                                                            WHERE p.pedido = $numped
                                                            ORDER BY id DESC;";
                                                        $ret = mysqli_query($conn, $sql);

                                                        $cnt = 1;

                                                        while ($row = mysqli_fetch_array($ret)) {

                                                            $Id = $row["Id"];
                                                            $DataLog = $row["DataLog"];
                                                            $HoraLog = $row["HoraLog"];
                                                            $Responsavel = getFirstAndLastName($row["Responsavel"]);
                                                            $numPedido = $row["numPedido"];
                                                            $Etapa = $row["Etapa"];
                                                            $Status = $row["Status"];

                                                            $data = dateFormatByHifen($DataLog);
                                                            $hora = hourFormat($HoraLog);
                                                            $horario = $data . " " . $hora;

                                                        ?>

                                                            <tr>
                                                                <th><?php echo $cnt; ?></th>
                                                                <th><?php echo $horario; ?></th>
                                                                <th><?php echo $Responsavel; ?></th>
                                                                <!-- <th><?php //echo $numPedido; 
                                                                            ?></th> -->
                                                                <th><?php echo $Etapa; ?></th>
                                                                <th><?php echo $Status; ?></th>
                                                                <th><?php echo "___________________"; ?></th>
                                                            </tr>
                                                        <?php
                                                            $cnt++;
                                                        } ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            }
                        }

                        ?>

                    </div>
                </div>
            </div>
        </div>

        <?php include_once 'php/footer_index.php' ?>
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
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
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    order: []
                });

            });
        </script>


    <?php

} else {
    header("location: index");
    exit();
}

    ?>