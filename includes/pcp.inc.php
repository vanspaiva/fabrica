<?php
if (isset($_POST["update"])) {

    $id = addslashes($_POST["pedidoId"]);
    $fluxo = addslashes($_POST["fluxo"]);
    //receber user depois 

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    updateFluxoPedido($conn, $id, $fluxo);
    // header("location: ../evolucaopcp?id=" . $id);

    //pegar todas as etapas 
    $todasEtapas = obterEtapasPorFluxo($conn, $fluxo);

    //pegar data de referencia
    $dataRef = dataReferenciaPedido($conn, $id);

    //criar etapas 

    // Converte $dataRef para um objeto DateTime para manipulação fácil de datas
    $dataAtual = new DateTime($dataRef);

    foreach ($todasEtapas as $etapa) {
        $idEtapa = $etapa['idetapa'];
        $numOrdem = $etapa['ordem'];
        $duracao = $etapa['duracao'];

        // Calcula a data de realização adicionando a duração à data de referência
        $dataRealizacao = clone $dataAtual;
        $dataRealizacao->modify("+$duracao day");

        // Formata a data de realização para o formato de banco de dados
        $dataRealizacaoStr = $dataRealizacao->format('Y-m-d');

        // Insere os dados na tabela realizacaoproducao
        novaRealizacaoProducao($conn, $id, $fluxo, $numOrdem, $idEtapa, $dataRealizacaoStr);

        // Atualiza a data de referência para a próxima iteração
        $dataAtual = clone $dataRealizacao;
        // echo "<br>" . $dataAtual;
    }

    //redirecionar para pagina de acompanhamento desse pedido
    header("location: ../evolucaopcp?id=" . $id);
} else {
    header("location: ../evolucaopcp");
    exit();
}


