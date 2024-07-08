<?php

include_once "db/dbh.php";
include_once "includes/functions.inc.php";

$idfluxo = "17";

echo "<pre>";
print_r(obterEtapasPorFluxo($conn, $idfluxo));
echo "</pre>";