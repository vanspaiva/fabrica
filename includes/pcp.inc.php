<?php
if (isset($_POST["update"])) {

    // print_r($_POST);
    // exit();

    $id = addslashes($_POST["pedidoId"]);
    $fluxo = addslashes($_POST["fluxo"]);
    $lote = addslashes($_POST["lote"]);
    $nacinter = addslashes($_POST["nacinter"]);

    if (!empty($_POST["taxa_extra"])) {
        $taxa_extra = addslashes($_POST["taxa_extra"]);
    } else {
        $taxa_extra = 0;
    }
    //receber user depois 

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    updateFluxoPedido($conn, $id, $fluxo, $lote, $nacinter, $taxa_extra);
    // header("location: ../evolucaopcp?id=" . $id);

    //pegar todas as etapas 
    $todasEtapas = obterEtapasPorFluxo($conn, $fluxo);

    //pegar data de referencia
    $dataRef = dataReferenciaPedido($conn, $id);

    //criar etapas 

    // Converte $dataRef para um objeto DateTime para manipulação fácil de datas
    $dataAtual = new DateTime($dataRef);

    // foreach ($todasEtapas as $etapa) {
    //     $idEtapa = $etapa['idetapa'];
    //     $numOrdem = $etapa['ordem'];
    //     $duracao = $etapa['duracao'];

    //     // Calcula a data de realização adicionando a duração à data de referência
    //     $dataRealizacao = clone $dataAtual;
    //     $dataRealizacao->modify("+$duracao day");

    //     // Formata a data de realização para o formato de banco de dados
    //     $dataRealizacaoStr = $dataRealizacao->format('Y-m-d');
    //     $idStatus = 1;

    //     // Insere os dados na tabela realizacaoproducao
    //     novaRealizacaoProducao($conn, $id, $fluxo, $numOrdem, $idEtapa, $idStatus, $dataRealizacaoStr);


    //     // Atualiza a data de referência para a próxima iteração
    //     $dataAtual = clone $dataRealizacao;
    //     // echo "<br>" . $dataAtual;
    // }

// Supondo que você já tenha a lista de etapas em $todasEtapas

$horasPorDia = 9; // Número de horas de trabalho por dia
$horaInicio = 8;  // Horário de início do trabalho
$horaFim = 18;   // Horário de fim do trabalho

foreach ($todasEtapas as $etapa) {
    $idEtapa = $etapa['idetapa'];
    $numOrdem = $etapa['ordem'];
    $duracaoHoras = $etapa['duracao']; // Duração em horas

    // Exibe a duração original para debug
    echo "<p>Etapa ID: $idEtapa, Ordem: $numOrdem, Duração Original: $duracaoHoras horas</p>";

    // Calcula a data de realização começando com a data atual
    $dataRealizacao = clone $dataAtual;
    $horaAtual = $dataRealizacao->format('H');
    $duracaoHorasOriginal = $duracaoHoras; // Guarda a duração original para debug

    $dataInicio = $dataRealizacao->format('Y-m-d H:i:s'); // Data e hora de início
    $dataFinalizacao = null; // Inicializa a variável

    while ($duracaoHoras > 0) {
        // Calcula o tempo restante do dia de trabalho
        $tempoRestanteDia = $horaFim - $horaAtual;

        if ($tempoRestanteDia > 0) {
            if ($duracaoHoras <= $tempoRestanteDia) {
                // Conclui a tarefa no mesmo dia
                $dataRealizacao->setTime($horaAtual + $duracaoHoras, 0);
                $dataFinalizacao = $dataRealizacao->format('Y-m-d H:i:s'); // Data e hora de finalização
                echo "<p>Concluindo no mesmo dia: $duracaoHoras horas restantes</p>";
                $duracaoHoras = 0;
            } else {
                // Move para o próximo dia
                $duracaoHoras -= $tempoRestanteDia;
                $dataRealizacao->setTime($horaFim, 0);
                $dataRealizacao->modify('+1 day');
                while ($dataRealizacao->format('N') >= 6) {
                    $dataRealizacao->modify('+1 day');
                }
                $dataRealizacao->setTime($horaInicio, 0); // Define o horário de início do próximo dia
                $horaAtual = $horaInicio;
                echo "<p>Movendo para o próximo dia: $duracaoHoras horas restantes</p>";
            }
        } else {
            // Move para o próximo dia útil se o tempo restante no dia for zero ou negativo
            $dataRealizacao->modify('+1 day');
            while ($dataRealizacao->format('N') >= 6) {
                $dataRealizacao->modify('+1 day');
            }
            $dataRealizacao->setTime($horaInicio, 0); // Define o horário de início do próximo dia
            $horaAtual = $horaInicio;
            echo "<p>Movendo para o próximo dia útil: $duracaoHoras horas restantes</p>";
        }
    }


    // Formata a data de realização para o formato de banco de dados
    $dataRealizacaoStr = $dataRealizacao->format('Y-m-d');
    $idStatus = 1;

    // Insere os dados na tabela realizacaoproducao
    novaRealizacaoProducao($conn, $id, $fluxo, $numOrdem, $idEtapa, $idStatus, $dataRealizacaoStr);

    // Atualiza a data de referência para a próxima iteração
    $dataAtual = clone $dataRealizacao;


}

 
//redirecionar para pagina de acompanhamento desse pedido
    header("location: ../visualizarpedido?id=" . $id);
} else if (isset($_POST["opsimple"])) {

    $tp_contacriador = addslashes($_POST["tp_contacriador"]);
    $nomecriador = addslashes($_POST["nomecriador"]);
    $emailcriacao = addslashes($_POST["emailcriacao"]);
    $dtcriacao = addslashes($_POST["dtcriacao"]);
    $userip = addslashes($_POST["userip"]);
    $nped = addslashes($_POST["nped"]);
    $fluxo = addslashes($_POST["fluxo"]);
    $lote = addslashes($_POST["lote"]);
    $dr = addslashes($_POST["dr"]);
    $pac = addslashes($_POST["pac"]);
    $nacinter = addslashes($_POST["nacinter"]);
    $obs = addslashes($_POST["obs"]);

    if (!empty($_POST["taxa_extra"])) {
        $taxa_extra = addslashes($_POST["taxa_extra"]);
    } else {
        $taxa_extra = 0;
    }
    //receber user depois 

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    //contar hj + 20 dias uteis para ter data de entrega
    $hoje = hoje();
    $diasparaproduzir = null;
    $dataEntrega = null/*  somarDiasUteis($hoje, $diasparaproduzir) */;

    //criar pedido
    inserirPedidoSimples($conn, $dr, $pac, $nped, $hoje, $fluxo, $lote, $dataEntrega, $diasparaproduzir, $nacinter, $taxa_extra, $obs);



    //redirecionar para pagina de acompanhamento desse pedido
    header("location: ../pcp");
} else {
    header("location: ../evolucaopcp");
    exit();
}
