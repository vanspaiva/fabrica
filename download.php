<?php
session_start();

if(!empty($_GET['file'])){
    $fileName  = basename($_GET['file']);
    $id  = $_GET['id'];
    $filePath  = "arquivos/".$id."/".$fileName;
    
    if(!empty($fileName) && file_exists($filePath)){
        //define header
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");
        
        //read file 
        readfile($filePath);
        exit;
    }
    else{
        echo "file not exit";
    }
}