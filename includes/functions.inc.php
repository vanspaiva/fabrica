<?php

function emptyInputSignup($name, $username, $email, $celular, $identificador, $uf, $pwd, $pwdrepeat)
{
    $result = true;

    if (empty($name) || empty($email) || empty($username) || empty($pwd) || empty($pwdrepeat || empty($celular) || empty($uf) || empty($identificador))) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidUid($username)
{
    $result = true;

    if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function invalidEmail($email)
{
    $result = true;

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function pwdMatch($pwd, $pwdrepeat)
{
    $result = true;

    if ($pwd !== $pwdrepeat) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function uidExists($conn, $username, $email)
{
    $sql = "SELECT * FROM users WHERE usersUid = ? OR usersEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $username, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function createUser($conn, $name, $username, $email, $celular, $identificador, $uf, $pwd, $permission, $aprovacao, $dep)
{
    $sql = "INSERT INTO users (usersName, usersUid, usersEmail, usersCel, usersIdentificador, usersUf, usersPwd, usersPerm, usersAprov, usersDepartamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssssssss", $name, $username, $email, $celular, $identificador, $uf, $hashedPwd, $permission, $aprovacao, $dep);
    mysqli_stmt_execute($stmt);


    sendEmailNotificationNewAccount($username, $pwd, $email);

    mysqli_stmt_close($stmt);
    exit();
}

function createNewUserAdm($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $pwd, $dep)
{

    $sql = "INSERT INTO users (usersName, usersUf, usersEmail, usersUid, usersCel, usersIdentificador, usersAprov, usersPerm, usersPwd, usersDepartamento) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "ssssssssss", $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $hashedPwd, $dep);
    mysqli_stmt_execute($stmt);

    $userId = getLastUserId($conn);
    if ($dep ==  2) {
        $etapas = [5, 8, 11, 15];

        inserirEtapasColaborador($conn, $userId, $etapas);
    }

    mysqli_stmt_close($stmt);

    header("location: ../users?error=created");
    exit();
}

function editUser($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $dep, $usersid)
{
    $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersEmail='$email', usersUid='$uid', usersCel='$celular', usersIdentificador='$identificador', usersAprov='$aprov', usersPerm='$perm', usersDepartamento='$dep' WHERE usersId='$usersid'";


    if (mysqli_query($conn, $sql)) {
        header("location: ../users?error=none");
    } else {
        header("location: ../users?error=stmfailed");
    }
    mysqli_close($conn);


    exit();
}

function aprovUser($conn, $id, $nome, $uid, $email, $celular)
{
    $aprov = "APROV";

    $sql = "UPDATE users SET usersAprov='$aprov' WHERE usersId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: users");
    } else {
        header("location: users?error=stmfailed");
    }
    mysqli_close($conn);

    //notificar

    $content = '*Olá, ' . $nome . '!* Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site dev.conecta.cpmhdigital.com.br e efetue o login com seu usuário *' . $uid . '*. Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.';


    $cel = implode('', explode(' ', $celular));
    $cel = implode('', explode('-', $cel));
    $cel = implode('', explode('(', $cel));
    $cel = implode('', explode(')', $cel));
    $notificationCelular = '+55' . $cel;


    sendEmailNotificationCadastroAprovado($email, $nome, $uid);

    sendNotification($notificationCelular, $content);
}


function editUserFromUser($conn, $usersid, $nome, $uf, $email, $uid, $celular, $identificador)
{

    if (empty($nome) || empty($uf) || empty($email) || empty($uid) || empty($celular) || empty($identificador)) {
        header("location: ../profile?usuario=" . $uid . "&error=emptyerror");
        exit();
    } else {
        $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersCel='$celular', usersIdentificador='$identificador'  WHERE usersUid ='$uid'";
    }

    if (mysqli_query($conn, $sql)) {
        header("location: ../profile?usuario=" . $uid . "&error=edit");
    } else {
        header("location: ../profile?usuario=" . $uid . "&error=stmfailed");
    }
    mysqli_close($conn);
}

function deleteUser($conn, $id)
{
    $sql = "DELETE FROM users WHERE usersId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: users?error=deleted");
    } else {
        header("location: users?error=stmtfailed");
    }
    mysqli_close($conn);
}

function editPwd($conn, $user, $pwd, $confirmpwd)
{

    if (pwdMatch($pwd, $confirmpwd)) {
        header("location: ../profile?usuario=" . $user . "&error=pwderror");
        exit();
    } else {
        $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    }

    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../profile?usuario=" . $user . "&error=none");
    } else {
        header("location: ../profile?usuario=" . $user . "&error=stmfailed");
    }
    mysqli_close($conn);
}

function editPwdAdm($conn, $user, $pwd)
{
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        header("location: ../mudarsenha?error=none");
    } else {
        header("location: ../mudarsenha?error=stmfailed");
    }
    mysqli_close($conn);
}

function emptyInputLogin($username, $pwd)
{
    $result = true;

    if (empty($username) || empty($pwd)) {
        $result = true;
    } else {
        $result = false;
    }

    return $result;
}

function loginUser($conn, $username, $pwd)
{
    $uidExists = uidExists($conn, $username, $username);

    if ($uidExists == false) {
        header("location: ../login?error=wronglogin");
        exit();
    }

    $pwdHashed = $uidExists["usersPwd"];
    $_SESSION["useraprovacao"] = getAprov($uidExists);

    $checkPwd = password_verify($pwd, $pwdHashed);

    if ($checkPwd === false) {
        header("location: ../login?error=wronglogin");
        exit();
    } else if ($_SESSION["useraprovacao"] === 'Aguardando') {
        header("location: ../login?error=waitaprov");
        exit();
    } else if ($_SESSION["useraprovacao"] === 'Bloqueado') {
        header("location: ../login?error=bloquser");
        exit();
    } else if ($checkPwd === true) {
        session_start();
        $_SESSION["userid"] = $uidExists["usersId"];
        $_SESSION["useruid"] = $uidExists["usersUid"];
        $_SESSION["userperm"]  = getPermission($uidExists);
        $_SESSION["userfirstname"] = getNameUser($uidExists);
        $_SESSION["useriddep"] = getUserIdDepartamento($uidExists);
        $_SESSION["usernomedep"] = getUserNomeDepartamento($conn, $uidExists);

        header("location: ../dash");
        exit();
    }
}

function getPermission($uidExists)
{

    if ($uidExists["usersPerm"] == '1ADM') {
        return 'Administrador';
    } else if ($uidExists["usersPerm"] == '2GES') {
        return 'Gestor(a)';
    } else if ($uidExists["usersPerm"] == '3COL') {
        return 'Colaborador(a)';
    }
}

function getNameUser($uidExists)
{
    $nomeCompleto = $uidExists["usersName"];
    $nomeCompleto = explode(" ", $uidExists["usersName"]);

    return $nomeCompleto[0];
}

function getUserIdDepartamento($uidExists)
{
    $idDep = $uidExists["usersDepartamento"];
    return $idDep;
}

function getUserNomeDepartamento($conn, $uidExists)
{

    $idDep = $uidExists["usersDepartamento"];
    $nomeDep = getDepartamentoNome($conn, $idDep);
    return $nomeDep;
}

function getAprov($uidExists)
{
    if ($uidExists["usersAprov"] == 'AGRDD') {
        return 'Aguardando';
    } else if ($uidExists["usersAprov"] == 'APROV') {
        return 'Aprovado';
    } else if ($uidExists["usersAprov"] == 'BLOQD') {
        return 'Bloqueado';
    }
}

function createProduto($conn, $categoria, $cdg, $descricao, $anvisa)
{

    $sql = "INSERT INTO produtos (prodCategoria, prodCodCallisto, prodDescricao, prodAnvisa) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../produtos?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $categoria, $cdg, $descricao, $anvisa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../produtos?error=none");
    exit();
}

function editProduto($conn, $prodid, $categoria, $cdg, $descricao, $anvisa)
{
    $sql = "UPDATE produtos SET prodCategoria='$categoria', prodCodCallisto='$cdg', prodDescricao='$descricao', prodAnvisa='$anvisa' WHERE prodId='$prodid'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../produtos?error=edit");
    } else {
        header("location: ../produtos?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteProd($conn, $id)
{
    $sql = "DELETE FROM produtos WHERE prodId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: produtos?error=deleted");
    } else {
        header("location: produtos?error=stmtfailed");
    }
    mysqli_close($conn);
}

function createOS($conn, $tp_contacriador, $nomecriador, $emailcriacao, $dtcriacao, $userip, $dtentrega, $setor, $descricao, $grauurgencia, $lote, $nped, $obs, $tname, $pname)
{
    $sql = "INSERT INTO ordenservico (osUserCriador, osNomeCriador, osEmailCriador, osUserIp, osSetor, osDescricao, osLote, osNPed, osNomeArquivo, osGrauUrgencia, osDtEntregasDesejada, osObs, osStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    $status = "CRIADO";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../lista-os?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssss", $tp_contacriador, $nomecriador, $emailcriacao, $userip, $setor, $descricao, $lote, $nped, $pname, $grauurgencia, $dtentrega, $obs, $status);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_stmt_init($conn);
    $getOS = mysqli_query($conn, "SELECT * FROM ordenservico ORDER BY osId DESC LIMIT 1;");
    $rowOS = mysqli_fetch_array($getOS);
    $osId = $rowOS['osId'];

    uploadArquivo($conn, $tname, $pname, $osId);


    header("location: ../lista-os?error=sent");
    exit();
}

function createOM($conn, $tp_contacriador, $nomecriador, $emailcriacao, $dtcriacao, $userip, $dtentrega, $setor, $descricao, $grauurgencia, $nmaquina, $nomemaquina, $obs, $tname, $urlArquivo)
{
    $sql = "INSERT INTO ordenmanutencao (omUserCriador, omNomeCriador, omEmailCriador, omUserIp, omSetor, omDescricao, omNumMaquina, omNomeMaquina, omNomeArquivo, omGrauUrgencia, omDtEntregasDesejada, omObs, omStatus) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    $status = "CRIADO";

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../lista-om?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssssssssss", $tp_contacriador, $nomecriador, $emailcriacao, $userip, $setor, $descricao, $nmaquina, $nomemaquina, $pname, $grauurgencia, $dtentrega, $obs, $status);

    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_stmt_init($conn);
    $getOM = mysqli_query($conn, "SELECT * FROM ordenmanutencao ORDER BY omId DESC LIMIT 1;");
    $rowOM = mysqli_fetch_array($getOM);
    $omId = $rowOM['omId'];

    uploadArquivo($conn, $tname, $pname, $omId);

    sendEmailNotificationNewOM($nomecriador, $emailcriacao, $dtcriacao, $nmaquina, $nomemaquina);
    header("location: ../lista-om?error=sent");
    exit();
}

function sendEmailNotificationNewOM($nomecriador, $emailcriacao, $dtcriacao, $nmaquina, $nomemaquina)
{
    $arquivo = '<!DOCTYPE html>
        <html lang="pt-br">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Bem vindo ao Sistema Fábrica!</title>
            <style>
                /* Estilos para tornar o email mais atraente */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
        
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #EDEDED;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
        
                h1,
                h3 {
                    text-align: start;
                    padding-top: 0;
                    margin-top: 0;
                }
        
                h3 {
                    color: rgb(0, 212, 111);
                }
        
                a {
                    color: #fff;
                }
        
                .btn-container {
                    text-align: center;
                }
        
                .btn {
                    display: inline-block;
                    background-color: rgb(0, 212, 111);
                    color: #fff !important;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 20px;
                    font-weight: bold;
                }
        
                img {
                    width: 180px;
                    margin: 0;
                    padding: 0;
                }
        
                .d-flex {
                    display: flex;
                    margin: 0;
                    padding: 0;
                }
        
                .justify-content-center {
                    justify-content: center;
                }
        
                .justify-content-around {
                    justify-content: space-around;
                }
        
                .align-items-center {
                    align-items: center;
                }
        
            </style>
        </head>
        
        <body>
        <div class="container">              
        
        <p>Nova criação de Ordem de Manutenção no <strong>Sistema Fábrica</strong>. Por favor entre no sistema e verifique.</p>

        <p>
            <strong>Quem criou: </strong> ' . $nomecriador . '<br>
            <strong>Data: </strong> ' . $dtcriacao . '
            <strong>Nº Máquina: </strong> ' . $nmaquina . '
            <strong>Nome Máquina: </strong> ' . $nomemaquina . '
        </p>
        
        <div class="btn-container">
            <a href="http://fabrica.cpmh.com.br/" class="btn">Entar no sistema</a>
        </div>
        <p>Att,</p>
        <p>Equipe de Desenvolvimento</p>
    </div>
        </body>
        
        </html>';

    $assunto = "Sistema da Fábrica - Nova OM";
    $email = "qualidade@fixhealth.com.br";
    $returnTrue = "location: ../lista-om?error=sent";
    $returnFalse = "";

    geralSendEmailNotification($email, $assunto, $arquivo, $returnTrue, $returnFalse);
}

function uploadArquivo($conn, $tname, $pname, $osId)
{

    //Registra nova arquivo
    $sql = "INSERT INTO filedownload (fileRealName, fileOsRef, filePath) VALUES (?,?,?);";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../solicitacao?error=stmtfailed");
        exit();
    }

    #upload directory path
    // $uploads_dir = '/arquivos';
    $uploads_dir = '../arquivos/' . $osId;

    if (!file_exists('../arquivos/' . $osId)) {
        mkdir('../arquivos/' . $osId, 0777, true);
    }

    mysqli_stmt_bind_param($stmt, "sss", $pname, $osId, $uploads_dir);
    mysqli_stmt_execute($stmt);
    move_uploaded_file($tname, $uploads_dir . '/' . $pname);
    mysqli_stmt_close($stmt);
}

function deleteOs($conn, $id)
{
    $sql = "DELETE FROM ordenservico WHERE osId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: lista-os?error=deleted");
    } else {
        header("location: lista-os?error=stmtfailed");
    }
    mysqli_close($conn);
}

function deleteOM($conn, $id)
{
    $sql = "DELETE FROM ordenmanutencao WHERE omId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: lista-om?error=deleted");
    } else {
        header("location: lista-om?error=stmtfailed");
    }
    mysqli_close($conn);
}

function editOs($conn, $osid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $lote, $nped, $obs, $user)
{
    $sql = "UPDATE ordenservico SET osSetor='$setor', osDescricao='$descricao', osLote='$lote', osNPed='$nped', osGrauUrgencia='$grau', osDtEntregaReal='$dtrealentrega', dtExecucao='$dtexecucao', osObs='$obs', osStatus='$status'  WHERE osId ='$osid'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../lista-os?error=edit");
    } else {
        header("location: lista-os?error=stmtfailed");
    }

    $type = 'os';

    logAtividade($conn, $osid, $status, $user, $type);

    mysqli_close($conn);
}

function editOM($conn, $omid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $nmaquina, $nomemaquina, $obs, $user, $tipomanutencao, $operacional, $acaoquali, $requalificar, $resprequali, $respmanutencao)
{
    $sql = "UPDATE ordenmanutencao SET omSetor = ?, omDescricao = ?, omNumMaquina = ?, omNomeMaquina = ?, omGrauUrgencia = ?, omDtEntregaReal = ?, dtExecucao = ?, omObs = ?, omStatus = ?, omTipoManutencao = ?, omOperacional = ?, omAcaoQualidade = ?, omRequalificar = ?, omIdRespRequalificar = ?, omIdRespManutencao = ? WHERE omId = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssssssssssssssss", $setor, $descricao, $nmaquina, $nomemaquina, $grau, $dtrealentrega, $dtexecucao, $obs, $status, $tipomanutencao, $operacional, $acaoquali, $requalificar, $resprequali, $respmanutencao, $omid);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    $type = 'om';
    logAtividade($conn, $omid, $status, $user, $type);

    mysqli_close($conn);
}


function concluirAtividade($conn, $id, $user)
{
    $status = "CONCLUÍDO";

    $sql = "UPDATE ordenservico SET osStatus='$status' WHERE osId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoos");
    } else {
        header("location: lista-os?error=stmfailed");
    }
    $type = 'os';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function iniciarAtividade($conn, $id, $user)
{
    $status = "EM ANDAMENTO";

    $sql = "UPDATE ordenservico SET osStatus='$status' WHERE osId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoos");
    } else {
        header("location: lista-os?error=stmfailed");
    }
    $type = 'os';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function pausarAtividade($conn, $id, $user)
{
    $status = "PAUSADO";

    $sql = "UPDATE ordenservico SET osStatus='$status' WHERE osId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoos");
    } else {
        header("location: lista-os?error=stmfailed");
    }
    $type = 'os';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function concluirAtividadeOM($conn, $id, $user)
{
    $status = "CONCLUÍDO";

    $sql = "UPDATE ordenmanutencao SET omStatus='$status' WHERE omId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoom");
    } else {
        header("location: lista-om?error=stmfailed");
    }
    $type = 'om';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function iniciarAtividadeOM($conn, $id, $user)
{
    $status = "EM ANDAMENTO";

    $sql = "UPDATE ordenmanutencao SET omStatus='$status' WHERE omId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoom");
    } else {
        header("location: lista-om?error=stmfailed");
    }
    $type = 'om';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function pausarAtividadeOM($conn, $id, $user)
{
    $status = "PAUSADO";

    $sql = "UPDATE ordenmanutencao SET omStatus='$status' WHERE omId='$id'";

    if (mysqli_query($conn, $sql)) {
        header("location: acompanhamentoom");
    } else {
        header("location: lista-om?error=stmfailed");
    }
    $type = 'om';
    logAtividade($conn, $id, $status, $user, $type);

    mysqli_close($conn);
}

function logAtividade($conn, $id, $status, $user, $type)
{
    $sql = "INSERT INTO logatividades (logOsRef, logStatus, logUser, logTipo) VALUES (?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $id, $status, $user, $type);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
    // exit();
}


function sendNotification($phone, $content)
{

    $data = [
        'phone' => $phone, // Receivers phone
        'body' => $content, // Message
    ];

    $json = json_encode($data); // Encode data to JSON

    // URL for request POST /message
    $url = 'https://api.chat-api.com/instance271590/sendMessage?token=2agtk9erjtmgh0f5';

    // Make a POST request
    $options = stream_context_create([
        'http' => [
            'method'  => 'POST',
            'header'  => 'Content-type: application/json',
            'content' => $json
        ]
    ]);

    // Send a request
    $result = file_get_contents($url, false, $options);
}


function newPassword($conn, $email)
{

    $uidExists = uidExists($conn, $email, $email);

    if ($uidExists == false) {
        header("location: ../senha?error=wrongemail");
        exit();
    }

    $uid = $uidExists["usersUid"];
    $userEmail = $uidExists["usersEmail"];
    $celular = $uidExists["usersCel"];
    $nomeCompleto = $uidExists["usersName"];
    $nomeCompleto = explode(" ", $uidExists["usersName"]);
    $nome = $nomeCompleto[0];

    $pwd = generatePwd();
    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
    editPwdFromRecover($conn, $uid, $hashedPwd, $userEmail, $nome, $pwd, $celular);
}

function generatePwd()
{
    $upper = implode('', range('A', 'Z')); // ABCDEFGHIJKLMNOPQRSTUVWXYZ
    $lower = implode('', range('a', 'z')); // abcdefghijklmnopqrstuvwxyzy
    $nums = implode('', range(0, 9)); // 0123456789

    $alphaNumeric = $upper . $lower . $nums; // ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789
    $string = '';
    $len = 7; // numero de chars
    for ($i = 0; $i < $len; $i++) {
        $string .= $alphaNumeric[rand(0, strlen($alphaNumeric) - 1)];
    }
    return $string; // ex: q02TAq3

}

function editPwdFromRecover($conn, $user, $hashedPwd, $userEmail, $nome, $pwd, $celular)
{
    $content = 'Olá ' . $nome . '! Você solicitou a *redefinição de senha do Portal Conecta*. Siga as instruções para retomar seu acesso.';
    $content .= '1º Entre no Portal Conecta pelo link https://dev.conecta.cpmhdigital.com.br. [usuário: *_' . $user . '_* / senha: *_' . $pwd . '_*].';
    $content .= '2º Entre no seu perfil e atualize a senha para a que você desejar.';


    $sql = "UPDATE users SET usersPwd='$hashedPwd' WHERE usersUid='$user'";

    if (mysqli_query($conn, $sql)) {

        sendEmailNotification($userEmail, $nome, $pwd, $user);
        $cel = implode('', explode(' ', $celular));
        $cel = implode('', explode('-', $cel));
        $cel = implode('', explode('(', $cel));
        $cel = implode('', explode(')', $cel));
        $notificationCelular = '+55' . $cel;

        sendNotification($notificationCelular, $content);
    } else {
        header("location: ../senha?error=wrongemail");
    }
    mysqli_close($conn);
}

//comercial@teste.com

function sendEmailNotification($userEmail, $nome, $pwd, $user)
{
    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <style>
        .box{
            background-color: #373342;
            padding: 10px 10px;
            display: flex;
            justify-content: center;
        }

        .box-middle{
            background-color: #e9e9e9;
            padding: 5px 5px;
            display: flex;
            justify-content: center;
        }

        h1{
            color: #fff;
            font-weight: 500px;
            font-family: "Montserrat", sans-serif;
            display: block;
        }

        h3{
            font-family: "Montserrat", sans-serif;
        }

        li{
            font-family: "Montserrat", sans-serif;
        }

        ul{
            list-style-type: none;
            text-align: center;
        }

        p{
            font-weight: 300px;
            font-family: "Montserrat", sans-serif;
        }

        .font-text{
            font-family: "Montserrat", sans-serif;	
        }

        .d-block{
            display: flex;
            flex-direction: column;
        }

        
    </style>

    <body>
        <div class="logo">
            
        </div>
        <div class="box">
            <h1>Alteração de Senha</h1>
        </div>
        <div class="d-block">
            <div class="box-middle">
                <h3>Olá ' . $nome . '!</h3>
            </div>
            <div class="box-middle">
                <p>Você solicitou a <b>redefinição de senha do Portal Conecta</b>. Siga as instruções abaixo para retomar seu acesso.</p>
            </div>
        </div>
        <div class="d-block">
            <div class="box-middle">
                <ul>
                    <li>1º Entre no <a href="https://dev.conecta.cpmhdigital.com.br">Portal Conecta</a>.</li>
                    <li>usuário: <b>' . $user . '</b> </li>
                    <li>senha: <b>' . $pwd . '</b></li>
                    <li>2º Entre no seu perfil e atualize a senha para a que você desejar.</li>
                </ul>
            </div>
            <div class="box-middle" style="padding-top: 30px;">
                <small class="font-text" style="color: gray; text-align: center;">Caso você não tenha solicitado a alteração de senha, mude sua senha na plataforma para sua segurança.</small>
            </div>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;">
            <small class="font-text" style="color: gray;">&copy; Portal Conecta 2021</small>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;"></div>
    </body>

    </html>

    ';

    $destino = $userEmail;
    $assunto = "Recuperar Senha - Portal Conecta";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // $headers .= 'From: Portal Conecta';
    //$headers .= "Bcc: $EmailPadrao\r\n";

    $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    if ($enviaremail) {
        header("location: ../senha?error=none");
    }
    // else {
    //     header("location: ../password.php?error=wrongemail");
    // }
}

function sendEmailNotificationCreate($userEmail, $nome)
{
    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <style>
        .box{
            background-color: #373342;
            padding: 10px 10px;
            display: flex;
            justify-content: center;
        }

        .box-middle{
            background-color: #e9e9e9;
            padding: 5px 5px;
            display: flex;
            justify-content: center;
        }

        h1{
            color: #fff;
            font-weight: 500px;
            font-family: "Montserrat", sans-serif;
            display: block;
        }

        h3{
            font-family: "Montserrat", sans-serif;
        }

        li{
            font-family: "Montserrat", sans-serif;
        }

        ul{
            list-style-type: none;
            text-align: center;
        }

        p{
            font-weight: 300px;
            font-family: "Montserrat", sans-serif;
        }

        .font-text{
            font-family: "Montserrat", sans-serif;	
        }

        .d-block{
            display: flex;
            flex-direction: column;
        }

        
    </style>

    <body>
        <div class="logo">
            
        </div>
        <div class="d-block">
            <div class="box-middle">
                <h3>Bem vindo(a) ' . $nome . '!</h3>
            </div>
            <div class="box-middle">
            <p>Bem vindo(a) ao Portal Conecta. Aqui você vai encontrar tudo que você precisa para sua experiência na CPMH ser excelente.</p>
            <p>Seu cadastro está sendo avaliado por um dos nossos colaboradores e em breve você receberá mais detalhes para seu 1º acesso. Fique ligado! Nos vemos em breve!</p>
            </div>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;">
            <small class="font-text" style="color: gray;">&copy; Portal Conecta 2021</small>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;"></div>
    </body>

    </html>

    ';

    $destino = $userEmail;
    $assunto = "Bem Vindo(a) - Portal Conecta";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    mail($destino, $assunto, $arquivo, $headers);
}

function sendEmailNotificationCadastroAprovado($emailEnvio, $nomeEnvio, $usuarioEnvio)
{
    // Campo E-mail
    $arquivo = '
    <html>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500&display=swap" rel="stylesheet"> 
    <style>
        .box{
            
            padding: 10px 10px;
            display: flex;
            justify-content: center;
        }

        .box-middle{
            
            padding: 5px 5px;
            display: flex;
            justify-content: center;
        }

        h1{
            
            font-weight: 500px;
            font-family: "Montserrat", sans-serif;
            display: block;
        }

        h3{
            font-family: "Montserrat", sans-serif;
        }

        li{
            font-family: "Montserrat", sans-serif;
        }

        ul{
            list-style-type: none;
            text-align: center;
        }

        p{
            font-weight: 300px;
            font-family: "Montserrat", sans-serif;
        }

        .font-text{
            font-family: "Montserrat", sans-serif;	
        }

        .d-block{
            display: flex;
            flex-direction: column;
        }

        
    </style>
    
    <body>
        <div class="logo">
            
        </div>
        <div class="box">
            <h1>Cadastro Aprovado</h1>
        </div>
        <div class="d-block">
            <div class="box-middle">
                <h3>Olá ' . $nomeEnvio . '!</h3>
            </div>
            <div class="box-middle">
                <p>BEM VINDO AO PORTAL CONECTA!</p>
                <p>Já está tudo pronto para seu 1º acesso no Portal Conecta. Por favor, entre no site dev.conecta.cpmhdigital.com.br e efetue o login com seu usuário
                 <b>' . $usuarioEnvio . ' e a senha criada no momento do cadastro.</b></p>
                
                <p>Caso tenha alguma dificuldade, entre em contato com nosso suporte pelo e-mail negocios@cpmh.com.br ou pelo número +55(61)999468880.</p>
            </div>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;">
            <small class="font-text" style="color: gray;">&copy; Portal Conecta 2021</small>
        </div>

        <div class="box-middle" style="padding-bottom: : 40px;"></div>
    </body>

    </html>

    ';

    $destino = $emailEnvio;
    $assunto = "Cadastro Aprovado - Smilefix";

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";


    mail($destino, $assunto, $arquivo, $headers);
}

//Configurações de Cadastro
function addEstado($conn, $nome, $abrev)
{
    $sql = "INSERT INTO estados (ufNomeExtenso, ufAbreviacao) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $abrev);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteEstado($conn, $id)
{
    $sql = "DELETE FROM estados WHERE ufId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addCadin($conn, $nome, $codigo)
{
    $sql = "INSERT INTO tipocadastrointerno (tpcadinNome, tpcadinCodCadastro) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $codigo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteCadin($conn, $id)
{
    $sql = "DELETE FROM tipocadastrointerno WHERE tpcadinId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addCadex($conn, $nome, $codigo)
{
    $sql = "INSERT INTO tipocadastroexterno (tpcadexNome, tpcadexCodCadastro) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $codigo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteCadex($conn, $id)
{
    $sql = "DELETE FROM tipocadastroexterno WHERE tpcadexId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addEtapaOs($conn, $nome)
{
    $sql = "INSERT INTO etapasos (etapaNome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteEtapaOs($conn, $id)
{
    $sql = "DELETE FROM etapasos WHERE etapaId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addStatusOs($conn, $nome, $posicao)
{
    $sql = "INSERT INTO statusos (stNome, stPosicao) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $posicao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteStatus($conn, $id)
{
    $sql = "DELETE FROM statusos WHERE stId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

function addDepartamento($conn, $nome)
{
    $sql = "INSERT INTO departamento (nome) VALUES (?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercadastro?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercadastro");
    exit();
}

function deleteDepartamento($conn, $id)
{
    $sql = "DELETE FROM departamento WHERE id='$id';";

    mysqli_query($conn, $sql);
    header("location: gercadastro");
    exit();
}

//Representante
function addUfRep($conn, $rep, $user, $email, $fone, $uf, $estado, $regiao)
{
    $sql = "INSERT INTO representantes (repNome, repUid, repFone, repEmail, repUF, repNomeUF, repRegião) VALUES (?,?,?,?,?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../representantes?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssssss", $rep, $user, $fone, $email, $uf, $estado, $regiao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../representantes");
    exit();
}

function deleteEstadoRep($conn, $id)
{
    $sql = "DELETE FROM representantes WHERE repID='$id';";

    mysqli_query($conn, $sql);
    header("location: representantes");
    exit();
}

//Configurações de Edição Proposta

function addstatuscomercial($conn, $nome, $indexFluxo)
{
    $sql = "INSERT INTO statuscomercial (stcomNome, stcomIndiceFluxo) VALUES (?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../gercomercial?error=stmfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $indexFluxo);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../gercomercial");
    exit();
}

function deleteComercial($conn, $id)
{
    $sql = "DELETE FROM statuscomercial WHERE stcomId='$id';";

    mysqli_query($conn, $sql);
    header("location: gercomercial");
    exit();
}

function extrairNomeUsuario($email)
{
    // Encontra a posição do caractere "@" no email
    $posicao_arroba = strpos($email, '@');

    // Verifica se o "@" foi encontrado e extrai o nome de usuário
    if ($posicao_arroba !== false) {
        return substr($email, 0, $posicao_arroba);
    } else {
        // Se o "@" não for encontrado, retorna falso ou lança uma exceção, dependendo dos requisitos
        return false; // ou throw new Exception("Email inválido!");
    }
}

function geralSendEmailNotification($destino, $assunto, $arquivo, $returnTrue, $returnFalse)
{

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $nome_remetente = 'Sistemas Fábrica';
    $email_remetente = 'admin@fabrica.cpmh.com.br';
    $headers .= 'From: ' . $nome_remetente . ' <' . $email_remetente . '>' . "\r\n";
    $headers .= 'Reply-To: admin@fabrica.cpmh.com.br' . "\r\n";
    $headers .= 'X-Priority: 1' . "\r\n"; // Alta prioridade
    $headers .= 'Importance: High' . "\r\n"; // Alta importância

    $enviaremail = mail($destino, $assunto, $arquivo, $headers);
    if ($enviaremail) {
        header($returnTrue);
    } else {
        header($returnFalse);
    }
}

function sendEmailNotificationNewAccount($username, $pwd, $email)
{
    $arquivo = '<!DOCTYPE html>
        <html lang="pt-br">
        
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Bem vindo ao Sistema Fábrica!</title>
            <style>
                /* Estilos para tornar o email mais atraente */
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f4f4f4;
                    margin: 0;
                    padding: 0;
                }
        
                .container {
                    max-width: 600px;
                    margin: 20px auto;
                    padding: 20px;
                    background-color: #EDEDED;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
        
                h1,
                h3 {
                    text-align: start;
                    padding-top: 0;
                    margin-top: 0;
                }
        
                h3 {
                    color: rgb(0, 212, 111);
                }
        
                a {
                    color: #fff;
                }
        
                .btn-container {
                    text-align: center;
                }
        
                .btn {
                    display: inline-block;
                    background-color: rgb(0, 212, 111);
                    color: #fff !important;
                    text-decoration: none;
                    padding: 10px 20px;
                    border-radius: 5px;
                    margin-top: 20px;
                    font-weight: bold;
                }
        
                img {
                    width: 180px;
                    margin: 0;
                    padding: 0;
                }
        
                .d-flex {
                    display: flex;
                    margin: 0;
                    padding: 0;
                }
        
                .justify-content-center {
                    justify-content: center;
                }
        
                .justify-content-around {
                    justify-content: space-around;
                }
        
                .align-items-center {
                    align-items: center;
                }
        
            </style>
        </head>
        
        <body>
        <div class="container">              
        
        <p>Olá! Você foi convidado a se juntar ao <strong>Sistema Fábrica</strong>. Nele você terá acesso a criação de OS e lista de prioridades para execução do seu trabalho.</p>

        <p>
            <strong>Usuário: </strong> ' . $username . '<br>
            <strong>Senha: </strong> ' . $pwd . '
        </p>
        
        <div class="btn-container">
            <a href="http://fabrica.cpmh.com.br/" class="btn">Entar no sistema</a>
        </div>
        <p>Att,</p>
        <p>Equipe de Desenvolvimento</p>
    </div>
        </body>
        
        </html>';

    $assunto = "Bem vindo ao Sistema da Fábrica";

    $returnTrue = "location: ../cadastro?error=none";
    $returnFalse = "location: ../cadastro?error=emailfailed";

    geralSendEmailNotification($email, $assunto, $arquivo, $returnTrue, $returnFalse);
}

function cleanString($string)
{
    // 1. Remover acentos
    $string = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $string);

    // 2. Converter para minúsculas
    $string = strtolower($string);

    // 3. Remover caracteres especiais
    $string = preg_replace('/[^a-z0-9]/', '', $string);

    return $string;
}

function getPrzEntrega($pedID)
{
    // $url = 'http://localhost/conecta/conecta/api/pedido?r=prz&id='.$pedID;
    $url = 'https://conecta.cpmhdigital.com.br/api/pedido?r=prz&id=' . $pedID;
    $json_data = file_get_contents($url);
    $prz = json_decode($json_data, true);


    return $prz;
}

function dateFormat($data)
{

    $dataRaw = explode(" ", $data);
    $newData = $dataRaw[0];

    $newData = explode("-", $newData);

    $res = $newData[2] . "/" . $newData[1] . "/" . $newData[0];

    return $res;
}

function hourFormat($hora)
{
    $horaRaw = explode(":", $hora);
    $res = $horaRaw[0] . ":" . $horaRaw[1];

    return $res;
}

function dateFormatByHifen($data)
{
    $dataRaw = explode("-", $data);
    $res = $dataRaw[2] . "/" . $dataRaw[1] . "/" . $dataRaw[0];

    return $res;
}

function dateAndHourFormat($data)
{
    $dataRaw = explode(" ", $data);

    $data = $dataRaw[0];
    $data = dateFormatByHifen($data);

    $hora = $dataRaw[1];
    $hora = hourFormat($hora);

    $res = $data . " " . $hora;

    return $res;
}

function getMonthNumber($conn, $data)
{

    $data = explode("-", $data);
    $month = $data[1];

    return $month;
}

function getMonthName($conn, $month)
{

    $sql = "SELECT * FROM `mesesano` WHERE mesNum = '" . $month . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $monthName = $row["mesNome"];
    }

    return $monthName;
}

function getMonthAbrv($conn, $month)
{

    $sql = "SELECT * FROM `mesesano` WHERE mesNum = '" . $month . "';";
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $monthAbrv = $row["mesAbrv"];
    }

    return $monthAbrv;
}

function hoje()
{
    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    $hoje = $dt->format("Y-m-d");
    // $horaAtual = $dt->format("H:i:s");

    // $thisMonth = date('m');
    // $thisYear = date('Y');
    // $thisDay = date('d');
    // $hoje = $thisYear . "-" . $thisMonth . "-" . $thisDay;

    return $hoje;
}

function agora()
{

    date_default_timezone_set('UTC');
    $dtz = new DateTimeZone("America/Sao_Paulo");
    $dt = new DateTime("now", $dtz);
    // $hoje = $dt->format("Y-m-d");
    $thisHour = $dt->format("H:i:s");
    // $thisHour = date("H:i:s");

    return $thisHour;
}

function novaEtapa($conn, $nome, $parametro1, $parametro2, $iterev)
{
    $sqlProd = "INSERT INTO etapa (nome, parametro1, parametro2, iterev) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../config_etapas?error=stmtfailedaddconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $nome, $parametro1, $parametro2, $iterev);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editarEtapa($conn, $id, $nome, $parametro1, $parametro2, $iterev)
{
    $sql = "UPDATE etapa SET nome= ?, parametro1= ?, parametro2= ?, iterev= ? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $nome, $parametro1, $parametro2, $iterev, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteEtapa($conn, $id)
{
    $sql = "DELETE FROM etapa WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_etapas?error=stmtfaileddltconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getNomeEtapa($conn, $id)
{
    $sql = "SELECT nome FROM etapa WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_fluxo?error=stmtfailedgetnomefluxo");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['nome'];
    } else {
        return null;
    }

    mysqli_stmt_close($stmt);
}

function novaFluxo($conn, $nome)
{
    $sqlProd = "INSERT INTO fluxo (nome) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../config_fluxo?error=stmtfailedaddconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editarFluxo($conn, $id, $nome)
{
    $sql = "UPDATE fluxo SET nome= ? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteFluxo($conn, $id)
{
    $sql = "DELETE FROM fluxo WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_fluxo?error=stmtfaileddltconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getNomeFluxo($conn, $id)
{
    $sql = "SELECT nome FROM fluxo WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_fluxo?error=stmtfailedgetnomefluxo");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['nome'];
    } else {
        return null;
    }

    mysqli_stmt_close($stmt);
}

function novaEtapaEmFluxo($conn, $idfluxo, $idetapa, $duracao)
{
    $ordem = intval(ultimoNumeroFluxo($conn, $idfluxo)) + 1;

    $sqlProd = "INSERT INTO etapa_fluxo (idfluxo, idetapa, ordem, duracao) VALUES (?,?,?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../config_fluxo?error=stmtfailedaddconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssss", $idfluxo, $idetapa, $ordem, $duracao);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function ultimoNumeroFluxo($conn, $idfluxo)
{
    $sql = "SELECT COUNT(idetapa) as total_etapas FROM etapa_fluxo WHERE idfluxo = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_fluxo?error=stmtfailedcount");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $idfluxo);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['total_etapas'];
    } else {
        return null;
    }

    mysqli_stmt_close($stmt);
}

function novaSetor($conn, $nome)
{
    $sqlProd = "INSERT INTO setor (nome) VALUES (?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../config_setores?error=stmtfailedaddconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function editarSetor($conn, $id, $nome)
{
    $sql = "UPDATE setor SET nome= ? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $nome, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteSetor($conn, $id)
{
    $sql = "DELETE FROM setor WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_setores?error=stmtfaileddltconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function getNomeSetor($conn, $id)
{
    $sql = "SELECT nome FROM setor WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_setores?error=stmtfailedgetnomesetor");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['nome'];
    } else {
        return null;
    }

    mysqli_stmt_close($stmt);
}

function novaEtapaEmSetor($conn, $idsetor, $idetapa)
{
    $ordem = intval(ultimoNumeroSetor($conn, $idsetor)) + 1;

    $sqlProd = "INSERT INTO setor_etapa (idsetor, idetapa) VALUES (?,?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        header("location: ../config_setores?error=stmtfailedaddconsulta");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $idsetor, $idetapa);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function ultimoNumeroSetor($conn, $idsetor)
{
    $sql = "SELECT COUNT(idetapa) as total_etapas FROM setor_etapa WHERE idsetor = ?;";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../config_setores?error=stmtfailedcount");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "i", $idsetor);
    mysqli_stmt_execute($stmt);
    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['total_etapas'];
    } else {
        return null;
    }

    mysqli_stmt_close($stmt);
}

function editEtapaEmSetor($conn, $id, $idetapa)
{
    $sql = "UPDATE setor_etapa SET idetapa=? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $idetapa, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function deleteEtapaEmSetor($conn, $id, $idsetor)
{
    // Iniciar transação
    mysqli_begin_transaction($conn);

    try {
        // Obter idsetor e ordem da etapa a ser deletada
        $sql = "SELECT idsetor FROM setor_etapa WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("Erro ao preparar a consulta para obter idsetor e ordem");
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $idsetor = $row['idsetor'];
            $ordem = $row['id'];
        } else {
            throw new Exception("Etapa não encontrada");
        }

        mysqli_stmt_close($stmt);

        // Deletar a etapa
        $sqlDelete = "DELETE FROM setor_etapa WHERE id = ?;";
        $stmtDelete = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtDelete, $sqlDelete)) {
            throw new Exception("Erro ao preparar a consulta para deletar a etapa");
        }

        mysqli_stmt_bind_param($stmtDelete, "i", $id);
        mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);

        // Commit da transação
        mysqli_commit($conn);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conn);
        header("location: ../config_setores?error=" . $e->getMessage());
        exit();
    }
}

function arrayIdEtapas($conn, $idfluxo)
{
    $sql = "SELECT *
    FROM etapa_fluxo
    WHERE idfluxo = ?
    ORDER BY ordem;";

    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $idfluxo);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);
    $result = [];
    while ($row = mysqli_fetch_array($resultData)) {
        array_push($result, $row["id"]);
    }

    return $result;

    mysqli_stmt_close($stmt);
}

function getposicaofromidstatus($conn, $id)
{
    $sql = "SELECT * FROM etapa_fluxo WHERE id = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $id);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['ordem'];
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function trocarposicaostatus($conn, $id, $outro)
// somarposicao($conn, $id, $posicao)
{

    $posicaoatual = getposicaofromidstatus($conn, $id);
    $posicaoproximo = getposicaofromidstatus($conn, $outro);

    // echo "posicaoatual: " . $posicaoatual . "<br>";
    // echo "posicaoproximo: " . $posicaoproximo . "<br>";
    // exit();

    $sql = "UPDATE etapa_fluxo SET ordem=? WHERE id=? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $posicaoproximo, $id);
    mysqli_stmt_execute($stmt);

    $sql = "UPDATE etapa_fluxo SET ordem=? WHERE id=? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ss", $posicaoatual, $outro);
    mysqli_stmt_execute($stmt);


    mysqli_stmt_close($stmt);
}

function editEtapaEmFluxo($conn, $id, $idetapa, $duracao)
{
    $sql = "UPDATE etapa_fluxo SET idetapa=?, duracao=? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $idetapa, $duracao, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// function deleteEtapaEmFluxo($conn, $id)
// {
//     $sql = "DELETE FROM etapa_fluxo WHERE id = ? ";
//     $stmt = mysqli_stmt_init($conn);


//     if (!mysqli_stmt_prepare($stmt, $sql)) {
//         header("location: ../config_fluxo?error=stmtfaileddltconsulta");
//         exit();
//     }

//     mysqli_stmt_bind_param($stmt, "s", $id);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);
// }

function deleteEtapaEmFluxo($conn, $id)
{
    // Iniciar transação
    mysqli_begin_transaction($conn);

    try {
        // Obter idfluxo e ordem da etapa a ser deletada
        $sql = "SELECT idfluxo, ordem FROM ETAPA_FLUXO WHERE id = ?;";
        $stmt = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmt, $sql)) {
            throw new Exception("Erro ao preparar a consulta para obter idfluxo e ordem");
        }

        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultData = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($resultData)) {
            $idfluxo = $row['idfluxo'];
            $ordem = $row['ordem'];
        } else {
            throw new Exception("Etapa não encontrada");
        }

        mysqli_stmt_close($stmt);

        // Deletar a etapa
        $sqlDelete = "DELETE FROM ETAPA_FLUXO WHERE id = ?;";
        $stmtDelete = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtDelete, $sqlDelete)) {
            throw new Exception("Erro ao preparar a consulta para deletar a etapa");
        }

        mysqli_stmt_bind_param($stmtDelete, "i", $id);
        mysqli_stmt_execute($stmtDelete);
        mysqli_stmt_close($stmtDelete);

        // Atualizar a ordem das etapas subsequentes
        $sqlUpdate = "UPDATE ETAPA_FLUXO SET ordem = ordem - 1 WHERE idfluxo = ? AND ordem > ?;";
        $stmtUpdate = mysqli_stmt_init($conn);

        if (!mysqli_stmt_prepare($stmtUpdate, $sqlUpdate)) {
            throw new Exception("Erro ao preparar a consulta para atualizar as ordens");
        }

        mysqli_stmt_bind_param($stmtUpdate, "ii", $idfluxo, $ordem);
        mysqli_stmt_execute($stmtUpdate);
        mysqli_stmt_close($stmtUpdate);

        // Commit da transação
        mysqli_commit($conn);
    } catch (Exception $e) {
        // Rollback da transação em caso de erro
        mysqli_rollback($conn);
        header("location: ../config_fluxo?error=" . $e->getMessage());
        exit();
    }
}


function hashItemNatural($id)
{
    $random = rand() * 7;
    $idhashed = $id * $random / 7;
    return $idhashed . "y" . $random;
}

function deshashItemNatural($hash)
{
    $exploded = explode("y", $hash);
    $hash = $exploded[0];
    $encryption_key = $exploded[1];
    $id = $hash * 7 / $encryption_key;
    return $id;
}

function diasFaltandoParaData($dataReferencia)
{
    // Definir o timezone para São Paulo
    date_default_timezone_set('America/Sao_Paulo');

    // Obter a data atual
    $dataAtual = new DateTime();
    $dataAtual->setTime(0, 0); // Resetar a hora para comparar apenas as datas

    // Criar um objeto DateTime para a data de referência
    $dataRef = DateTime::createFromFormat('Y-m-d', $dataReferencia);

    if (!$dataRef) {
        return "Formato de data inválido. Use o formato Y-m-d.";
    }

    $dataRef->setTime(0, 0); // Resetar a hora para comparar apenas as datas

    // Verificar se a data de referência já passou
    if ($dataRef < $dataAtual) {
        return 0;
    }

    // Contar dias úteis
    $diasUteis = 0;
    $dataAtualClone = clone $dataAtual; // Clonar para não modificar o original

    while ($dataAtualClone < $dataRef) {
        // Incrementar a data atual em um dia
        $dataAtualClone->modify('+1 day');

        // Verificar se o dia não é sábado (6) ou domingo (0)
        if ($dataAtualClone->format('N') < 6) {
            $diasUteis++;
        }
    }

    return $diasUteis;
}



function diasDentroFluxo($conn, $fluxo)
{
    $ret = mysqli_query($conn, "SELECT * FROM etapa_fluxo WHERE idfluxo = '{$fluxo}' ORDER BY ordem ASC ;");

    $contagemDias = 0;
    while ($row = mysqli_fetch_array($ret)) {
        $duracao = $row["duracao"];

        $contagemDias = $contagemDias + $duracao;
        if (floatval($duracao) == 1) {
            $s = "dia";
        } else {
            $s = "dias";
        }
    }

    return $contagemDias;
}

function buscarFluxoPorProduto($conn, $produto)
{
    $fluxo = '';

    // Preparar a consulta SQL
    $stmtFluxo = $conn->prepare("SELECT id FROM fluxo WHERE nome LIKE CONCAT('%', ?, '%') LIMIT 1");

    // Verificar se a preparação da declaração foi bem-sucedida
    if ($stmtFluxo === false) {
        return null;
    }


    // Vincular o parâmetro
    $stmtFluxo->bind_param("s", $produto);

    // Executar a declaração
    $stmtFluxo->execute();

    // Vincular o resultado
    $stmtFluxo->bind_result($fluxo);

    // Buscar o resultado
    $stmtFluxo->fetch();

    // Fechar a declaração
    $stmtFluxo->close();

    // Retornar o ID do fluxo
    return $fluxo;
}

function inserirPedido($conn, $projetista, $dr, $pac, $rep, $pedido, $dt, $produto, $dataEntrega, $fluxo, $lote, $cdgprod, $qtds, $descricao, $diasparaproduzir)
{
    // Preparar a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO pedidos (projetista, dr, pac, rep, pedido, dt, produto, dataEntrega, fluxo, lote, cdgprod, qtds, descricao, diasparaproduzir) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação da declaração foi bem-sucedida
    if ($stmt === false) {
        return ["status" => "error", "message" => "Erro ao preparar a declaração!"];
    }

    // Vincular os parâmetros
    $stmt->bind_param("ssssssssssssss", $projetista, $dr, $pac, $rep, $pedido, $dt, $produto, $dataEntrega, $fluxo, $lote, $cdgprod, $qtds, $descricao, $diasparaproduzir);

    // Executar a declaração
    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "Pedido inserido com sucesso!"];
    } else {
        $response = ["status" => "error", "message" => "Erro ao inserir o pedido!"];
    }

    // Fechar a declaração
    $stmt->close();

    // Retornar a resposta
    return $response;
}

function inserirPedidoSimples($conn, $dr, $pac, $nped, $dtcriacao, $fluxo, $lote, $dataEntrega, $diasparaproduzir, $obs)
{
    // Preparar a consulta SQL para inserção
    $stmt = $conn->prepare("INSERT INTO pedidos (dr, pac, pedido, dt, fluxo, lote, dataEntrega, diasparaproduzir, obs) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Verificar se a preparação da declaração foi bem-sucedida
    if ($stmt === false) {
        return ["status" => "error", "message" => "Erro ao preparar a declaração!"];
    }

    // Vincular os parâmetros
    $stmt->bind_param("sssssssss", $dr, $pac, $nped, $dtcriacao, $fluxo, $lote, $dataEntrega, $diasparaproduzir, $obs);

    // Executar a declaração
    if ($stmt->execute()) {
        $response = ["status" => "success", "message" => "Pedido inserido com sucesso!"];
    } else {
        $response = ["status" => "error", "message" => "Erro ao inserir o pedido!"];
    }

    // Fechar a declaração
    $stmt->close();

    // Retornar a resposta
    return $response;
}

function reduzirString($string, $quantidadeCaracteres)
{
    // Verificar se a quantidade de caracteres é válida
    if ($quantidadeCaracteres < 0) {
        return "Quantidade de caracteres inválida.";
    }

    // Verificar se a string precisa ser truncada
    if (strlen($string) > $quantidadeCaracteres) {
        return substr($string, 0, $quantidadeCaracteres);
    }

    // Retornar a string original se não precisar ser truncada
    return $string;
}

function updateFluxoPedido($conn, $id, $fluxo, $lote, $nacinter, $taxa_extra)
{

    $sql = "UPDATE pedidos SET fluxo= ?, lote= ?, nacional_internacional= ?, taxa_extra= ? WHERE id = ? ";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../avaliar-caso?id=" . $casoId . "&error=stmtfailedabas");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "sssss", $fluxo, $lote, $nacinter, $taxa_extra, $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

function novaRealizacaoProducao($conn, $idPedido, $idFluxo, $numOrdem, $idEtapa, $idStatus, $dataRealizacao)
{
    // Instrução SQL para inserir dados na tabela realizacaoproducao
    $sqlProd = "INSERT INTO realizacaoproducao (idPedido, idFluxo, numOrdem, idEtapa, idStatus, dataRealizacao) VALUES (?, ?, ?, ?, ?, ?);";

    // Inicializa uma declaração preparada
    $stmt = mysqli_stmt_init($conn);

    // Verifica se a declaração preparada foi bem-sucedida
    if (!mysqli_stmt_prepare($stmt, $sqlProd)) {
        // Redireciona para uma página de erro em caso de falha
        header("location: ../config_producao?error=stmtfailedaddrealizacao");
        exit();
    }

    // Liga os parâmetros à declaração preparada
    mysqli_stmt_bind_param($stmt, "iiiiis", $idPedido, $idFluxo, $numOrdem, $idEtapa, $idStatus, $dataRealizacao);

    // Executa a declaração preparada
    mysqli_stmt_execute($stmt);

    // Fecha a declaração preparada
    mysqli_stmt_close($stmt);
}

function obterEtapasPorFluxo($conn, $idfluxo)
{
    // Instrução SQL para selecionar as etapas com base no idfluxo
    $sql = "SELECT idetapa, ordem, duracao FROM etapa_fluxo WHERE idfluxo = ? ORDER BY ordem asc;";

    // Inicializa uma declaração preparada
    $stmt = mysqli_stmt_init($conn);

    // Verifica se a declaração preparada foi bem-sucedida
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Redireciona para uma página de erro em caso de falha
        // header("location: ../config_etapa_fluxo?error=stmtfailed");
        exit();
    }

    // Liga o parâmetro à declaração preparada
    mysqli_stmt_bind_param($stmt, "i", $idfluxo);

    // Executa a declaração preparada
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da execução da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Inicializa o array para armazenar as etapas
    $etapas = array();

    // Itera sobre o resultado e popula o array
    while ($row = mysqli_fetch_assoc($result)) {
        $etapas[] = array(
            'idetapa' => $row['idetapa'],
            'ordem' => $row['ordem'],
            'duracao' => $row['duracao']
        );
    }

    // Fecha a declaração preparada
    mysqli_stmt_close($stmt);

    // Retorna o array com as etapas
    return $etapas;
}

function dataReferenciaPedido($conn, $id)
{
    // Instrução SQL para selecionar a data 'dt' do pedido com base no 'id'
    $sql = "SELECT dt FROM pedidos WHERE id = ?;";

    // Inicializa uma declaração preparada
    $stmt = mysqli_stmt_init($conn);

    // Verifica se a declaração preparada foi bem-sucedida
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Redireciona para uma página de erro em caso de falha
        header("location: ../config_pedidos?error=stmtfailed");
        exit();
    }

    // Liga o parâmetro à declaração preparada
    mysqli_stmt_bind_param($stmt, "i", $id);

    // Executa a declaração preparada
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da execução da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se um registro foi encontrado
    if ($row = mysqli_fetch_assoc($result)) {
        // Retorna a data 'dt' do pedido
        $data = $row['dt'];
    } else {
        // Se nenhum registro foi encontrado, define a data como null
        $data = null;
    }

    // Fecha a declaração preparada
    mysqli_stmt_close($stmt);

    // Retorna a data 'dt'
    return $data;
}

function inserirLogAtividade($conn, $idRealizacaoProducao, $idEtapa, $idUsuario, $idStatus, $data, $hora)
{
    $sql = "INSERT INTO log_atividades_producao (idRealizacaoProducao, idEtapa, idUsuario, idStatus, data, hora) VALUES (?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // header("location: ../your_redirect_page.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iiiiss", $idRealizacaoProducao, $idEtapa, $idUsuario, $idStatus, $data, $hora);
    mysqli_stmt_execute($stmt);
    // mysqli_stmt_close($stmt);
}

function inserirTempoCorrido($conn, $idPedido, $idEtapa, $tempoCorrido)
{
    $sql = "INSERT INTO tempo_corrido (idPedido, idEtapa, tempoCorrido) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../your_redirect_page.php?error=stmtfailed");
        exit();
    }

    mysqli_stmt_bind_param($stmt, "iis", $idPedido, $idEtapa, $tempoCorrido);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}


function iniciarAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $status, $idPedido)
{

    $sql = "UPDATE realizacaoproducao SET idStatus='$status' WHERE id='$idR'";

    $userPerm = getUserPermission($conn, $user);
    if (mysqli_query($conn, $sql)) {
        if ($userPerm != "3COL") {
            header("location: visualizarpedido?id=" . $idPedido . "&error=stmtfailed");
        } else {
            header("location: dash");
        }
    }

    inserirLogAtividade($conn, $idR, $etapa, $user, $status, $hoje, $agora);

    mysqli_close($conn);
}

function pausarAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $status, $idPedido)
{

    $sql = "UPDATE realizacaoproducao SET idStatus='$status' WHERE id='$idR'";

    $userPerm = getUserPermission($conn, $user);
    if (mysqli_query($conn, $sql)) {
        if ($userPerm != "3COL") {
            header("location: visualizarpedido?id=" . $idPedido . "&error=stmtfailed");
        } else {
            header("location: dash");
        }
    }

    inserirLogAtividade($conn, $idR, $etapa, $user, $status, $hoje, $agora);

    mysqli_close($conn);
}

function concluirAtividadeProd($conn, $idR, $user, $etapa, $hoje, $agora, $status, $idPedido)
{
    $sql = "UPDATE realizacaoproducao SET idStatus='$status' WHERE id='$idR'";

    $userPerm = getUserPermission($conn, $user);
    if (mysqli_query($conn, $sql)) {
        if ($userPerm != "3COL") {
            header("location: visualizarpedido?id=" . $idPedido . "&error=stmtfailed");
        } else {
            header("location: dash");
        }
    }

    inserirLogAtividade($conn, $idR, $etapa, $user, $status, $hoje, $agora);

    mysqli_close($conn);
}

function aprovAtividadeQuali($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido)
{
    $statusAprov = 5;
    $sql = "UPDATE realizacaoproducao SET idStatus='$statusAprov' WHERE id='$idR'";

    $userPerm = getUserPermission($conn, $user);
    if (mysqli_query($conn, $sql)) {
        if ($userPerm != "3COL") {
            header("location: visualizarpedido?id=" . $idPedido . "&error=stmtfailed");
        } else {
            header("location: dash");
        }
    }

    inserirLogAtividade($conn, $idR, $etapa, $user, $statusAprov, $hoje, $agora);

    mysqli_close($conn);
}

function reprovAtividadeQuali($conn, $idR, $user, $etapa, $hoje, $agora, $idStatus, $idPedido)
{
    $statusAprov = 7;
    $sql = "UPDATE realizacaoproducao SET idStatus='$statusAprov' WHERE id='$idR'";

    $userPerm = getUserPermission($conn, $user);
    if (mysqli_query($conn, $sql)) {
        if ($userPerm != "3COL") {
            header("location: visualizarpedido?id=" . $idPedido . "&error=stmtfailed");
        } else {
            header("location: dash");
        }
    }

    $statusAprov = 6;
    inserirLogAtividade($conn, $idR, $etapa, $user, $statusAprov, $hoje, $agora);
    $statusAprov = 7;
    inserirLogAtividade($conn, $idR, $etapa, $user, $statusAprov, $hoje, $agora);

    mysqli_close($conn);
}


function getProximoStatus($statual, $type)
{
    $proximoStatus = '';

    switch ($statual) {
        case 1: // 'Aguardando'
            $proximoStatus = 2; //'Fazendo';
            break;
        case 2: // 'Fazendo'
            if ($type == 'pause') {
                $proximoStatus = 3; //'Pausado';
            } elseif ($type == 'check') {
                $proximoStatus = 4; //'Concluído';
            }
            break;
        case 3: // 'Pausado'
            $proximoStatus = 2; //'Fazendo';
            break;
        case 4: // 'Concluído'
            $proximoStatus = 4; //'Concluído'; // No next state mentioned
            break;
        case 5: // 'Aprovado'
            $proximoStatus = 5; //'Aprovado'; // No next state mentioned
            break;
        case 6: // 'Reprovado'
            $proximoStatus = 6; // 'Reprovado' // No next state mentioned
            break;
        case  7: //'Aguardando R.'
            $proximoStatus = 8; //'Fazendo R.';
            break;
        case  8: //'Fazendo R.'
            if ($type == 'pause') {
                $proximoStatus = 9; //'Pausado R.';
            } elseif ($type == 'check') {
                $proximoStatus = 10; //'Concluído R.';
            }
            break;
        case  9: //'Pausado R.'
            $proximoStatus = 8; //'Fazendo R.';
            break;
        case  10: //'Concluído R.'
            $proximoStatus = 10; //'Concluído R.'; // No next state mentioned
            break;
        default:
            // Handle unknown statuses
            $proximoStatus = 'Status desconhecido';
            break;
    }

    return $proximoStatus;
}

function getIdStatusByName($conn, $nome)
{
    $sql = "SELECT id FROM statusetapa WHERE nome = ?";
    $stmt = mysqli_stmt_init($conn);

    if (!mysqli_stmt_prepare($stmt, $sql)) {
        // Se houver um erro na preparação da declaração
        return "Erro na declaração SQL";
    }

    mysqli_stmt_bind_param($stmt, "s", $nome);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Se houver um resultado, retorna o ID
        return $row['id'];
    } else {
        // Se não houver nenhum resultado
        return "Nenhum ID encontrado para o status: $nome";
    }

    mysqli_stmt_close($stmt);
}

function contarEtapasConcluidas($conn, $idPedido)
{
    $count = 0;
    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    WHERE pd.id = $idPedido ORDER BY r.numOrdem ASC;";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];

        if ((($idStatus == 4) || ($idStatus == 10) || ($idStatus == 5) || ($idStatus == 6))) {
            $count++;
        }
    }

    return $count;
}

function contarEtapasAtrasadas($conn, $idPedido)
{
    $count = 0;
    $hoje = hoje();
    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    WHERE pd.id = $idPedido ORDER BY r.numOrdem ASC;";

    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function arrayEtapasAtrasadas($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            array_push($arrayRes, $row["idRealizacaoProducao"]);
        }
    }

    return $arrayRes;
}

function countEtapasAtrasadas($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function countEtapasAtrasadasToColaborador($conn, $etapas)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    WHERE r.idEtapa IN ($etapas)
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate < $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function arrayEtapasHoje($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            array_push($arrayRes, $row["idRealizacaoProducao"]);
        }
    }

    return $arrayRes;
}

function countEtapasHoje($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function countEtapasHojeToColaborador($conn, $etapas)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    WHERE r.idEtapa IN ($etapas)
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeDate) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function arrayEtapasAmanha($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeMaisUm) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            array_push($arrayRes, $row["idRealizacaoProducao"]);
        }
    }

    return $arrayRes;
}

function countEtapasAmanha($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeMaisUm) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function countEtapasAmanhaToColaborador($conn, $etapas)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id 
    WHERE r.idEtapa IN ($etapas)
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $dtRefDate = new DateTime($dtRef);
        $hojeDate = new DateTime($hoje);
        // Adiciona um dia à data de hoje
        $hojeMaisUm = clone $hojeDate;
        $hojeMaisUm->modify('+1 day');


        if (($dtRefDate == $hojeMaisUm) && (($idStatus != 4) && ($idStatus != 10) && ($idStatus != 5))) {
            $count++;
        }
    }

    return $count;
}

function getFirstAndLastName($fullName)
{
    // Divide o nome completo em partes usando espaço como delimitador
    $nameParts = explode(' ', trim($fullName));

    // Se houver apenas uma parte, retorna o próprio nome
    if (count($nameParts) == 1) {
        return $nameParts[0];
    }

    // Obtém a primeira e a última parte do nome
    $firstName = $nameParts[0];
    $lastName = $nameParts[count($nameParts) - 1];

    // Retorna o primeiro e o último nome concatenados com um espaço entre eles
    return $firstName . ' ' . $lastName;
}

function diasUteisAteHoje($data)
{
    // Convertendo a data de entrada e a data atual para objetos DateTime
    $dataInicial = new DateTime($data);
    $dataFinal = new DateTime();

    // Se a data inicial for maior que a data final, retorna 0
    if ($dataInicial > $dataFinal) {
        return 0;
    }

    // Calcula a diferença em dias entre as duas datas
    $intervalo = $dataInicial->diff($dataFinal);
    $diasTotais = $intervalo->days;

    $diasUteis = 0;

    // Itera pelos dias entre a data inicial e a data final
    for ($i = 0; $i <= $diasTotais; $i++) {
        // Verifica se o dia é útil (não é sábado nem domingo)
        $dataAtual = clone $dataInicial;
        $dataAtual->modify("+$i day");

        if ($dataAtual->format('N') < 6) {
            $diasUteis++;
        }
    }

    return $diasUteis;
}

function transformarArrayParaString($array)
{
    // Extrair apenas os valores da chave 'id'
    $ids = array_column($array, 'id');

    // Concatenar os valores em uma string separada por vírgula
    $stringIds = implode(',', $ids);

    return $stringIds;
}


function getUserPermission($conn, $user)
{
    $sql = "SELECT usersPerm FROM users WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        return $row['usersPerm'];
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getUserName($conn, $user)
{
    $sql = "SELECT usersName FROM users WHERE usersId = ?;";
    $stmt = mysqli_stmt_init($conn);
    $prepare = mysqli_stmt_prepare($stmt, $sql);


    if (!$prepare) {
        echo "Erro na preparação da declaração SQL: " . mysqli_stmt_error($stmt);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($resultData)) {
        $nome = $row["usersName"];
        $nome = getFirstAndLastName($nome);
        return $nome;
    } else {
        $result = false;
        return $result;
    }

    mysqli_stmt_close($stmt);
}

function getEtapaAtual($conn, $idPedido)
{
    // Consulta para obter o último idEtapa da tabela log_atividades_producao relacionado ao idPedido
    $sql = "
        SELECT 
            log.idEtapa AS idEtapa
        FROM 
            log_atividades_producao log
        JOIN 
            realizacaoproducao rp ON log.idRealizacaoProducao = rp.id
        WHERE 
            rp.idPedido = ?
        ORDER BY 
            log.data DESC, log.hora DESC
        LIMIT 1;
    ";

    // Preparar a consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "i", $idPedido);

    // Executar a consulta
    mysqli_stmt_execute($stmt);

    // Vincular os resultados da consulta
    mysqli_stmt_bind_result($stmt, $ultimoIdEtapa);

    // Buscar o resultado
    mysqli_stmt_fetch($stmt);

    // Fechar a declaração
    mysqli_stmt_close($stmt);

    // Verificar se o resultado é nulo
    if ($ultimoIdEtapa === null) {
        // Consulta para obter o primeiro idEtapa da tabela realizacaoproducao relacionado ao idPedido
        $sql = "
            SELECT 
                rp.idEtapa AS idEtapa
            FROM 
                realizacaoproducao rp
            WHERE 
                rp.idPedido = ?
            ORDER BY 
                rp.numOrdem ASC
            LIMIT 1;
        ";

        // Preparar a nova consulta
        $stmt = mysqli_prepare($conn, $sql);

        // Bind dos parâmetros
        mysqli_stmt_bind_param($stmt, "i", $idPedido);

        // Executar a nova consulta
        mysqli_stmt_execute($stmt);

        // Vincular os resultados da nova consulta
        mysqli_stmt_bind_result($stmt, $primeiroIdEtapa);

        // Buscar o resultado da nova consulta
        mysqli_stmt_fetch($stmt);

        // Fechar a declaração
        mysqli_stmt_close($stmt);

        // Retornar o primeiro idEtapa encontrado
        return $primeiroIdEtapa;
    }

    // Retornar o último idEtapa encontrado na primeira consulta
    return $ultimoIdEtapa;
}

function getRespEtapaAtual($conn, $idPedido, $etapaAtual)
{
    // Consulta para obter o idUsuario da tabela log_atividades_producao relacionado ao idPedido e idEtapa
    $sql = "
        SELECT 
            log.idUsuario AS idUsuario
        FROM 
            log_atividades_producao log
        JOIN 
            realizacaoproducao rp ON log.idRealizacaoProducao = rp.id
        WHERE 
            rp.idPedido = ? AND log.idEtapa = ?
        ORDER BY 
            log.data DESC, log.hora DESC
        LIMIT 1;
    ";

    // Preparar a consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "ii", $idPedido, $etapaAtual);

    // Executar a consulta
    mysqli_stmt_execute($stmt);

    // Vincular os resultados da consulta
    mysqli_stmt_bind_result($stmt, $idUsuario);

    // Buscar o resultado
    mysqli_stmt_fetch($stmt);

    // Fechar a declaração
    mysqli_stmt_close($stmt);

    if ($idUsuario === null) {
        $idUsuario = "N/A";
    } else {
        $idUsuario = getUserName($conn, $idUsuario);
    }

    // Retornar o resultado
    return $idUsuario;
}

function getProximaEtapa($conn, $idPedido, $etapaAtual)
{
    // Consulta para obter o id da próxima realizacao após a etapa atual
    $sql = "
        SELECT 
            rp.id
        FROM 
            realizacaoproducao rp
        WHERE 
            rp.idPedido = ? AND rp.idEtapa = ?
        ORDER BY 
            rp.numOrdem ASC
        LIMIT 1;
    ";

    // Preparar a consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Bind dos parâmetros
    mysqli_stmt_bind_param($stmt, "ii", $idPedido, $etapaAtual);

    // Executar a consulta
    mysqli_stmt_execute($stmt);

    // Vincular os resultados da consulta
    mysqli_stmt_bind_result($stmt, $proximaIdRealizacao);

    // Buscar o resultado da consulta
    mysqli_stmt_fetch($stmt);

    // Fechar a declaração
    mysqli_stmt_close($stmt);

    // Consulta para obter o idEtapa da próxima realização após a etapa atual
    $sql2 = "
        SELECT 
            rp.idEtapa AS idEtapa
        FROM 
            realizacaoproducao rp
        WHERE 
            rp.id = ?;
    ";

    // Preparar a segunda consulta
    $stmt2 = mysqli_prepare($conn, $sql2);

    $proximaIdRealizacao = intval($proximaIdRealizacao) + 1;
    // Bind do parâmetro
    mysqli_stmt_bind_param($stmt2, "i", $proximaIdRealizacao);

    // Executar a segunda consulta
    mysqli_stmt_execute($stmt2);

    // Vincular os resultados da segunda consulta
    mysqli_stmt_bind_result($stmt2, $proximaIdEtapa);

    // Buscar o resultado da segunda consulta
    mysqli_stmt_fetch($stmt2);

    // Fechar a segunda declaração
    mysqli_stmt_close($stmt2);

    // Retornar o próximo idEtapa encontrado
    return $proximaIdEtapa;
}


function arrayEtapasFazendo($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id
    WHERE r.idStatus = 2 OR r.idStatus = 8
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];


        array_push($arrayRes, $row["idRealizacaoProducao"]);
    }

    return $arrayRes;
}

function countEtapasFazendo($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id
    WHERE r.idStatus = 2 OR r.idStatus = 8
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $count++;
    }

    return $count;
}

function arrayEtapasPausado($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id
    WHERE r.idStatus = 3 OR r.idStatus = 9
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];


        array_push($arrayRes, $row["idRealizacaoProducao"]);
    }

    return $arrayRes;
}

function countEtapasPausado($conn)
{
    $count = 0;
    $hoje = hoje();

    $sql = "SELECT 
    r.id AS idRealizacaoProducao,
    r.numOrdem AS ordem,
    r.dataRealizacao AS dt,
    r.idEtapa AS idEtapa,
    e.nome AS nomeEtapa,
    s.nome AS nomeStatus,
    s.id AS idStatus,
    s.cor AS corStatus
    FROM pedidos AS pd 
    RIGHT JOIN realizacaoproducao AS r ON pd.id = r.idPedido 
    RIGHT JOIN etapa AS e ON r.idEtapa = e.id 
    RIGHT JOIN statusetapa AS s ON r.idStatus = s.id
    WHERE r.idStatus = 3 OR r.idStatus = 9
    ORDER BY r.numOrdem ASC;";

    $arrayRes = [];
    $ret = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_array($ret)) {
        $idStatus = $row["idStatus"];
        $dtRef = $row["dt"];

        $count++;
    }

    return $count;
}

function getAllSetorIDs($conn)
{
    $sql = "SELECT id FROM setor";
    $result = mysqli_query($conn, $sql);

    $ids = array();
    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $ids[] = $row['id'];
        }
    }

    return $ids;
}

function getSetorNameByID($conn, $id)
{
    $sql = "SELECT nome FROM setor WHERE id = ? ORDER BY id;";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nome);
    mysqli_stmt_fetch($stmt);

    mysqli_stmt_close($stmt);

    return $nome;
}

// Função para obter todos os idEtapa de um dado idSetor
function getEtapasBySetor($conn, $idSetor)
{
    $sql = "SELECT idetapa FROM setor_etapa WHERE idsetor = ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Verifica se a preparação foi bem-sucedida
    if ($stmt) {
        // Bind dos parâmetros
        mysqli_stmt_bind_param($stmt, "i", $idSetor);

        // Executar a consulta
        mysqli_stmt_execute($stmt);

        // Vincular os resultados da consulta
        mysqli_stmt_bind_result($stmt, $idEtapa);

        // Array para armazenar os resultados
        $etapas = array();

        // Buscar os resultados
        while (mysqli_stmt_fetch($stmt)) {
            $etapas[] = $idEtapa;
        }

        // Fechar a declaração
        mysqli_stmt_close($stmt);

        return $etapas;
    } else {
        // Retornar um array vazio ou lançar uma exceção se a preparação da consulta falhar
        return array();
    }
}

function getSetoresByUser($conn, $userId)
{
    // Define a consulta SQL
    $sql = "SELECT s.id FROM setor s 
            JOIN colaborador_etapas ce ON s.id = ce.idEtapa 
            WHERE ce.idUser = ?";

    // Prepara a consulta
    $stmt = mysqli_prepare($conn, $sql);

    // Faz a ligação dos parâmetros
    mysqli_stmt_bind_param($stmt, "i", $userId);

    // Executa a consulta
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Inicializa um array para armazenar os IDs dos setores
    $setores = [];

    // Itera sobre os resultados e adiciona os IDs ao array
    while ($row = mysqli_fetch_assoc($result)) {
        $setores[] = $row['id'];
    }

    // Fecha a declaração
    mysqli_stmt_close($stmt);

    // Retorna o array de IDs dos setores
    return $setores;
}

function subtrairDiasUteis($data, $dias)
{
    // Converte a data de dd/mm/yyyy para o formato Y-m-d
    $data = DateTime::createFromFormat('Y-m-d', $data);

    if (!$data) {
        return false; // Retorna false se a data não for válida
    }

    $contador = 0;

    // Loop para subtrair dias úteis
    while ($contador < $dias) {
        $data->modify('-1 day'); // Subtrai um dia

        // Verifica se é um dia útil (não sábado ou domingo)
        if ($data->format('N') < 6) {
            $contador++;
        }
    }

    // Retorna a data no formato dd/mm/yyyy
    return $data->format('d/m/Y');
}

//MODULO DE ATUALIZAR PRAZO COM TAXA EXTRA INICIO
// function receberDiasAntecipados($modalidade)
// {
//     switch ($modalidade) {
//         case 'SMARTMOLD':
//         case 'Implante Facial':
//         case 'Crânio':
//         case 'Fast CMF':
//         case 'Fastmold (PMMA)':
//             return 6;
//         case 'Crânio - Titânio':
//         case 'Crânio - PEEK':
//         case 'ATM':
//         case 'Reconstruções':
//         case 'Customlife':
//         case 'Ortognática sob medida':
//             return 12;
//         case 'Guias de buco':
//             return 3;
//         default:
//             return null;
//     }
// }

function somarDiasUteis($data, $dias)
{
    $data = new DateTime($data);
    $diasUteis = 0;

    while ($diasUteis < $dias) {
        $data->modify('+1 day');
        if ($data->format('N') < 6) { // 1-5 são dias úteis
            $diasUteis++;
        }
    }

    return $data->format('Y-m-d');
}

// function atualizarDataEntregaPedido($conn, $modalidade, $dataEntrega)
// {
//     // Receber dias antecipados
//     $dias = receberDiasAntecipados($modalidade);
//     if ($dias === null) {
//         throw new Exception("Modalidade inválida");
//     }

//     // Subtrair 20 dias úteis da data de entrega
//     $dataAceite = subtrairDiasUteis($dataEntrega, 20);

//     // Somar os dias úteis do prazo antecipado
//     $prazoAntecipado = somarDiasUteis($dataAceite, $dias);

//     // Atualizar no banco de dados
//     $sql = "UPDATE pedidos SET dataEntrega = ? WHERE produto = ?";
//     $stmt = mysqli_prepare($conn, $sql);
//     mysqli_stmt_bind_param($stmt, "ss", $prazoAntecipado, $modalidade);
//     mysqli_stmt_execute($stmt);
//     mysqli_stmt_close($stmt);

//     return $prazoAntecipado;
// }
//MODULO DE ATUALIZAR PRAZO COM TAXA EXTRA FIM

function getUltimaLinhaPedidos($conn)
{
    // Consulta SQL para obter a última linha inserida na tabela 'pedidos'
    $sql = "SELECT * FROM pedidos ORDER BY id DESC LIMIT 1";

    // Executa a consulta
    $result = mysqli_query($conn, $sql);

    // Verifica se houve resultados
    if (mysqli_num_rows($result) > 0) {
        // Retorna a última linha inserida
        return mysqli_fetch_assoc($result);
    } else {
        // Retorna null se não houver resultados
        return null;
    }
}

function getDepartamentoNome($conn, $idDep)
{
    // Define a consulta SQL
    $sql = "SELECT nome FROM departamento WHERE id = ?";

    // Prepara a consulta
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        // Caso a preparação falhe, retorne null
        return null;
    }

    // Faz a ligação dos parâmetros
    mysqli_stmt_bind_param($stmt, "i", $idDep);

    // Executa a consulta
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se houve resultados
    if (mysqli_num_rows($result) > 0) {
        // Retorna o nome do departamento
        $row = mysqli_fetch_assoc($result);
        return $row['nome'];
    } else {
        // Retorna null se não houver resultados
        return null;
    }
}

function inserirEtapasColaborador($conn, $userId, $etapas)
{
    foreach ($etapas as $idEtapa) {
        $sql = "INSERT INTO colaborador_etapas (idUser, idEtapa) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $userId, $idEtapa);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

function getLastUserId($conn)
{
    // Define a consulta SQL para obter o último ID da tabela users
    $sql = "SELECT MAX(usersId) as max_id FROM users";

    // Prepara a consulta
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        // Caso a preparação falhe, retorne null
        return null;
    }

    // Executa a consulta
    mysqli_stmt_execute($stmt);

    // Obtém o resultado da consulta
    $result = mysqli_stmt_get_result($stmt);

    // Verifica se houve resultados
    if ($row = mysqli_fetch_assoc($result)) {
        // Retorna o último ID (max_id) da tabela users
        return $row['max_id'];
    } else {
        // Retorna null se não houver resultados
        return null;
    }
}

function calcularTempoPassado($inicio, $fim) {
    // Convertendo as strings de tempo em objetos DateTime
    $inicioObj = DateTime::createFromFormat('H:i:s', $inicio);
    $fimObj = DateTime::createFromFormat('H:i:s', $fim);

    // Calculando a diferença entre os dois tempos
    $diferenca = $inicioObj->diff($fimObj);

    // Formatando a diferença para uma string legível
    $tempoPassado = $diferenca->format('%H horas, %I minutos e %S segundos');

    return $tempoPassado;
}

function agruparEtapas($array) {
    // Array para armazenar os tempos somados por etapa
    $etapas = [];

    // Itera sobre o array fornecido
    foreach ($array as $item) {
        $etapa = $item['Etapa'];
        $tempo = $item['Tempo'];

        // Verifica se a etapa já existe no array $etapas
        if (array_key_exists($etapa, $etapas)) {
            // Se existe, adiciona o tempo ao tempo existente da etapa
            $etapas[$etapa]['Tempo'] = somarTempos($etapas[$etapa]['Tempo'], $tempo);
        } else {
            // Se não existe, cria a entrada para a etapa com os atributos iniciais
            $etapas[$etapa] = [
                'Etapa' => $etapa,
                'Tempo' => $tempo,
                'Responsavel' => $item['Responsavel'],
                'parametro1' => $item['parametro1'],
                'parametro2' => $item['parametro2'],
                'iterev' => $item['iterev'],
            ];
        }
    }

    // Formata o resultado como um array de arrays associativos
    $resultado = array_values($etapas); // Remove as chaves e reindexa o array

    return $resultado;
}

// Função auxiliar para somar tempos no formato "H horas, I minutos e S segundos"
function somarTempos($tempo1, $tempo2) {
    // Função para converter o tempo em segundos
    function converterParaSegundos($tempo) {
        sscanf($tempo, "%d horas, %d minutos e %d segundos", $horas, $minutos, $segundos);
        return $horas * 3600 + $minutos * 60 + $segundos;
    }

    // Função para converter segundos de volta para o formato "H horas, I minutos e S segundos"
    function converterParaFormato($segundos) {
        $horas = floor($segundos / 3600);
        $segundos %= 3600;
        $minutos = floor($segundos / 60);
        $segundos %= 60;

        return sprintf("%02d horas, %02d minutos e %02d segundos", $horas, $minutos, $segundos);
    }

    // Converte os tempos para segundos
    $segundos1 = converterParaSegundos($tempo1);
    $segundos2 = converterParaSegundos($tempo2);

    // Soma os tempos em segundos
    $segundosTotal = $segundos1 + $segundos2;

    // Converte o resultado de volta para o formato esperado
    return converterParaFormato($segundosTotal);
}