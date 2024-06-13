<?php
session_start();

if (isset($_POST['submit'])) {
    require_once 'dbh.php'; // Incluir o arquivo de conexão com o banco de dados

    // Extrair os dados do formulário
    $dataPublicacao = $_POST['dataPublicacao'];
    $identificadorAmbiente = $_POST['identificadorAmbiente'];
    $tipoAtividade = $_POST['tipoAtividade'];
    $marcaModelo = 'Springer'; // Valor fixo para a marca/modelo

    // Calcular a data de validade (dois anos após a data de publicação)
    $dataPublicacaoObj = new DateTime($dataPublicacao);
    $dataValidadeObj = $dataPublicacaoObj->modify('+2 years');
    $dataValidade = $dataValidadeObj->format('Y-m-d');

    // Extrair os dados do usuário da sessão
    $nomeCriador = $_SESSION["useruid"]; // Não precisamos do tipo de conta ou e-mail para este formulário
    $dataCriacao = date('Y-m-d H:i:s'); // Use o formato de data e hora do MySQL
    $userIP = $_SERVER['REMOTE_ADDR']; // Obtém o IP do usuário

    // Consulta para inserir os dados na tabela FRM_INF_004
    $sql1 = "INSERT INTO FRM_INF_004 (data_publicacao, validade, identificacao_ambiente, tipo_atividade, modelo) 
             VALUES ('$dataPublicacao', '$dataValidade', '$identificadorAmbiente', '$tipoAtividade', '$marcaModelo')";
    // Executar a consulta
    if (mysqli_query($conn, $sql1)) {
        $frmInfId = mysqli_insert_id($conn);

        // Verificar se o array $_POST['executado'] está definido e não vazio
        if (isset($_POST['executado']) && !empty($_POST['executado'])) {
            // Consulta para inserir os dados na tabela ATIVIDADES_EXERCIDAS
            foreach ($_POST['executado'] as $key => $value) {
                $descricaoAtividade = $value; // A descrição da atividade está diretamente no valor do checkbox marcado
                $executado = 1; // Sempre será 1 porque só entrará no loop se o checkbox estiver marcado
                $responsavel = $_POST['responsavel'][$key];
                $dataAtividade = $_POST['dataAtividade'];

                $sql2 = "INSERT INTO ATIVIDADES_EXERCIDAS (data, frm_inf_004_id, descricao_atividade_id, executado, user_id) 
                         VALUES ('$dataAtividade', '$frmInfId', NULL, '$executado', '$nomeCriador')";
                // Executar a consulta
                mysqli_query($conn, $sql2);
            }
        }

        // Redirecionar após o envio do formulário
        header("Location: ../index.php?success=submit");
        exit();
    } else {
        // Se houver um erro na inserção na tabela FRM_INF_004
        echo "Erro ao executar a consulta: " . mysqli_error($conn);
    }
} else {
    // Redirecionar se alguém tentar acessar este script diretamente sem enviar o formulário
    header("Location: ../index.php");
    exit();
}
?>
