<?php

    if (isset($_POST)) {

        require_once '../db/dbh.php';
        require_once 'functions.inc.php';
  
        $id_usuario = addslashes($_POST["idCriador"]);
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
    
        $tipo_limpeza = "";
    
        foreach ($services as $key) {
            $tipo_limpeza .= $key . "\n";
        }

        insertRegistroINF003($conn,$setor,$area_adm,$data_exec, $periodo, $responsavel, $id_usuario,$tipo_limpeza);

    }
    else{
        header('Location: ../showForm003.php');
        exit();
    }


