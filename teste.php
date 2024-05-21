<?php
require_once 'includes/functions.inc.php';

$username = "vanespaiva";
$pwd = "123";
$destino = 'vanespaiva@gmail.com';

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

// echo $assunto;
// exit();

geralSendEmailNotification($destino, $assunto, $arquivo, $returnTrue, $returnFalse);
