<?php
session_start();
if (isset($_SESSION["useruid"])) {
    include("php/head_updateprop.php");
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';
    $user = $_SESSION["useruid"];
?>

<body class="bg-light-gray2">
    <?php
    include_once 'php/navbar.php';
    include_once 'php/lateral-nav.php';
    $pedidoId = $_GET['id'];
    $ret = mysqli_query($conn, "SELECT * FROM pedidos WHERE id='" . $pedidoId . "';");
    if ($row = mysqli_fetch_array($ret)) {
        $numPed = $row['pedido'];
        $fluxo = $row['fluxo'];
        $lote = $row["lote"];
        $cdgprod = $row["cdgprod"];
        $qtds = $row["qtds"];
        $descricao = $row["descricao"];
        $dataPedido = $row['dt'];

        // 2. Obter a Duração Total das Etapas para o Fluxo
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

                // 3. Converter a Duração Total para Dias Úteis e Horas
                $horasPorDia = 9; // ajuste conforme as horas úteis por dia
                $diasTotal = $duracaoHoras / $horasPorDia;
                $diasInteiros = floor($diasTotal);
                $horasRestantes = ($diasTotal - $diasInteiros) * $horasPorDia;

                // 4. Calcular a Data de Produção
                $timestampPedido = strtotime($dataPedido);
                $diasUteisAdicionados = 0;
                $diasCalculados = 0;

                while ($diasCalculados < $diasTotal) {
                    $timestampPedido += 24 * 3600; // adicionar um dia
                    $diaDaSemana = date('N', $timestampPedido); // 1 (segunda-feira) até 7 (domingo)
                    
                    if ($diaDaSemana < 6) { // dias úteis são de segunda a sexta
                        $diasCalculados++;
                        $diasUteisAdicionados++;
                    }
                }
                    // Adicionar as horas restantes ao final do último dia útil
                    $timestampPedido += $horasRestantes * 3600;

                    // Subtrair um dia para ajustar a data prevista
                    $timestampPedido -= 24 * 3600; // subtrair 1 dia (24 horas)

                    $dataProducao = date('Y-m-d', $timestampPedido);
                    $dataProducaoFormatada = date('d/m/Y', strtotime($dataProducao));

                // Exibindo as datas e durações
                echo "Data do Pedido: " . date('d/m/Y', strtotime($dataPedido)) . "<br>";
                echo "Duração Total para Produzir: " . $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas<br>";
                echo "Data Prevista para Produção Completa: " . $dataProducaoFormatada;
            } else {
                echo "Nenhuma duração encontrada para o fluxo especificado.";
            }
        } else {
            echo "Fluxo não especificado.";
        }

        $listaCdgs = explode("*", $cdgprod);
        $listaQtds = explode("*", $qtds);
        $listaDescricao = explode("*", $descricao);
    ?>
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">
                    <div class="col-sm" id="titulo-pag">
                        <div class="d-flex">
                            <div class="col-sm-1">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-dark p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                            <div class="col-sm-8 pt-2 row-padding-2">
                                <div class="row px-3" style="color: #fff">
                                    <h2>Informações do Pedido - <?php echo $numPed; ?> </h2>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="div">
                            <div class="row">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-muted">Dados do Pedido</h6>
                                        </div>
                                        <div class="card-body">
                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <div class="content-panel">
                                                                <div class="row py-2">
                                                                    <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                        <label for=""><b>Nº Ped</b></label>
                                                                        <small><?php echo $row['pedido']; ?></small>
                                                                    </div>
                                                                    <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                        <label for=""><b>Dr(a)</b></label>
                                                                        <small><?php echo $row['dr']; ?></small>
                                                                    </div>
                                                                    <div class="col d-flex" style="flex-direction: column;">
                                                                        <label for=""><b>Pac</b></label>
                                                                        <small><?php echo $row['pac']; ?></small>
                                                                    </div>
                                                                </div>
                                                                <div class="row py-2">
                                                                    <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                        <label for=""><b>Lote</b></label>
                                                                        <small><?php echo $row['lote']; ?></small>
                                                                    </div>
                                                                    <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                        <label for=""><b>Produto</b></label>
                                                                        <?php
                                                                        $retStatus = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");
                                                                        if ($retStatus) {
                                                                            while ($rowStatus = mysqli_fetch_array($retStatus)) {
                                                                                $idFluxo = $rowStatus['id'];
                                                                                $nomeFluxo = $rowStatus['nome'];
                                                                        ?>
                                                                                <small>
                                                                                    <value="<?php echo $idFluxo; ?>">
                                                                                        <?php if ($fluxo == $idFluxo) {
                                                                                            echo htmlspecialchars($nomeFluxo);
                                                                                        } ?>
                                                                                    </value>
                                                                                </small>
                                                                        <?php
                                                                            }
                                                                        } else {
                                                                            echo "Erro na consulta: " . mysqli_error($conn);
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col d-flex" style="flex-direction: column;">
                                                                        <label for=""><b>Data Pedido</b></label>
                                                                        <small><?php echo date('d/m/Y', strtotime($dataPedido)); ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="text-muted">Datas Importantes</h6>
                                        </div>
                                        <div class="card-body">
                                            <section id="main-content">
                                                <section class="wrapper">
                                                    <div class="row">
                                                        <div class="col-md">
                                                            <div class="content-panel">
                                                                <div class="row py-2">
                                                                    <div class="col d-flex" style="flex-direction: column; border-right: 1px silver solid;">
                                                                        <label for=""><b>Data Prevista p/entrega</b></label>
                                                                        <small><?php echo $dataProducaoFormatada; ?></small>
                                                                    </div>
                                                                    <div class="col d-flex" style="flex-direction: column;">
                                                                        <label for=""><b>Dias para Produzir</b></label>
                                                                        <small><?php echo $diasInteiros . " dias e " . round($horasRestantes, 2) . " horas"; ?></small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
                                            </section>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </br>
                        <div class="row">
                            <div class="col-md-12">
                                <section id="main-content">
                                    <section class="wrapper">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="content-panel">
                                                    <form class="form-horizontal style-form" id="formprop" name="formprop" action="includes/pcp.inc.php" method="POST">
                                                        <div class="form-row" hidden>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="pedidoId">ID</label>
                                                                <input type="number" class="form-control" id="pedidoId" name="pedidoId" value="<?php echo $row['id']; ?>" required readonly>
                                                                <small class="text-muted">ID não é editável</small>
                                                            </div>
                                                            <div class="form-group col-md">
                                                                <label class="form-label text-black" for="user">User Responsável</label>
                                                                <input type="text" class="form-control" id="user" name="user" value="<?php echo $user; ?>" required readonly>
                                                            </div>
                                                        </div>
                                                        <div class="form-row">
                                                            <div class="col form-group m-2">
                                                                <label class="form-label text-black" for="fluxo">Modalidade</label>
                                                                <select class='form-control' name='fluxo' id='fluxo' required>
                                                                    <option value="">Escolha uma Modalidade</option>
                                                                    <?php
                                                                    $retStatus = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");
                                                                    while ($rowStatus = mysqli_fetch_array($retStatus)) { ?>
                                                                        <option value="<?php echo $rowStatus['id']; ?>" <?php if ($fluxo == $rowStatus['id']) echo ' selected="selected"'; ?>>
                                                                            <?php echo $rowStatus['nome']; ?>
                                                                        </option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col form-group m-2">
                                                                <label class="form-label text-black" for="lote">Lote</label>
                                                                <input type="text" class="form-control" id="lote" name="lote" value="<?php echo $row['lote']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div class="form-row">
                                                            <div class="col form-group m-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nacinter" id="nacinter1" value="nacional" required>
                                                                    <label class="form-check-label" for="nacinter1">
                                                                        Nacional
                                                                    </label>
                                                                </div>
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="radio" name="nacinter" id="nacinter2" value="internacional" required>
                                                                    <label class="form-check-label" for="nacinter2">
                                                                        Internacional
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="col form-group m-2">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" type="checkbox" value="1" id="taxa_extra" name="taxa_extra">
                                                                    <label class="form-check-label" for="taxa_extra">
                                                                        Taxa extra
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex justify-content-end pt-4">
                                                            <button type="submit" name="update" id="update" class="btn btn-fab btn-sm">Gerar</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        include_once 'php/footer_updateprop.php';
    } else {
        echo "Pedido não encontrado.";
    }
} else {
    header("location: ../index");
    exit();
}
?>
