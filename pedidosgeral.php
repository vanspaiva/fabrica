<?php
include("php/head_tables.php");

if (isset($_SESSION["useruid"])) {

    // require_once 'db/dbh.php';
    // require_once 'includes/functions.inc.php';

    require_once 'db/dbhconecta.php';
    require_once 'includes/functionsconecta.php';

?>


    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main" class="font-montserrat">
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm" id="titulo-pag">
                        <h2 class="text-conecta" style="font-weight: 400;">Pedidos de <span style="font-weight: 800;"> Clientes</span></h2>
                        <hr style="border-color: #ee7624;">
                        <br>
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col">
                                    <table id="tableProp2" class="table table-striped table-advance table-hover bg-white rounded">
                                        <thead class="text-conecta">
                                            <tr>
                                                <th>Nº</th>
                                                <th>Data Chegada</th>
                                                <th>Fluxo</th>
                                                <th>Dias no Status</th>
                                                <th>Prev Entreg</th>
                                                <th>Empresa</th>
                                                <th>Dr(a)</th>
                                                <th>Paciente</th>

                                                <th>Usuário Criador</th>
                                                <th>Produto</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody style="background-color: white;">
                                            <?php
                                            // require_once 'includes/dbh.inc.php';
                                            $sql = "SELECT * FROM `pedido` RIGHT JOIN `propostas` ON `pedido`.pedPropRef = `propostas`.propId WHERE pedAndamento NOT LIKE '%FINALIZADO%';";

                                            $count = contarTamanhoTotal($conn_b, $sql);
                                            $sql = removerUltimoPontoEVirgula($sql);

                                            $pagina = isset($_GET['p']) ? intval($_GET['p']) : 1;
                                            $limite = 10;

                                            $offset = ($pagina - 1) * $limite;

                                            $page_number = ceil($count / $limite);
                                            $page_interval = 2;

                                            $sql .= " ORDER BY `pedido`.pedNumPedido DESC LIMIT {$limite} OFFSET $offset;";

                                            $ret = mysqli_query($conn_b, $sql);
                                            while ($row = mysqli_fetch_array($ret)) {


                                                $retFin = mysqli_query($conn_b, "SELECT * FROM aceiteproposta WHERE apropNumProp='" . $row['propId'] . "';");
                                                if (($retFin) && ($retFin->num_rows != 0)) {
                                                    $temFin = true;
                                                } else {
                                                    $temFin = false;
                                                }


                                                $pedID = $row['pedNumPedido'];
                                                $nomeFluxo = getNomeFluxoPed($conn_b, $pedID);
                                                $corFluxo = getCorFluxoPed($conn_b, $pedID);
                                                $contagemDias = getAndamentoForTableFluxoPed($conn_b, $pedID);

                                                $dataCompleta = $row['pedDtCriacaoPed'];
                                                if ($dataCompleta) {
                                                    $dataArray = explode(" ", $dataCompleta);
                                                    $data = dateFormat2($dataArray[0]);
                                                } else {
                                                    $data = '';
                                                }


                                                $status = $row['pedStatus'];

                                                $nomeStatus = getNomeFluxoPed($conn_b, $pedID);

                                                if (($nomeStatus == "Projeto Aceito") || ($nomeStatus == "Produção") || ($nomeStatus == "Projetando Produção")) {
                                                    $preventrega = getDataPrazoPosAceite2($conn_b, $pedID);
                                                } else {
                                                    $preventrega = "-";
                                                }


                                                //Cores Status TC
                                                if ($row['propStatusTC'] == "TC APROVADA") {
                                                    $moodStatus = "bg-success";
                                                    $colorText = "";
                                                } else {

                                                    if (strpos($row['propStatusTC'], 'TC REPROVADA') !== false) {
                                                        $moodStatus = "bg-danger";
                                                    } else {
                                                        $moodStatus = "bg-amarelo text-dark";
                                                    }
                                                }


                                                //Cores Status Comercial
                                                if (strpos($row['propStatus'], 'ANÁLISE') !== false) {
                                                    $moodStatusComercial = "bg-amarelo";
                                                } else {

                                                    if (strpos($row['propStatus'], 'ENVIADA') !== false) {
                                                        $moodStatusComercial = "bg-verde-claro";
                                                    } else {
                                                        if ($row['propStatus'] == 'APROVADO') {
                                                            $moodStatusComercial = "bg-verde text-white";
                                                        } else {
                                                            if (strpos($row['propStatus'], 'PEDIDO') !== false) {
                                                                $moodStatusComercial = "bg-roxo text-white";
                                                            } else {
                                                                if (strpos($row['propStatus'], 'CANCELADO') !== false) {
                                                                    $moodStatusComercial = "bg-vermelho text-white";
                                                                } else {
                                                                    if (strpos($row['propStatus'], 'COTADO') !== false) {
                                                                        $moodStatusComercial = "bg-rosa";
                                                                    } else {
                                                                        if (strpos($row['propStatus'], 'COTAR') !== false) {
                                                                            $moodStatusComercial = "bg-vermelho-claro text-white";
                                                                        } else {
                                                                            if (strpos($row['propStatus'], 'AGUARD.') !== false) {
                                                                                $moodStatusComercial = "bg-azul text-white";
                                                                            } else {
                                                                                $moodStatusComercial = "bg-amarelo";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                                if ($row['propEmpresa'] != null) {
                                                    $empresa = $row['propEmpresa'];
                                                    $classEmpresa = '';
                                                } else {
                                                    $empresa = '-';
                                                    $classEmpresa = 'class="text-center"';
                                                }

                                            ?>

                                                <tr>
                                                    <td><?php echo $row['pedNumPedido']; ?></td>
                                                    <td><?php echo $data; ?></td>
                                                    <td><span class="badge <?php echo $corFluxo; ?>"><?php echo $nomeFluxo; ?></span></td>
                                                    <td><?php echo $contagemDias; ?></td>
                                                    <td><?php echo $preventrega; ?></td>

                                                    <td <?php echo $classEmpresa; ?>><?php echo $empresa; ?></td>
                                                    <td><?php echo $row['propNomeDr']; ?></td>
                                                    <td><?php echo $row['propNomePac']; ?></td>

                                                    <td><?php echo $row['propUserCriacao']; ?></td>
                                                    <td><?php echo $row['propTipoProd']; ?></td>

                                                    <td class="d-flex justify-content-around">
                                                        <a href="dados_proposta?id=<?php echo $row['propId']; ?>">
                                                            <button class="btn text-info"><i class="fas fa-eye"></i></button></a>

                                                    </td>
                                                </tr>
                                            <?php

                                            }
                                            ?>

                                        </tbody>
                                    </table>

                                    <div class="container-fluid">

                                        <p class="row d-none justify-content-between">
                                            <span class="col d-flex justify-content-start">
                                                <?php
                                                echo "Página: {$pagina}<br>";
                                                ?>
                                            </span>
                                            <span class="col d-flex justify-content-end">
                                                <?php
                                                echo "Total de páginas: " . $page_number;
                                                ?>
                                            </span>
                                        </p>

                                        <p class="row d-flex justify-content-center">
                                            <a href='?p=1' class='btn btn-light mx-1' href="">
                                                << </a>
                                                    <?php
                                                    $first_page = max($pagina - $page_interval, 1);
                                                    $last_page = min($page_number, $pagina + $page_interval);

                                                    for ($p = $first_page; $p <= $last_page; $p++) {
                                                        if ($p === $pagina) {
                                                            echo "<a class='btn btn-dark mx-1'> {$p} </a>";
                                                        } else {
                                                            echo "<a class='btn btn-light mx-1' href='?p={$p}'> {$p}</a>";
                                                        }
                                                    }
                                                    ?>
                                                    <a class='btn btn-light mx-1' href="?p=<?php echo $page_number; ?>"> >> </a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </body>



    <?php
    $thisYear = date("Y");
    ?>


    <footer class="footer mt-5 py-3 text-dark">
        <div class="container">
            <p class="small text-center">&copy; Sistemas Fábrica 2021 - <?php echo $thisYear; ?></p>
            <p class="small text-center"> Versão 1.0</p>
        </div>
    </footer>
    <?php include_once 'php/footer_index.php' ?>

<?php
} else {
    header("location: login");
    exit();
}
?>