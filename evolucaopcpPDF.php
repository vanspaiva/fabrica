<?php
session_start();

if (isset($_SESSION["useruid"])) {
    require_once 'db/dbh.php';

    $id = $_GET['id'];

    $ret = mysqli_query($conn, "SELECT * FROM pedidos WHERE id='" . $pedidoId . "';");
    while ($row = mysqli_fetch_array($ret)) {
        $numPed = $row['pedido'];
        $fluxo = $row['fluxo'];
        $lote = $row["lote"];
        $cdgprod = $row["cdgprod"];
        $qtds = $row["qtds"];
        $descricao = $row["descricao"];
        $dataPedido = $row("-", $row["dt"]);


        $dataPedido  = $dataPedido [2] . "/" . $dataPedido [1] . "/" . $dataPedido [0];

       /*  $modelo = $row['modelo'];
        $descricaoSetor = $row["descricao_setor"];

        $descricaoAtividadesIds = explode(',', $row["descricao_atividades"]);
        $atividadesNomes = [];
        foreach ($descricaoAtividadesIds as $atividadeId) {
            $sqlDescricao = "SELECT descricao FROM descricao_atividades WHERE id = ?";
            $stmtDescricao = $conn->prepare($sqlDescricao);
            $stmtDescricao->bind_param('i', $atividadeId);
            $stmtDescricao->execute();
            $resultDescricao = $stmtDescricao->get_result();
            if ($resultDescricao->num_rows > 0) {
                $descricao = $resultDescricao->fetch_assoc()['descricao'];
                $atividadesNomes[] = $descricao;
            }
            $stmtDescricao->close();
        }
        $descricaoAtividades = implode(", ", $atividadesNomes); */

        $title = "Pedido - $id";

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
                            <h3 class="font-weight-bold" style="text-align: center;">Registro de Manutenção Preventiva e Limpeza de Ar-Condicionado</h3>
                            <h6 style="text-align: center;">Informações do Pedido</h6>
                        </div>
                    </div>
                </div>
            </div>
            <br>

            <div class="container">
                <div class="row">
                    <div style="margin-bottom: 2%;" class="col">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Data de Publicação: </td>
                                    <td style="width: 150px;"><?php echo $data_publicacao; ?></td>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Validade: </td>
                                    <td style="width: 150px;"><?php echo $data_validade; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" colspan="6" style="text-align: center; background-color: silver;" class="p-2"> Identificação do ar-Condicionado </td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Identificação do ambiente </td>
                                    <td style="width: 150px;"><?php echo $descricaoSetor; ?></td>
                                    <td class="font-weight-bold" style="width: 150px; background-color: silver;"> Marca/Modelo </td>
                                    <td style="width: 150px;"><?php echo $modelo; ?></td>
                                </tr>
                                <tr>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Responsável </td>
                                    <td colspan="5"><?php echo isset($responsavel) ? htmlspecialchars($responsavel) : ''; ?></td>

                                <tr>
                                    <td class="font-weight-bold" style="width: 150px;background-color: silver;"> Data Manutenção </td>
                                    <td colspan="5"><?php echo $data_manutencao; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-bordered table-sm">
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold" style="text-align: center;"> Descrição das Atividades </td>
                                    <td class="font-weight-bold" style=" text-align: center;"> Executado </td>
                                    <td class="font-weight-bold" style="text-align: center;"> Responsável </td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Verificação e drenagem da água</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square">
                                    <input type="checkbox" <?php echo in_array(1, $descricaoAtividadesIds) ? 'checked' : ''; ?>>
                                    </i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Limpar bandejas e serpentinas - lavar as bandejas e serpentinas com remoção do biofilme (lodo), sem o uso de produtos desengraxantes e corrosivos (higienizador e bactericidas)</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i>
                                </td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Limpeza do gabinete - limpar o gabinete do condicionador e ventiladores (carcaça e rotor)</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Limpeza dos filtros - verificação e eliminação de sujeiras, danos e corrosão e frestas dos filtros</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Trocar filtros</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Verificação da fixação</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Verificação de vazamentos nas ligações flexíveis</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Estado de conservação do isolamento termo-acústico</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Vedação dos painéis de fechamento do gabinete</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Manutenção mecânica</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Manutenção elétrica</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                <tr style="height: 30px;">
                                    <td>Outros</td>
                                    <td style="text-align: center; width: 20px;"><i class="far fa-square"></i></td>
                                    <td style="width: 21%;"></td>
                                </tr>
                                </tr>
                            </tbody>
                        </table>
                    </div>

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
