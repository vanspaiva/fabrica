    <?php
    session_start();

    if (isset($_SESSION["useruid"])) {
        include("php/head_tables.php");
        $user = $_SESSION["useruid"];
        $userId = $_SESSION["userid"];
        require_once 'db/dbh.php';
        require_once 'includes/functions.inc.php';

        if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Produção')) {
            $setores = [1, 2, 3, 4];/* getSetoresByUser($conn, $userId); */
            $link = 'visualizarpedido';
        } else if (($_SESSION["userperm"] == 'Colaborador(a)') && ($_SESSION["usernomedep"] == 'Qualidade')) {
            $setores = [5,8,11,15];
            $link = 'inspecaopedido';
        } else {
            $setores = getAllSetorIDs($conn);
            $link = 'visualizarpedido';
        }

        // Obtendo todos os setores
  /*       print_r($setores); */

        $hoje = hoje();

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
                                    <h5 class="text-muted"><b>OP - Etapa da Produção</b></h5>
                                    <small class="text-muted">Realização das Atividades</small>
                                </div>
                            </div>
                            <hr>
                            <div class="content-panel">
                                <?php foreach ($setores as $setor) : ?>
                                    <?php
                                    $nome = getSetorNameByID($conn, $setor);
                                    $etapas = getEtapasBySetor($conn, $setor);

                                    $arrayNomesEtapas = [];

                                    if (empty($etapas)) {
                                        $todasEtapas = "0";
                                    } else {
                                        foreach ($etapas as $key => $value) {
                                            $nomeEtapa = getNomeEtapa($conn, $value);
                                            array_push($arrayNomesEtapas, $nomeEtapa);
                                        }

                                        $todasEtapas = implode(", ", $arrayNomesEtapas);
                                    }
                                    ?>
                                    <div class="row py-2">
                                        <div class="col">
                                            <div class="card shadow-sm">
                                                <div class="card-header bg-info">
                                                    <h5 class="text-white">
                                                        <b><?php echo $nome; ?></b>
                                                        <span data-toggle="modal" data-target="#info" onclick="sendInfo('<?php echo $todasEtapas; ?>')">
                                                            <i class="far fa-question-circle"></i>
                                                        </span>
                                                    </h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col" style="border-right: 1px solid #dee2e6;">
                                                            <h6 class="py-2 text-muted"><b>Hoje</b> <?php echo dateFormatByHifen($hoje); ?></h6>
                                                            <table class="table table-hover table-sm table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><b>Ped</b></th>
                                                                        <th><b>Modalidade</b></th>
                                                                        <th><b>Prazo</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($etapas as $key => $value) {

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
                                                                        WHERE r.idEtapa = $value
                                                                        AND r.dataRealizacao <= CURDATE()
                                                                        AND NOT r.idStatus in (4,10,5,6)
                                                                         ORDER BY r.dataRealizacao";

                                                                        // echo $sql;
                                                                        // exit();

                                                                        $ret = mysqli_query($conn, $sql);
                                                                        if ($ret) {
                                                                            while ($row = mysqli_fetch_assoc($ret)) {
                                                                                $numPed = $row["numPed"];
                                                                                $pedId = $row["idPed"];
                                                                                $nomeFluxo = $row["nomeFluxo"];
                                                                                $nomeEtapa = $row["nomeEtapa"];
                                                                                $nomeStatus = $row["nomeStatus"];
                                                                                $corStatus = $row["corStatus"];
                                                                                $data = dateFormatByHifen($row["dt"]);

                                                                                // Converter strings de data em objetos DateTime
                                                                                $dataDateTime = new DateTime($row["dt"]);
                                                                                $hojeDateTime = new DateTime($hoje);

                                                                                // Comparar as datas
                                                                                if ($dataDateTime < $hojeDateTime) {
                                                                                    $atrasoColor = "text-danger";
                                                                                } else {
                                                                                    $atrasoColor = "";
                                                                                } 
                                                                    ?>

                                                                                <tr class="<?php echo $atrasoColor; ?>">
                                                                                    <td style="font-size:  0.8rem;"><a href="<?php echo $link; ?>?id=<?php echo $pedId; ?>"><span class="btn btn-info"> <?php echo $numPed; ?> </span></a></td>
                                                                                    <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                                                 <!--    <td style="font-size:  0.8rem;"><?php echo $data; ?></td> -->
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        } ?>
                                                                    <?php
                                                                    }
                                                                    ?>

                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <div class="col" style="border-right: 1px solid #dee2e6;">
                                                            <h6 class="py-2 text-muted"><b>Próximos</b> </h6>
                                                            <table class="table table-hover table-sm table-striped">
                                                                <thead>
                                                                    <tr>
                                                                        <th><b>Ped</b></th>
                                                                        <th><b>Modalidade</b></th>
                                                                        <th><b>Prazo</b></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    foreach ($etapas as $key => $value) {

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
                                                                        WHERE r.idEtapa = $value
                                                                        AND r.dataRealizacao > CURDATE()
                                                                        AND NOT r.idStatus in (4,10,5,6)
                                                                       ORDER BY r.dataRealizacao";

                                                                        // echo $sql;
                                                                        // exit();

                                                                        $ret = mysqli_query($conn, $sql);
                                                                        if ($ret) {
                                                                            while ($row = mysqli_fetch_assoc($ret)) {
                                                                                $numPed = $row["numPed"];
                                                                                $pedId = $row["idPed"];
                                                                                $nomeFluxo = $row["nomeFluxo"];
                                                                                $nomeEtapa = $row["nomeEtapa"];
                                                                                $nomeStatus = $row["nomeStatus"];
                                                                                $corStatus = $row["corStatus"];
                                                                                $data = dateFormatByHifen($row["dt"]); 

                                                                               // Converter strings de data em objetos DateTime
                                                                                $dataDateTime = new DateTime($row["dt"]);
                                                                                $hojeDateTime = new DateTime($hoje);

                                                                                // Comparar as datas
                                                                                if ($dataDateTime < $hojeDateTime) {
                                                                                    $atrasoColor = "text-danger";
                                                                                } else {
                                                                                    $atrasoColor = "";
                                                                                } 
                                                                    ?>

                                                                                <tr class="<?php echo $atrasoColor; ?>">
                                                                                    <td style="font-size:  0.8rem;"><a href="<?php echo $link; ?>?id=<?php echo $pedId; ?>"><span class="btn btn-info"> <?php echo $numPed; ?> </span></a></td>
                                                                                    <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                                                    <td style="font-size:  0.8rem;"><?php echo $data; ?></td> 
                                                                                </tr>
                                                                        <?php
                                                                            }
                                                                        } ?>
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
                                <?php endforeach; ?>

                            </div>

                        </div>


                    </div>

                </div>
            </div>

            <!-- Modal Infos -->
            <div class="modal fade" id="info" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-sm" role="document">
                    <div class="modal-content">
                        <div class="modal-body py-4">
                            <h6>Etapas nesse setor:</h6>
                            <span id="placeholderEtapas" class="d-flex justify-content-center"></span>
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

            function sendInfo(info) {
                var placeholder = document.getElementById('placeholderEtapas');

                console.log(info);
                if (info == 0) {
                    // Definir o conteúdo HTML do placeholder
                    placeholder.innerHTML = `<span class="alert alert-secondary">Nenhuma etapa cadastrada nesse setor </span>`;
                } else {


                    // Chamar a função criarListaNumerada e obter o HTML
                    var listaHTML = criarListaNumerada(info);

                    // Definir o conteúdo HTML do placeholder
                    placeholder.innerHTML = listaHTML;
                }

            }


            function criarListaNumerada(str) {
                // Dividir a string em um array de itens
                var itens = str.split(', ');

                // Criar um elemento <ol> para a lista numerada
                var ol = document.createElement('ol');

                // Iterar sobre os itens e criar elementos <li> para cada um
                itens.forEach(function(item) {
                    var li = document.createElement('li');
                    li.textContent = item;
                    ol.appendChild(li);
                });

                return ol.outerHTML;
            }
        </script>

    <?php
    } else {
        header("location: login");
        exit();
    }
    ?>