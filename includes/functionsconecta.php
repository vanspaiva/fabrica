<?php


function getAllArquivados($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Arquivado (+90 dias)');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllConcluidos($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PROD', 'ENVIADO', 'Retrabalho');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPlanejando($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PLAN', 'PDF', 'PROJ', 'Pré Planejamento', 'Segmentação');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllAfazer($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Projeto Aceito', 'Solicitação de Alteração', 'CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPendentes($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('Vídeo Agendada', 'VIDEO', 'ACEITE', 'Aguardando info/Docs', 'Avaliar Projeto');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllProjetistaProximo($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('CRIADO');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getAllPCP($conn)
{
    $arrayPedido = array();

    $sql = "SELECT `pedStatus` as 'status', COUNT(*) as 'qtd' FROM pedido WHERE `pedStatus` IN ('PCP');";
    $res = mysqli_query($conn, $sql);
    if (($res) and ($res->num_rows != 0)) {
        while ($row_user = mysqli_fetch_assoc($res)) {
            $resultado = $row_user['qtd'];
        }

        return $resultado;
    } else {
        return false;
    }
}

function getNomeFluxoPed($conn, $idPed)
{
    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['pedStatus'];

        $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
        while ($row2 = mysqli_fetch_array($ret2)) {
            $nomeFluxo = $row2["stpedNome"];
        }
        $dtAceite = '';
        if (($status == 'Projeto Aceito') || ($status == 'Solicitação de Alteração')) {
            $retPrz = mysqli_query($conn, "SELECT * FROM prazoproposta WHERE przNumProposta='$idPed' AND przStatus='Projeto Aceito'");
            while ($rowPrz = mysqli_fetch_array($retPrz)) {
                $dtAceite = $rowPrz['przData'];
            }

            if ($status == 'Projeto Aceito') {
                $nomeFluxo = 'Proj. Aceito - ' . dateFormat2($dtAceite);
            } else if ($status == 'Solicitação de Alteração') {
                $nomeFluxo = 'Sol. Alteração - ' . dateFormat2($dtAceite);
            }
        }
    }

    return $nomeFluxo;
}

function getCorFluxoPed($conn, $idPed)
{
    $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    while ($row = mysqli_fetch_array($ret)) {
        $status = $row['pedStatus'];

        $ret2 = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$status'");
        while ($row2 = mysqli_fetch_array($ret2)) {
            $corbg = $row2["stpedCorBg"];
            $cortxt = $row2["stpedCorTexto"];
        }

        $corFluxo = $corbg . " " . $cortxt;
    }

    return $corFluxo;
}

function getAndamentoForTableFluxoPed($conn, $idPed)
{
    // $ret = mysqli_query($conn, "SELECT * FROM pedido WHERE pedNumPedido='$idPed'");
    // while ($row = mysqli_fetch_array($ret)) {
    //     $switch = $row['pedStatus'];

    // }
    $dias = getDataPrazoContada($conn, $idPed);

    return $dias;
}

function getDataPrazoContada($conn, $numPedOG)
{
    $przDaysOn = 0;
    $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`przData`) as dataContada FROM prazoproposta WHERE przNumProposta='" . $numPedOG . "' ORDER BY przId DESC LIMIT 1;");
    while ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        // $przStatus = $rowPrzStatus["przStatus"];
        // $przData = $rowPrzStatus["przData"];
        $przDaysOn = $rowPrzStatus['dataContada'];
    }

    // Inicializa o contador de dias úteis
    $diasUteis = 0;

    // Obtém a data de criação do pedido
    $dataCriacao = date_create();
    date_sub($dataCriacao, date_interval_create_from_date_string($przDaysOn . ' days'));

    // Loop para contar os dias úteis
    for ($i = 0; $i <= abs($przDaysOn); $i++) {
        $dataAtual = clone $dataCriacao;
        date_add($dataAtual, date_interval_create_from_date_string($i . ' days'));

        // Verifica se o dia atual é um sábado ou domingo (fim de semana)
        if (date_format($dataAtual, 'N') <= 5) {
            $diasUteis++;
        }
    }

    return $diasUteis;
}

function dateFormat2($data)
{

    $dataRaw = explode(" ", $data);
    $newData = $dataRaw[0];

    $newData = explode("-", $newData);

    $res = $newData[2] . "/" . $newData[1] . "/" . $newData[0];

    return $res;
}

function getDataPrazoPosAceite2($conn, $numPedOG) {
    $dataPrazoContada = "-"; // Valor padrão caso algo dê errado

    $retPrzStatus = mysqli_query($conn, "SELECT *, DATEDIFF(now(),`przData`) as dataContada FROM prazoproposta WHERE przNumProposta='" . $numPedOG . "'  AND przStatus='Projeto Aceito' ORDER BY przId DESC LIMIT 1;");
    
    if ($rowPrzStatus = mysqli_fetch_array($retPrzStatus)) {
        // Verifique se as chaves existem antes de usá-las
        if (isset($rowPrzStatus["przStatus"]) && isset($rowPrzStatus["przData"])) {
            $przStatus = $rowPrzStatus["przStatus"];
            $przData = $rowPrzStatus["przData"];
            $dataCalculada = strtotime($przData . "+ 20 weekdays");
            $dataCalculada = date("d/m/Y", $dataCalculada);

            $ret = mysqli_query($conn, "SELECT * FROM statuspedido WHERE stpedValue ='$przStatus'");
            if ($row = mysqli_fetch_array($ret)) {
                if (isset($row["stpedCalcularDtPrazo"])) {
                    $calc = $row["stpedCalcularDtPrazo"];
                    if ($calc == true) {
                        $dataPrazoContada = $dataCalculada;
                    }
                }
            }
        }
    }

    return $dataPrazoContada;
}



function contarTamanhoTotal($conn, $query)
{
    // Remova a parte 'SELECT ... FROM' da consulta original
    $fromPosition = stripos($query, 'FROM');
    $countQuery = 'SELECT COUNT(*) AS total ' . substr($query, $fromPosition);

    // Execute a consulta de contagem
    $result = mysqli_query($conn, $countQuery);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['total'];
    } else {
        // Lide com erros, se necessário
        die("Query failed: " . mysqli_error($conn));
    }
}

function removerUltimoPontoEVirgula($query)
{
    $trimmedQuery = rtrim($query);
    if (substr($trimmedQuery, -1) === ';') {
        return substr($trimmedQuery, 0, -1);
    }
    return $trimmedQuery;
}