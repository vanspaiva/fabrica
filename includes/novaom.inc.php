<?php

if (isset($_POST["submit"])) {
    require_once '../db/dbh.php';
    require_once 'functions.inc.php';


    $tpManutenção = addslashes($_POST['tipo_manutencao']);
    $mqOperacinal = addslashes($_POST['maqOperavel']);
    $tempoNoperacional = addslashes($_POST['tempoNaoOperacional']);
    

    $tp_contacriador = addslashes($_POST["tp_contacriador"]);
    $nomecriador = addslashes($_POST["nomecriador"]);
    $emailcriacao = addslashes($_POST["emailcriacao"]);
    $dtcriacao = addslashes($_POST["dtcriacao"]);
    $userip = addslashes($_POST["userip"]);


    $idMaquinaInput = addslashes($_POST["idMaquina"]);
    $omNomeMaquina = addslashes($_POST["omNomeMaquina"]);
    $omIdentificadorMaquina = addslashes($_POST["omIdentificadorMaquina"]);

    // Normaliza o ID da máquina
    $normalizedId = preg_replace('/\D/', '', $idMaquinaInput); // Remove tudo que não é dígito
    $formattedIdMaquina = "MAQ." . str_pad($normalizedId, 3, '0', STR_PAD_LEFT);

    // Buscar o ID da máquina na tabela om_maquina
    $stmt = $conn->prepare("SELECT idMaquina FROM om_maquina WHERE idMaquina = ? OR REPLACE(idMaquina, 'MAQ.', '') = ?");
    $stmt->bind_param("ss", $formattedIdMaquina, $normalizedId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $idMaquina = $row['idMaquina'];
    } else {
        $idMaquina = null;
    }

    $stmt->close(); 

    //$setor = addslashes($_POST["setor"]);
    $setor = "None";
    $descricao = addslashes($_POST["descricao"]);
    $grauurgencia = addslashes($_POST["grauurgencia"]);

    $urlArquivo = addslashes($_POST["urlThrowback"]);

    if (empty($_POST['obs'])) {
        $obs = null;
    } else {
        $obs = addslashes($_POST["obs"]);
    }

    if (empty($_FILES["formFile"]["name"])) {
        $pname = null;
        $tname = null;
    } else {
        #file name with a random number so that similar dont get replaced
        $pname = rand(1000, 10000) . "-" . $_FILES["formFile"]["name"];

        #temporary file name to store file
        $tname = $_FILES["formFile"]["tmp_name"];
    }



    createOM($conn, $tp_contacriador, $nomecriador, $emailcriacao, $dtcriacao, $userip, $setor, $descricao, $grauurgencia, $obs, $tname, $urlArquivo, $tpManutenção, $mqOperacinal,  $tempoNoperacional, $idMaquina, $omNomeMaquina, $omIdentificadorMaquina);
} else {
    header("location: ../solicitacao");
    exit();
}