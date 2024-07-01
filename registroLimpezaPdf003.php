<?php 
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
?>

    <style>
        table{
            text-align: center;
            margin: 10px;
            border: none;
        }
        thead{
            background-color: lightgray;
            font-weight: bolder;
        }
        td{
            border: 1px solid black;
            padding: 5px;
        }
        main{
            display: grid;
            place-items: center;
            padding: 50px 0;
        }
        @media print {

            .no-print {
                display: none;
            }
            thead {
                background-color: lightgray !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact;
                font-weight: bolder;
            }

            .separator{
                display: none;
            }
            .table-separate{
                page-break-before: always; /* Quebra de página antes da segunda tabela */
            }
            h1{
                display: none;
            }
        }   

        .print-button {
            margin-left: calc(800px - 160px);
            margin-bottom: 50px;
        }
        .separator{
            border-bottom: 1px solid black;
            width: 100%;
            margin: 50px 0;
        }
    </style>

    <body class="bg-light-gray2 text-align-center">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>
        <?php
            require_once 'db/dbh.php';
            require_once 'includes/functions.inc.php';
            $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%Áreas Administrativas%' ORDER BY id DESC;";
            $ret = mysqli_query($conn, $sql);
            $row = mysqli_fetch_array($ret);
        ?>
        <header>
            <!-- place navbar here -->
        </header>
        <main class="container">
            <button class="btn btn-warning no-print print-button" onclick="printPage()"><i class="bi bi-printer-fill"></i>    Imprimir Página</button>
            <h1>Áreas Administrativas</h1>
            <table style="width: 800px;">
                <thead>
                    <tr>
                        <td style="vertical-align: middle;">CPMH</td>
                        <td>Formulário <br> FRM.INF003</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            REGISTRO DE LIMPEZA
                        </td>
                    </tr>
                    <tr>
                        <td>Data Publicação: 
                            <?php 
                                if(isset($row['form_data_publicacao'])){
                                    formatData($row['form_data_publicacao']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?> 
                        </td>
                        <td>
                            Validade: 
                            <?php 
                                if(isset($row['form_data_validade'])){
                                    formatData($row['form_data_validade']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?> 
                        </td>

                    </tr>
                </thead>
            </table>

            <table style="width: 800px;">
                <thead>
                    <tr>
                        <td colspan="6">
                             <?php
                                if(isset($row['setor'])){
                                    echo preg_replace('/[0-9.]/', '', $row['setor']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                              ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Data</td>
                        <td>Periodo</td>
                        <td>Responsável</td>
                        <td>Conferido</td>
                        <td>Local</td>
                        <td>Tipo</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%Áreas Administrativas%' ORDER BY id DESC;";
                            $ret = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($ret)) {
                        ?>
                            <tr>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        formatData($row["data"]);
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                <td style="vertical-align: middle; width: 50px;"><?php echo $row["responsavel"]; ?></td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        if($row["conferido"] == "PEND"){
                                                echo "Pendente";
                                        }
                                        else{
                                            echo "OK";
                                        }
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["area_adm"];?></td>
                                <td style="vertical-align: middle;" class="truncate">
                                    <?php 
                                        $tipo_limpeza = $row['tipo_limpeza']; 
                                        $tipo_limpeza = preg_replace('/[^0-9.]/', '', $tipo_limpeza);
                                        $tipo_limpeza = str_replace('.', '-', $tipo_limpeza);
                                        $tipo_limpeza = rtrim($tipo_limpeza, '-');
                                        $tipo_limpeza = preg_replace('/-+/', '-', $tipo_limpeza);
                                        $tipo_limpeza = trim($tipo_limpeza, '-');
                                        echo $tipo_limpeza;
                                    ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tr>
                </tbody>
            </table>

            <table style="width: 800px; text-align:start; border:none; font-weight: bolder;" style="position: relative;">
                <tr>
                    <td style="border: none;">1.Vidos e Divisórias</td>
                    <td style="border: none;">5. Ar condicionado</td>
                    <td style="border: none;">9. Persianas</td>
                </tr>
                <tr>
                    <td style="border: none;">2. Piso</td>
                    <td style="border: none;">6. Paredes/Tomadas/Rodapé</td>
                    <td style="border: none;">10.Computadores</td>
                </tr>
                <tr>
                    <td style="border: none;"> 3. Prateleiras/Armários</td>
                    <td style="border: none;">7. Lixeiras</td>
                    <td style="border: none;">11. Escadas/Corrimão</td>
                </tr>
                <tr>
                    <td style="border: none;">4. Bancadas</td>
                    <td style="border: none;">8. Portas / Janelas</td>
                    <td style="border: none;">12. Filtros/ Máquinas de Café</td>
                </tr>
            </table>


            <!-------------------------------------- TABELA BANHEIRO --------------------------------------- -->
            
            <div class="separator"></div>
            <?php
                require_once 'db/dbh.php';
                $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%Banheiro%' ORDER BY id DESC;";
                $ret = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($ret);
            ?>
            <h1>Banheiros</h1>
            <table style="width: 800px;" class="table-separate">
                <thead>
                    <tr>
                        <td style="vertical-align: middle;">CPMH</td>
                        <td>Formulário <br> FRM.INF003</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            REGISTRO DE LIMPEZA
                        </td>
                    </tr>
                    <tr>
                        <td>Data Publicação: 
                            <?php 
                                if(isset($row['form_data_publicacao'])){
                                    formatData($row['form_data_publicacao']);
                                }
                                else{
                                    echo "Nothing to Show";
                                }
                            ?> 
                        </td>
                        <td>
                            Validade: 
                            <?php 
                                if(isset($row['form_data_publicacao'])){
                                    formatData($row['form_data_publicacao']);
                                }
                                else{
                                    echo "Nothing to Show";
                                }
                            ?> 
                        </td>
                    </tr>
                </thead>
            </table>

            <table style="width: 800px;">
                <thead>
                    <tr>
                        <td colspan="6">
                             <?php
                                if(isset($row['setor'])){
                                    echo preg_replace('/[0-9.]/', '', $row['setor']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                                
                              ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Data</td>
                        <td>Periodo</td>
                        <td>Responsável</td>
                        <td>Conferido</td>
                        <td>Local</td>
                        <td>Tipo</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%Banheiro%' ORDER BY id DESC;";
                            $ret = mysqli_query($conn, $sql);                    
                            while ($row = mysqli_fetch_assoc($ret)) {
                        ?>
                            <tr>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        formatData($row["data"]);
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                <td style="vertical-align: middle; width: 50px;"><?php echo $row["responsavel"]; ?></td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        if($row["conferido"] == "PEND"){

                                                echo "Pendente";
                                        }
                                        else{
                                            echo "OK";
                                        }
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                <td style="vertical-align: middle;" class="truncate">
                                    <?php 
                                        $tipo_limpeza = $row['tipo_limpeza']; 
                                        $tipo_limpeza = preg_replace('/[^0-9.]/', '', $tipo_limpeza);
                                        $tipo_limpeza = str_replace('.', '-', $tipo_limpeza);
                                        $tipo_limpeza = rtrim($tipo_limpeza, '-');
                                        $tipo_limpeza = preg_replace('/-+/', '-', $tipo_limpeza);
                                        $tipo_limpeza = trim($tipo_limpeza, '-');
                                        echo $tipo_limpeza;  
                                    ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tr>
                </tbody>
                
            </table>
            <table style="width: 800px; text-align:start; border:none; font-weight: bolder;" style="position: relative;">
                <tr>
                    <td style="border: none;">1. Sanitário</td>
                    <td style="border: none;">4. Espelho</td>
                    <td style="border: none;">7. Reposição de Sabonete</td>
                    <td style="border: none;">10. Luminárias</td>
                </tr>
                <tr>
                    <td style="border: none;">2. Pia</td>
                    <td style="border: none;">5. Reposiçã de papel higiênico</td>
                    <td style="border: none;">8. Lixeira</td>
                </tr>
                <tr>
                    <td style="border: none;"> 3. Piso</td>
                    <td style="border: none;">6. Reposição de papel Toalha</td>
                    <td style="border: none;">9. Portas/Janelas</td>

                    <td style="border: none;"></td>
                </tr>
            </table>

<!--=================================================== TABELA COPA/COZINHA ===================================================== -->
            <div class="separator"></div>
            <?php
                require_once 'db/dbh.php';
                $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%COPA%' ORDER BY id DESC;";
                $ret = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($ret);
                
            ?>
            <h1>Copa/Cozinha</h1>
            <table style="width: 800px;" class="table-separate">
                <thead>
                    <tr>
                        <td style="vertical-align: middle;">CPMH</td>
                        <td>Formulário <br> FRM.INF003</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            REGISTRO DE LIMPEZA
                        </td>
                    </tr>
                    <tr>
                        <td>Data Publicação: 
                            <?php 
                                if(isset($row['form_data_publicacao'])){
                                    formatData($row['form_data_publicacao']);
                                }
                                else{
                                    echo "Nothing to show";
                                }

                            ?> 
                        </td>
                        <td>
                            Validade: 
                            <?php 
                                if(isset($row['form_data_validade'])){
                                    formatData($row['form_data_validade']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?> 
                        </td>

                    </tr>
                </thead>
            </table>

            <table style="width: 800px;">
                <thead>
                    <tr>
                        <td colspan="6">
                            <?php 
                                if(isset($row['setor'])){
                                    echo preg_replace('/[0-9.]/', '', $row['setor']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Data</td>
                        <td>Periodo</td>
                        <td>Responsável</td>
                        <td>Conferido</td>
                        <td>Local</td>
                        <td>Tipo</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%COPA%' ORDER BY id DESC;";
                            $ret = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($ret)) {
                        ?>
                            <tr>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        formatData($row["data"]);
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                <td style="vertical-align: middle; width: 50px;"><?php echo $row["responsavel"]; ?></td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        if($row["conferido"] == "PEND"){

                                                echo "Pendente";
                                        }
                                        else{
                                            echo "OK";
                                        }
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                <td style="vertical-align: middle;" class="truncate">
                                    <?php 
                                        $tipo_limpeza = $row['tipo_limpeza']; 
                                        $tipo_limpeza = preg_replace('/[^0-9.]/', '', $tipo_limpeza);
                                        $tipo_limpeza = str_replace('.', '-', $tipo_limpeza);
                                        $tipo_limpeza = rtrim($tipo_limpeza, '-');
                                        $tipo_limpeza = preg_replace('/-+/', '-', $tipo_limpeza);
                                        $tipo_limpeza = trim($tipo_limpeza, '-');
                                        echo $tipo_limpeza;  
                                    ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tr>
                </tbody>
                
            </table>

            <table style="width: 800px; text-align:start; border:none; font-weight: bolder;" style="position: relative;">
                <tr>
                    <td style="border: none;">1.Piso</td>
                    <td style="border: none;">4. Geladeira</td>
                    <td style="border: none;">7. Paredes/ Tomadas/Rodapés</td>
                    <td style="border: none;">10. Microondas/Torradeira</td>
                </tr>
                <tr>
                    <td style="border: none;">2. Pia</td>
                    <td style="border: none;">5. Reposiçã de papel toalha</td>
                    <td style="border: none;">8. Filtros/Máquina de Café</td>

                </tr>
                <tr>
                    <td style="border: none;"> 3. Mesa</td>
                    <td style="border: none;">6. Reposição de Sabonete</td>
                    <td style="border: none;">9. Fogão</td>
                </tr>
 
            </table>

<!--=================================================== TABELA Produção ===================================================== -->

            <div class="separator"></div>
            <?php
                require_once 'db/dbh.php';
                $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%PRODUCAO%' ORDER BY id DESC;";
                $ret = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($ret);
                
            ?>
            <h1>Produção</h1>
            <table style="width: 800px;" class="table-separate">
                <thead>
                    <tr>
                        <td style="vertical-align: middle;">CPMH</td>
                        <td>Formulário <br> FRM.INF003</td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            REGISTRO DE LIMPEZA
                        </td>
                    </tr>
                    <tr>
                        <td>Data Publicação: 
                            <?php 
                                if(isset($row['form_data_publicacao'])){
                                    formatData($row['form_data_publicacao']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?> 
                        </td>
                        <td>
                            Validade: 
                            <?php 
                                if(isset( $row['form_data_validade'])){
                                    formatData($row['form_data_validade']);
                                }
                                else{
                                    echo "Nothing to show";
                                }
                            ?> 
                        </td>

                    </tr>
                </thead>    
            </table>

            <table style="width: 800px;">
                <thead>
                    <tr>
                        <td colspan="6">
                            <?php
                                if(isset($row['setor'])){
                                    echo preg_replace('/[0-9.]/', '', $row['setor']);
                                }
                                else{
                                    echo "Nothing to Show";
                                }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Data</td>
                        <td>Periodo</td>
                        <td>Responsável</td>
                        <td>Conferido</td>
                        <td>Local</td>
                        <td>Tipo</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                            $sql = "SELECT * FROM form_inf_003 WHERE setor LIKE '%PRODUCAO%' ORDER BY id DESC;";
                            $ret = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($ret)) {
                        ?>
                            <tr>
                                <td 
                                style="vertical-align: middle; text-align: center;">
                                    <?php
                                        formatData($row["data"])
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                <td style="vertical-align: middle; width: 50px;"><?php echo $row["responsavel"]; ?></td>
                                <td style="vertical-align: middle; text-align: center;">
                                    <?php
                                        if($row["conferido"] == "PEND"){

                                                echo "Pendente";
                                        }
                                        else{
                                            echo "OK";
                                        }
                                    ?>
                                </td>
                                <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                <td style="vertical-align: middle;" class="truncate">
                                    <?php 
                                        $tipo_limpeza = $row['tipo_limpeza']; 
                                        $tipo_limpeza = preg_replace('/[^0-9.]/', '', $tipo_limpeza);
                                        $tipo_limpeza = str_replace('.', '-', $tipo_limpeza);
                                        $tipo_limpeza = rtrim($tipo_limpeza, '-');
                                        $tipo_limpeza = preg_replace('/-+/', '-', $tipo_limpeza);
                                        $tipo_limpeza = trim($tipo_limpeza, '-');
                                        echo $tipo_limpeza;  
                                    ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tr>
                </tbody>
 
            </table>

            <table style="width: 800px; text-align:start; border:none; font-weight: bolder;" style="position: relative;">
                <tr>
                    <td style="border: none;">1.Vidos e Divisórias</td>
                    <td style="border: none;">5. Ar condicionado</td>
                    <td style="border: none;">9. Computadores</td>
                </tr>
                <tr>
                    <td style="border: none;">2. Piso</td>
                    <td style="border: none;">6. Paredes/Tomadas/Rodapé</td>
                    <td style="border: none;">10.Reposição de Papel Toalha</td>
                </tr>
                <tr>
                    <td style="border: none;"> 3. Prateleiras/Armários</td>
                    <td style="border: none;">7. Lixeiras</td>
                    <td style="border: none;">11. Reposição de Sabonete</td>
                </tr>
                <tr>
                    <td style="border: none;">4. Bancadas</td>
                    <td style="border: none;">8. Portas / Janelas</td>
                    <td style="border: none;">12. Reposição de Touca</td>
                </tr>
            </table>
        </main>
        <?php include_once 'php/footer_index.php' ?>
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
        <script>
        function printPage() {
            window.print();
        }
        </script>
    </body>
</html>
<?php

} else {
    header("location: index");
    exit();
}

    ?>