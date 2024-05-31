<?php include("php/head_tables.php");

include_once "includes/functions.inc.php";

if (isset($_SESSION["useruid"])) {

    $url = 'https://conecta.cpmhdigital.com.br/api/pedido?r=all';
    // $url = "http://localhost/conecta/conecta/api/pedido?r=all";
    $json_data = file_get_contents($url);
    $pedidos = json_decode($json_data, true);
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Ordem de Serviço foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Ordem de Serviço foi criada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Ordem de Serviço!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row row-3">
                    <div class="col-sm-1"></div>
                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start">
                                <h2>Lista de Pedidos - Conecta</h2>
                            </div>

                        </div>
                        <br>
                        <div class="card" style="overflow-x: scroll;">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="pedidos" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Num Ped</th>
                                                <th>Data Criação</th>
                                                <th>Prev Entreg</th>
                                                <th>Status</th>
                                                <th>Dr</th>
                                                <th>Pac</th>
                                                <th>Produto</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($pedidos as $key => $value) {
                                                $nomeStatus = $value["stpedNome"];
                                                $bgColor = $value["stpedCorBg"];
                                                $txColor = $value["stpedCorTexto"];
                                                $andamento = $value["pedAndamento"];
                                                $numped = $value['pedNumPedido'];



                                                
                                                if (($andamento != "FINALIZADO") && ($andamento != "ARQUIVADO")) {
                                            ?>
                                                    <tr>
                                                        <td>
                                                            <button class="btn text-success btn-xs" data-toggle="modal" data-target="#viewped" onclick="populate(<?php echo $numped; ?>)"><i class="far fa-eye"></i></button>
                                                        </td>
                                                        <td><?php echo $value['pedNumPedido']; ?></td>
                                                        <td><?php echo dateFormat($value['pedDtCriacaoPed']); ?></td>
                                                        <td><?php //echo $preventrega; ?></td>
                                                        <td> <span class='badge <?php echo $bgColor . " " . $txColor; ?>'> <?php echo $value['stpedNome']; ?></span></td>
                                                        <td><?php echo $value['pedNomeDr']; ?></td>
                                                        <td><?php echo $value['pedNomePac']; ?></td>
                                                        <td><?php echo $value['pedTipoProduto']; ?></td>
                                                    </tr>
                                            <?php
                                                }
                                            } ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1"></div>

                </div>

            </div>
        </div>
        <script>
            // Função para fazer a chamada à API
            function populate(id) {
                // Defina a URL da sua API PHP
                const apiUrl = `http://localhost/conecta/conecta/api/pedido?r=numpedido&id=${id}`;
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao chamar a API');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Faça algo com os dados recebidos da API
                        // console.log(data);
                        feedModal(data[0]);

                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

            function getDtEntrega(id) {
                // Defina a URL da sua API PHP
                const apiUrl = `http://localhost/conecta/conecta/api/pedido?r=prz&id=${id}`;
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro ao chamar a API');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Faça algo com os dados recebidos da API
                        document.getElementById('dataentrega').innerHTML = data.dataPrazoContada;
                        // return data;

                    })
                    .catch(error => {
                        console.error('Erro:', error);
                    });
            }

            function feedModal(data) {
                var id = data.pedNumPedido;
                
                document.getElementById('numpedido').innerHTML = data.pedNumPedido;
                document.getElementById('status').innerHTML = `<span class="badge px-2 ${data.stpedCorBg} ${data.stpedCorTexto}"> ${data.stpedNome} </span>`;
                document.getElementById('dtcriacao').innerHTML = data.pedDtCriacaoPed;
                getDtEntrega(id);
            }


            // function populate(id) {
            //     //Recuperar o valor do campo
            //     var pesquisa = id;
            //     // console.log(pesquisa);

            //     //Verificar se há algo digitado
            //     if (pesquisa != '') {
            //         var dados = {
            //             id: pesquisa
            //         }
            //         $.post('pesq_idcirurgia.php', dados, function(retorna) {
            //             var array = retorna.split('|');


            //             var id = array[0];
            //             var idpaciente = array[1];
            //             populatedadospaciente(idpaciente);

            //             var statuscir = array[2];
            //             var observacao = array[3];
            //             var dr = array[4];
            //             var produto = array[5];
            //             var uf = array[6];
            //             var datainicio = array[7];
            //             var horainicio = array[8];
            //             var distribuidor = array[9];
            //             var dataprotocolado = array[10];
            //             var hospital = array[11];
            //             var nomedr = array[12];
            //             var nomedistribuidor = array[13];
            //             var nomeproduto = array[14];
            //             var corstatuscir = array[15];
            //             var datajuiz = array[16];
            //             var assessoria = array[17];
            //             var assessoriaNome = array[18];
            //             var advogado = array[20];
            //             var advogadoNome = array[19];

            //             if (dataprotocolado == '') {
            //                 // Divida a data em partes usando "-"
            //                 dataprotocolado = '(vazio)';
            //             } else {
            //                 dataprotocolado = formatarData(dataprotocolado);
            //             }

            //             document.getElementById('viewidcir').innerHTML = id;
            //             document.getElementById('viewstatuscir').innerHTML = `<span class="badge px-2" style="background-color: ${corstatuscir};"> ${statuscir} </span>`;
            //             document.getElementById('viewobservacao').innerHTML = observacao;
            //             document.getElementById('viewnomedr').innerHTML = nomedr;
            //             document.getElementById('viewproduto').innerHTML = nomeproduto;
            //             document.getElementById('viewdistribuidor').innerHTML = nomedistribuidor;
            //             document.getElementById('viewdataprotocolado').innerHTML = dataprotocolado;
            //             document.getElementById('viewhospital').innerHTML = hospital;
            //             document.getElementById('viewdatajuiz').innerHTML = datajuiz;
            //             document.getElementById('viewassessoria').innerHTML = assessoriaNome;
            //             document.getElementById('viewadvogado').innerHTML = advogadoNome;


            //         });
            //     }


            // }
        </script>
        <!-- Modal View Cirurgia -->
        <div class="modal fade" id="viewped" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-fab">
                        <h5 class="modal-title text-white">Informações do Pedido</h5>
                        <span class="px-3" id="btnaddposcirurgia"></span>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="form-row">
                            <div class="form-group col-md p-2 mx-2 rounded">
                                <h5 class="txt-ciano-agiliza" for="numpedido"><b> Nº Ped</b></h5>
                                <span id="numpedido" name="numpedido"></span>
                            </div>

                            <div class="form-group col-md p-2 mx-2 rounded">
                                <h5 class="txt-ciano-agiliza" for="status"><b> Status</b></h5>
                                <span id="status" name="status"></span>
                            </div>

                            <div class="form-group col-md p-2 mx-2 rounded">
                                <h5 class="txt-ciano-agiliza" for="dtcriacao"><b>Dt Criação</b></h5>
                                <span id="dtcriacao" name="dtcriacao"></span>
                            </div>

                            <div class="form-group col-md p-2 mx-2 rounded">
                                <h5 class="txt-ciano-agiliza" for="dtentrega"><b>Dt Entrega</b></h5>
                                <span id="dataentrega" name="dtentrega"></span>
                            </div>
                        </div>



                    </div>

                </div>
            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#pedidos').DataTable({
                    "lengthMenu": [
                        [20, 40, 80, -1],
                        [20, 40, 80, "Todos"],
                    ],
                    "language": {
                        "search": "Pesquisar:",
                        "paginate": {
                            "first": "Primeiro",
                            "last": "Último",
                            "next": "Próximo",
                            "previous": "Anterior"
                        },
                        "info": "Mostrando desde _START_ até _END_ dos _TOTAL_ itens",
                        "lengthMenu": "Mostrar _MENU_ itens",
                        "zeroRecords": "Nenhuma proposta encontrada"
                    },
                    "order": [
                        [1, "desc"]
                    ]
                });
            });
        </script>
        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}

    ?>