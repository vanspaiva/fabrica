<?php
if (isset($_POST["update"])) {

    $id = addslashes($_POST["pedidoId"]);
    $fluxo = addslashes($_POST["fluxo"]);
    //receber user depois 

    require_once '../db/dbh.php';
    require_once 'functions.inc.php';

    updateFluxoPedido($conn, $id, $fluxo);
    // header("location: ../evolucaopcp?id=" . $id);

    //criar etapas 
    //redirecionar para pagina de acompanhamento desse pedido
} else {
    header("location: ../evolucaopcp");
    exit();
}
