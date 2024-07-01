<?php

    if (isset($_POST)) {

        require_once '../db/dbh.php';
        require_once 'functions.inc.php';

        $id_usuario = addslashes($_GET['id']);
        $setor = addslashes($_POST["setor"]);
        $area_adm = addslashes($_POST["area-adm"]);
        $data_exec = addslashes($_POST["dtexec"]);
        $periodo = addslashes($_POST["periodo"]);
        $responsavel = addslashes($_POST["responsavel"]);
    
        $services = [];
        foreach ($_POST as $key => $value) {
            if (strpos($key, 'srv') === 0) {
                $services[$key] = $value;
            }
        }
        foreach ($services as $key => $value) {
            unset($_POST[$key]);
        }
    
        $tipo_limpeza = implode("\n", $services);
        
        UpdateRegistro004($conn , $setor, $area_adm, $data_exec, $periodo, $responsavel, $tipo_limpeza, $id_usuario);
        
    }
    else{
        header('Location: ../showForm003.php');
        exit();
    }
    
    