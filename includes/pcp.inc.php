<?php
if (isset($_POST["update"])) {

    // print_r($_POST);
    // exit();

    $id = addslashes($_POST["pedidoId"]);
    $fluxo = addslashes($_POST["fluxo"]);
    $lote = addslashes($_POST["lote"]);
    $nacinter = isset($_POST['nacinter']);
    $taxa_extra = isset($_POST['taxa_extra']) ? $_POST['taxa_extra'] : 0;
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

    foreach ($todasEtapas as $etapa) {
        $idEtapa = $etapa['idetapa'];
        $numOrdem = $etapa['ordem'];
        $duracao = $etapa['duracao'];

        // Calcula a data de realização adicionando a duração à data de referência
        $dataRealizacao = clone $dataAtual;

        // Adiciona os dias enquanto verifica se é sábado (6) ou domingo (7)
        $diasAdicionados = 0;
        while ($diasAdicionados < $duracao) {
            $dataRealizacao->modify("+1 day");
            $diaDaSemana = $dataRealizacao->format('N');
            if ($diaDaSemana < 6) {
                $diasAdicionados++;
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
    $diasparaproduzir = 20;
    $dataEntrega = somarDiasUteis($hoje, $diasparaproduzir);

    //criar pedido
    inserirPedidoSimples($conn, $dr, $pac, $nped, $hoje, $fluxo, $lote, $dataEntrega, $diasparaproduzir,$obs);

    //redirecionar para pagina de acompanhamento desse pedido
    header("location: ../pcp");
} else {
    header("location: ../evolucaopcp");
    exit();
}
