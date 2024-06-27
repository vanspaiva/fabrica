<?php
// Verifica se o formulário foi submetido
if (isset($_POST["submit"])) {
    require_once '../db/dbh.php'; // Inclui o arquivo que conecta ao banco de dados
    require_once 'functions.inc.php'; // Inclui funções necessárias, se houver

    // Captura os dados do formulário
    $dataPublicacao = $_POST["dataPublicacao"];
    $dataValidade = $_POST["dataValidade"];
    $marcaModelo = "Springer";
    
    // Calcula a data de validade (adicionando 2 anos à data de publicação)
    $dataValidade = date('Y-m-d', strtotime($dataPublicacao . ' + 2 years'));

    // Insere os dados na tabela frm_inf_004
    $sql = "INSERT INTO frm_inf_004 (data_publicacao, data_validade, modelo, usersId) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssi", $dataPublicacao, $dataValidade, $marcaModelo, $userId); // Supondo que $userId esteja definido em outro lugar
    mysqli_stmt_execute($stmt);
    $frmInfId = mysqli_insert_id($conn);

    // Captura a data de manutenção do formulário
    $dataManutencao = $_POST['dataManutencao'];

    // Insere os dados na tabela atividades_executadas
    $sql = "INSERT INTO atividades_executadas (data_manutencao, frm_inf_004_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $dataManutencao, $frmInfId);
    $stmt->execute();

    // Insere os dados na tabela setor_arcondicionado
    $descricaoSetores = addslashes($_POST["descricao_setores"]);
    $sql = "INSERT INTO setor_arcondicionado (descricao_setores) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $descricaoSetores);
    $stmt->execute();

    // Insere os dados na tabela checkbox_selecionados
    $executado = $_POST['executado'];
    $descriptions = [
        1 => "Verificação e drenagem da água",
        2 => "Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)",
        3 => "Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)",
        4 => "Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros",
        5 => "Trocar filtros",
        6 => "Verificação da fixação",
        7 => "Verificação de vazamentos nas ligações flexíveis",
        8 => "Estado de conservação do isolamento termo-acústico",
        9 => "Vedação dos painéis de fechamento do gabinete",
        10 => "Manutenção mecânica",
        11 => "Manutenção elétrica",
        12 => "Outros"
    ];

    $sql = "INSERT INTO checkbox_selecionados (ids_descricoes_selecionadas) VALUES (?)";
    $stmt = $conn->prepare($sql);

    foreach ($executado as $id) {
        if (isset($descriptions[$id])) {
            $descricao = $descriptions[$id];
            $ids_descricoes = implode(",", $executado); // Ajustado para pegar todos os IDs selecionados

            $stmt->bind_param("s", $ids_descricoes);
            if (!$stmt->execute()) {
                die('Erro ao executar a consulta SQL: ' . $stmt->error);
            }
        }
    }

    // Redireciona para outra página após o processamento
    header("location: ../solicitacao");
    exit();
} else {
    // Se o formulário não foi submetido, redireciona para outra página
    header("location: ../solicitacao");
    exit();
}
?>