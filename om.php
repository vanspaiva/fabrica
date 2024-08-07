<?php

session_start();

if (isset($_SESSION["useruid"])) {
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    $id = $_GET['id'];


    $ret = mysqli_query($conn, "SELECT * FROM ordenmanutencao WHERE omId='" . $id . "';");
    while ($row = mysqli_fetch_array($ret)) {
        //Data Abertura
        $dataEHora = explode(" ", $row['omDtCriacao']);

        $dataBD = $dataEHora[0];
        $horaBD = $dataEHora[1];

        $dataBD = explode("-", $dataBD);
        $horaBD = explode(":", $horaBD);

        $data = $dataBD[2] . "/" . $dataBD[1] . "/" . $dataBD[0];
        $hora = $horaBD[0] . ":" . $horaBD[1];

        //Responsável Abertura
        $responsavel = $row["omNomeCriador"];
        $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $responsavel . "';");
        while ($rowUser = mysqli_fetch_array($retUser)) {
            $responsavel = $rowUser["usersName"];
        }
        $responsavel = explode(" ", $responsavel);
        $responsavel = $responsavel[0];

        //Codigo OM
        $idCdg = intval($id);
        $idCdg = 1000 + $idCdg;
        $codgos = 'OM' . $idCdg;


        //Responsável Abertura
        $responsavel = $row["omNomeCriador"];
        $retUser = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $responsavel . "';");
        while ($rowUser = mysqli_fetch_array($retUser)) {
            $responsavel = $rowUser["usersName"];
        }
        $responsavel = explode(" ", $responsavel);
        $responsavel = $responsavel[0];

        $tempoNaoOperacional = $row['tempoNaoOperacional'];

        //N maquina        
        $lote = $row["idMaquina"];
        //Descrição
        $descricao = $row["omDescricao"];
        //Nº Pedido
        $pedido = $row["omNomeMaquina"];
        //modelo
        $omIdentificadorMaquina = $row["omIdentificadorMaquina"];
        //OBS
        $obs = $row["omObs"];

        $omTipoManutencao = $row["omTipoManutencao"];
        $omOperacional = $row["omOperacional"];
   
        $omAcaoQualidade = $row["omAcaoQualidade"];
        if ($omAcaoQualidade == 'op1') {
            $omAcaoQualidade = 'verificar identificação de não operacional';
        } else if ($omAcaoQualidade == 'op2') {
            $omAcaoQualidade = 'verificar se realmente deve estar operacional';
        }

        $omRequalificar = $row["omRequalificar"];
        $omIdRespRequalificar = $row["omIdRespRequalificar"];
        $omIdRespRequalificar = getUserName($conn, $omIdRespRequalificar);
        $omIdRespManutencao = $row["omIdRespManutencao"];
        $omIdRespManutencao = getUserName($conn, $omIdRespManutencao);


        $title = $codgos . " - FRM.PRO.006 Rev.00";

        include("php/head_op.php");

?>
        <style media="print">
            @page {
                size: auto;
                margin: 0;
            }
        </style>

        <style>
            #printOnly {
                display: none;
            }

            @media print {
                #printOnly {
                    display: block;
                }
            }
        </style>

        <body class="bg-white">

            <div class="faixaFab d-print-none py-2">
                <div class="conatiner">
                    <div class="row d-flex">
                        <div class="col d-flex justify-content-center">
                            <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                <button class='button-back button-back-white p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row p-2">
                    <div class="col-sm d-flex justify-content-center align-items-center p-2">
                        <div>
                            <h3 class="font-weight-bold" style="text-align: center;">ORDEM DE MANUTENÇÃO</h3>
                            <h6 style="text-align: center;">FRM.PRO.011 Rev.00</h6>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="container">
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Resp. Abertura: </td>
                                    <td><?php echo $responsavel; ?></td>
                                    <td class="font-weight-bold" style="width: 80px; background-color: silver;">Assin. </td>
                                    <td style="width: 200px;"></td>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Dt. Abertura: </td>
                                    <td colspan="5" style="width: 150px;"><?php echo $data; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" colspan="8" style="text-align: center; background-color: silver;" class="p-2"> INFORMAÇÕES PARA O SERVIÇO </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Código: </td>
                                    <td colspan="8" style="width: 200px;"><?php echo $codgos; ?></td>
                                    <!-- <td colspan="4" style="text-align: center;"><img alt='testing' src="barcode/barcode.php?codetype=Code128&size=40&text=<?php echo $codgos; ?>&print=true" /></td> -->
                                </tr>
                                <!-- <tr>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> DATA PARA ENTREGA </td>
                                    <td colspan="5"><?php echo $dataEntrega; ?></td>
                                </tr> -->
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Nº Máquina: </td>
                                    <td style="width: 200px;"><?php echo $lote; ?></td>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Nome Máquina: </td>
                                    <td colspan="8" style="width: 200px;"><?php echo $pedido; ?> (<?php echo $omIdentificadorMaquina; ?>)</td>
                                </tr>
                                <tr style="vertical-align: middle;">
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Tipo Manutenção: </td>
                                    <td style="
                                    width: 200px; 
                                    text-align: center;
                                    align-items: center;
                                    vertical-align: middle;">
                                        <?php echo $omTipoManutencao; ?>
                                    </td>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> A maquina está operacional: </td>

                                    <td style="                             
                                    width: 200px; 
                                    text-align: center;
                                    align-items: center;
                                    vertical-align: middle;">
                                        <?php echo $omOperacional; ?> 
                                    </td>

                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Tempo não Operacional: </td>
                                    <td style="                             
                                    width: 200px; 
                                    text-align: center;
                                    align-items: center;
                                    vertical-align: middle;">
                                     <?php echo $tempoNaoOperacional; ?>
                                    </td>

                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Ação da Qualidade: </td>
                                    <td style="width: 200px;"><?php echo $omAcaoQualidade; ?></td>
                                </tr>

                                <tr>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Necessita Requalificação: </td>
                                    <td style="width: 200px;"><?php echo strtoupper($omRequalificar); ?></td>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Respons. Requalificação: </td>
                                    <td style="width: 200px;"><?php echo $omIdRespRequalificar; ?></td>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Respons. Manutenção: </td>
                                    <td colspan="5" style="width: 200px;"><?php echo $omIdRespManutencao; ?></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr class="p-2">
                                    <td class="font-weight-bold p-2" colspan="2" rowspan="2" style="text-align: center;">
                                        <div>
                                            <div class="d-flex justify-content-start">
                                                <p><i class="far fa-square"></i> Aprovado</p>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <p><i class="far fa-square"></i> Reprovado</p>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <p>DATA DE FECHAMENTO: _____/_____/_____</p>
                                            </div>
                                        </div>
                                        <div>
                                    </td>
                                </tr>
                                <div class="">
                                    <tr class="p-8 m-2"> 
                                        <td class="font-weight-bold" style="text-align: center; padding-top: 7%">
                                            <div class="d-flex justify-content-start">
                                                <p>RESPONSÁVEL ___________________________________________________</p>
                                            </div>
                                        </td>
                                </div>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!--<div class="row">
                    <div class="col">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td style="width: 100px;"> Código: </td>
                                    <td><?php //echo $cdg; 
                                        ?></td>
                                </tr>
                                <tr>
                                    <td style="width: 100px;"> Lote: </td>
                                    <td><?php //echo $lote; 
                                        ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>-->


            </div>

            <br>

            <div class="d-print-none d-flex justify-content-center">
                <button class="btn btn-fab m-2" onclick="window.print();return false;"> <i class="fas fa-print"></i> Imprimir</button>


            </div>
    <?php
    }

    include_once 'php/footer_index.php';
} else {
    header("location: index");
    exit();
}
    ?>