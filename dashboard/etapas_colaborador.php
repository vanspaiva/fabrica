<?php
$userId = $_SESSION["userid"];


// Obtendo todas as etapas associadas ao usuário
// $sql = "SELECT e.id, e.nome FROM etapa e JOIN colaborador_etapas ce ON e.id = ce.idEtapa WHERE ce.idUser = ?";
$sql = "SELECT s.id, s.nome 
        FROM setor s 
        JOIN setor_resp sr ON s.id = sr.idSetor 
        WHERE sr.idResp = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$setores = mysqli_fetch_all($result, MYSQLI_ASSOC);

$setoresIdArray = array_column($setores, 'id'); // Extrai IDs dos setores

// Obtemos as etapas associadas aos setores
$etapas = [];

foreach ($setoresIdArray as $setorId) {
    $etapaIds = getEtapasBySetor($conn, $setorId); // Função para obter etapas por setor
    $etapas = array_merge($etapas, $etapaIds); // Mescla as etapas
}

$etapasAssociadasToSQL = implode(",", $etapas); // Formata para uso em SQL

?>
<style>
    .custom-badge {
        font-size: 1rem; 
        padding: 0.5rem 1rem; 
    }
</style>

<div class="row p-3">
    <div class="col border py-2">
        <?php foreach ($setores as $etapa) : ?>
            <span class="badge badge-primary custom-badge"><?php echo htmlspecialchars($etapa['nome'], ENT_QUOTES, 'UTF-8'); ?></span>
        <?php endforeach; ?>
    </div>
</div>


<div class="row py-4">
    <div class="col">
        <div class="content-panel">
            <div class="row">
                <!-- Coluna Tarefas -->
                <div class="col-12 col-sm">
                    <div class="row">
                        <div class="col">
                            <div class="">
                                <?php
                                $qtdAtrasados = countEtapasAtrasadasToColaborador($conn, $etapasAssociadasToSQL);
                                ?>
                                <h6 style="color: #d54e5b;"><b>Atrasados</b> (<?php echo $qtdAtrasados; ?>)</h6>
                            </div>
                            <div class="card-body" style="overflow-x: scroll;">
                                <?php $arrayEtapasAtrasadas = arrayEtapasAtrasadas($conn); ?>
                                <table id="tAtrasado" class="table table-striped table-hover">
                                    <thead class="text-white" style="background-color: #d54e5b;">
                                        <tr>
                                            <th><b>Num Pedido</b></th>
                                            <th><b>Modalidade</b></th>
                                            <th><b>Etapa</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>Dt</b></th>
                                            <th><b>Dias em Atraso</b></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($arrayEtapasAtrasadas as $key => $value) {

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
                                                                    WHERE r.id = $value
                                                                    AND r.idEtapa IN ($etapasAssociadasToSQL);";

                                            // echo $sql;
                                            // exit();

                                            $ret = mysqli_query($conn, $sql);
                                            if ($ret) {
                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                    $idRealizacaoProducao = $row["idRealizacaoProducao"];
                                                    $numPed = $row["numPed"];
                                                    $pedId = $row["idPed"];
                                                    $nomeFluxo = $row["nomeFluxo"];
                                                    $nomeEtapa = $row["nomeEtapa"];
                                                    $idEtapa = $row["idEtapa"];
                                                    $idStatus = $row["idStatus"];
                                                    $nomeStatus = $row["nomeStatus"];
                                                    $corStatus = $row["corStatus"];
                                                    $data = dateFormatByHifen($row["dt"]);
                                                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                                                    $dtRef = $row["dt"];
                                                    $dt = dateFormatByHifen($row["dt"]);
                                                    $status = "";

                                                    $hoje = hoje();
                                                    $dtRefDate = new DateTime($dtRef);
                                                    $hojeDate = new DateTime($hoje);
                                                    // Adiciona um dia à data de hoje
                                                    $hojeMaisUm = clone $hojeDate;
                                                    $hojeMaisUm->modify('+1 day');


                                                    if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-orange";
                                                        $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                    } elseif (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-danger";
                                                        $i = '';
                                                    } elseif ($dtRefDate == $hojeMaisUm) {
                                                        $color = "text-warning";
                                                        $i = '<span class="badge bg-warning text-dark mx-2">Amanhã!</span>';
                                                    } elseif (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) {
                                                        $color = "text-success";
                                                        $i = '';
                                                    } else {
                                                        $color = "";
                                                        $i = '';
                                                    }
                                        ?>
                                                    <tr>
                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                        <td class="text-center" style="font-size:  0.8rem;"><?php echo $diasEmAtraso; ?></td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">

                                                                <?php if (($idStatus == 1) || ($idStatus == 7) || ($idStatus == 3) || ($idStatus == 9)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=play&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-info btn-sm"><i class="fas fa-play fa-1x"></i> </a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 2) || ($idStatus == 8)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) { ?>
                                                                    <a href="#" class="btn text-success btn-sm"><i class="fas fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 6)) { ?>
                                                                    <a href="#" class="btn text-danger btn-sm"><i class="fas fa-times-circle fa-1x"></i></a>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col">
                            <div class="">
                                <?php
                                $qtdHoje = countEtapasHojeToColaborador($conn, $etapasAssociadasToSQL);
                                ?>
                                <h6 class="text-fab"> <b>Hoje </b> (<?php echo $qtdHoje; ?>)</h6>
                            </div>
                            <div class="card-body" style="overflow-x: scroll;">
                                <?php $arrayEtapasHoje = arrayEtapasHoje($conn); ?>
                                <table id="tHoje" class="table table-striped table-hover">
                                    <thead class="bg-fab text-white">
                                        <tr>
                                            <th><b>Num Pedido</b></th>
                                            <th><b>Modalidade</b></th>
                                            <th><b>Etapa</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>Dt</b></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($arrayEtapasHoje as $key => $value) {

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
                                                                    WHERE r.id = $value
                                                                    AND r.idEtapa IN ($etapasAssociadasToSQL);";

                                            // echo $sql;
                                            // exit();

                                            $ret = mysqli_query($conn, $sql);
                                            if ($ret) {
                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                    $idRealizacaoProducao = $row["idRealizacaoProducao"];
                                                    $numPed = $row["numPed"];
                                                    $pedId = $row["idPed"];
                                                    $nomeFluxo = $row["nomeFluxo"];
                                                    $nomeEtapa = $row["nomeEtapa"];
                                                    $idEtapa = $row["idEtapa"];
                                                    $idStatus = $row["idStatus"];
                                                    $nomeStatus = $row["nomeStatus"];
                                                    $corStatus = $row["corStatus"];
                                                    $data = dateFormatByHifen($row["dt"]);
                                                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                                                    $dtRef = $row["dt"];
                                                    $dt = dateFormatByHifen($row["dt"]);
                                                    $status = "";

                                                    $hoje = hoje();
                                                    $dtRefDate = new DateTime($dtRef);
                                                    $hojeDate = new DateTime($hoje);
                                                    // Adiciona um dia à data de hoje
                                                    $hojeMaisUm = clone $hojeDate;
                                                    $hojeMaisUm->modify('+1 day');


                                                    if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-orange";
                                                        $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                    } elseif (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-danger";
                                                        $i = '';
                                                    } elseif ($dtRefDate == $hojeMaisUm) {
                                                        $color = "text-warning";
                                                        $i = '<span class="badge bg-warning text-dark mx-2">Amanhã!</span>';
                                                    } elseif (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) {
                                                        $color = "text-success";
                                                        $i = '';
                                                    } else {
                                                        $color = "";
                                                        $i = '';
                                                    }
                                        ?>
                                                    <tr>
                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">

                                                                <?php if (($idStatus == 1) || ($idStatus == 7) || ($idStatus == 3) || ($idStatus == 9)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=play&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-info btn-sm"><i class="fas fa-play fa-1x"></i> </a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 2) || ($idStatus == 8)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) { ?>
                                                                    <a href="#" class="btn text-success btn-sm"><i class="fas fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 6)) { ?>
                                                                    <a href="#" class="btn text-danger btn-sm"><i class="fas fa-times-circle fa-1x"></i></a>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="col">
                            <div class="">
                                <?php
                                $qtdAmanha = countEtapasAmanhaToColaborador($conn, $etapasAssociadasToSQL);
                                ?>
                                <h6 class="text-info"><b> Próximos </b> (<?php echo $qtdAmanha; ?>)</h6>
                            </div>
                            <div class="card-body" style="overflow-x: scroll;">
                                <?php $arrayEtapasAmanha = arrayEtapasAmanha($conn); ?>
                                <table id="tProximo" class="table table-striped table-hover">
                                    <thead class="bg-info text-white">
                                        <tr>
                                            <th><b>Num Pedido</b></th>
                                            <th><b>Modalidade</b></th>
                                            <th><b>Etapa</b></th>
                                            <th><b>Status</b></th>
                                            <th><b>Dt</b></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        <?php
                                        foreach ($arrayEtapasAmanha as $key => $value) {

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
                                                                    WHERE r.id = $value
                                                                    AND r.idEtapa IN ($etapasAssociadasToSQL);";



                                            $ret = mysqli_query($conn, $sql);
                                            if ($ret) {
                                                while ($row = mysqli_fetch_assoc($ret)) {
                                                    $idRealizacaoProducao = $row["idRealizacaoProducao"];
                                                    $numPed = $row["numPed"];
                                                    $pedId = $row["idPed"];
                                                    $nomeFluxo = $row["nomeFluxo"];
                                                    $nomeEtapa = $row["nomeEtapa"];
                                                    $idEtapa = $row["idEtapa"];
                                                    $idStatus = $row["idStatus"];
                                                    $nomeStatus = $row["nomeStatus"];
                                                    $corStatus = $row["corStatus"];
                                                    $data = dateFormatByHifen($row["dt"]);
                                                    $diasEmAtraso = diasUteisAteHoje($row["dt"]);

                                                    $dtRef = $row["dt"];
                                                    $dt = dateFormatByHifen($row["dt"]);
                                                    $status = "";

                                                    $hoje = hoje();
                                                    $dtRefDate = new DateTime($dtRef);
                                                    $hojeDate = new DateTime($hoje);
                                                    // Adiciona um dia à data de hoje
                                                    $hojeMaisUm = clone $hojeDate;
                                                    $hojeMaisUm->modify('+1 day');


                                                    if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-orange";
                                                        $i = '<span class="badge bg-orange text-dark mx-2">Hoje!</span>';
                                                    } elseif (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
                                                        $color = "text-danger";
                                                        $i = '';
                                                    } elseif ($dtRefDate == $hojeMaisUm) {
                                                        $color = "text-warning";
                                                        $i = '<span class="badge bg-warning text-dark mx-2">Amanhã!</span>';
                                                    } elseif (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) {
                                                        $color = "text-success";
                                                        $i = '';
                                                    } else {
                                                        $color = "";
                                                        $i = '';
                                                    }
                                        ?>
                                                    <tr>
                                                        <td style="font-size:  0.8rem;"><a href="visualizarpedido?id=<?php echo $pedId; ?>"><span class="btn btn-fab"> <?php echo $numPed; ?> </span></a></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeFluxo; ?></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $nomeEtapa; ?></td>
                                                        <td class="text-center"> <span class="badge badge-light border" style="color: <?php echo $corStatus; ?>;"><?php echo $nomeStatus; ?></span></td>
                                                        <td style="font-size:  0.8rem;"><?php echo $data; ?></td>
                                                        <td class="text-center">
                                                            <div class="d-flex justify-content-center">

                                                                <?php if (($idStatus == 1) || ($idStatus == 7) || ($idStatus == 3) || ($idStatus == 9)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=play&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-info btn-sm"><i class="fas fa-play fa-1x"></i> </a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 2) || ($idStatus == 8)) { ?>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=pause&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-warning btn-sm"><i class="fas fa-pause fa-1x"></i></a>
                                                                    <a href="atvdc?idPed=<?php echo $pedId; ?>&idR=<?php echo $idRealizacaoProducao; ?>&a=check&etapa=<?php echo $idEtapa; ?>&statual=<?php echo $idStatus; ?>" class="btn text-success btn-sm"><i class="far fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5)) { ?>
                                                                    <a href="#" class="btn text-success btn-sm"><i class="fas fa-check-square fa-1x"></i></a>
                                                                <?php } ?>

                                                                <?php if (($idStatus == 6)) { ?>
                                                                    <a href="#" class="btn text-danger btn-sm"><i class="fas fa-times-circle fa-1x"></i></a>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
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
</div>