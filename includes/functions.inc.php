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

function createUser($conn, $name, $username, $email, $celular, $identificador, $uf, $pwd, $permission, $aprovacao)
{
    $sql = "INSERT INTO users (usersName, usersUid, usersEmail, usersCel, usersIdentificador, usersUf, usersPwd, usersPerm, usersAprov) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssssss", $name, $username, $email, $celular, $identificador, $uf, $hashedPwd, $permission, $aprovacao);
    mysqli_stmt_execute($stmt);


    sendEmailNotificationNewAccount($username, $pwd, $email);

    mysqli_stmt_close($stmt);
    exit();
}

function createNewUserAdm($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $pwd)
{

    $sql = "INSERT INTO users (usersName, usersUf, usersEmail, usersUid, usersCel, usersIdentificador, usersAprov, usersPerm, usersPwd) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../cadastro?error=stmtfailed");
        exit();
    }

    $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssssss", $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $hashedPwd);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../users?error=created");
    exit();
}

function editUser($conn, $nome, $uf, $email, $uid, $celular, $identificador, $aprov, $perm, $usersid)
{
    $sql = "UPDATE users SET usersName='$nome', usersUf='$uf', usersEmail='$email', usersUid='$uid', usersCel='$celular', usersIdentificador='$identificador', usersAprov='$aprov', usersPerm='$perm' WHERE usersId='$usersid'";


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

function editOs($conn, $osid, $status, $grau, $setor, $dtentrega, $dtrealentrega, $dtexecucao, $descricao, $lote, $nped, $obs, $user)
{
    $sql = "UPDATE ordenservico SET osSetor='$setor', osDescricao='$descricao', osLote='$lote', osNPed='$nped', osGrauUrgencia='$grau', osDtEntregaReal='$dtrealentrega', dtExecucao='$dtexecucao', osObs='$obs', osStatus='$status'  WHERE osId ='$osid'";

    if (mysqli_query($conn, $sql)) {
        header("location: ../lista-os?error=edit");
    } else {
        header("location: lista-os?error=stmtfailed");
    }

    logAtividade($conn, $osid, $status, $user);

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

    logAtividade($conn, $id, $status, $user);

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

    logAtividade($conn, $id, $status, $user);

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

    logAtividade($conn, $id, $status, $user);

    mysqli_close($conn);
}

function logAtividade($conn, $id, $status, $user)
{
    $sql = "INSERT INTO logatividades (logOsRef, logStatus, logUser) VALUES (?,?,?)";
    $stmt = mysqli_stmt_init($conn);


    if (!mysqli_stmt_prepare($stmt, $sql)) {

        exit();
    }

    mysqli_stmt_bind_param($stmt, "sss", $id, $status, $user);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    exit();
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

function getPrzEntrega($pedID){
    // $url = 'http://localhost/conecta/conecta/api/pedido?r=prz&id='.$pedID;
    $url = 'https://conecta.cpmhdigital.com.br/api/pedido?r=prz&id='.$pedID;
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