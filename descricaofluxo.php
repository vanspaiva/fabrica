<?php
session_start();

if (isset($_SESSION["useruid"]) && isset($_GET)) {
    include("php/head_tables.php");
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    $idfluxo = deshashItemNatural($_GET["id"]);
    $nomeFluxo = getNomeFluxo($conn, $idfluxo);
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>



        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">

            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-1 d-flex justify-content-start">
                                <a href="config_fluxo">
                                    <span class="btn btn-outline-fab text-muted">
                                        <i class="fas fa-angle-left"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="col d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted">Modalidade: <b><?php echo $nomeFluxo; ?></b></h5>
                                <small class="text-muted">Controle de etapas do fluxo selecionado</small>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end p-1">
                                    <span class="btn btn-outline-fab mx-2 p-2 px-3" data-toggle="modal" data-target="#addEtapa"><i class="fas fa-plus"></i> Adicionar Etapa</span>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tabela" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Ordem</th>
                                                <th>Etapa</th>
                                                <th>Duração</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM etapa_fluxo WHERE idfluxo = '{$idfluxo}' ORDER BY ordem ASC ;");

                                            $contagemDias = 0;
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $idfluxo = $row["idfluxo"];
                                                $idetapa = $row["idetapa"];
                                                $ordem = intval($row["ordem"]);
                                                $duracao = $row["duracao"];

                                                $nomeEtapa = getNomeEtapa($conn, $idetapa);

                                                $contagemDias = $contagemDias + $duracao;
                                                if (floatval($duracao) == 1) {
                                                    $s = "dia";
                                                } else {
                                                    $s = "dias";
                                                }

                                                $total = ultimoNumeroFluxo($conn, $idfluxo);

                                                $arrayIds = arrayIdEtapas($conn, $idfluxo);
                                                $arrayIds = implode(",", $arrayIds);
                                            ?>

                                                <tr>
                                                    <td class="d-flex">
                                                        <b class="col text-center"><?php echo $ordem; ?></b>
                                                        <div class="col d-flex justify-content-center">
                                                            <?php
                                                            if ($ordem != 1) {
                                                            ?>
                                                                <a class="btn text-fab btn-sm" href="includes/mudarposicao.inc.php?acao=mais&id=<?php echo $row["id"]; ?>&array=<?php echo $arrayIds; ?>&idfluxo=<?php echo $idfluxo; ?>"><i class="fas fa-arrow-up"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                            <?php
                                                            if ($ordem != $total) {
                                                            ?>
                                                                <a class="btn text-fab btn-sm" href="includes/mudarposicao.inc.php?acao=menos&id=<?php echo $row["id"]; ?>&array=<?php echo $arrayIds; ?>&idfluxo=<?php echo $idfluxo; ?>"><i class="fas fa-arrow-down"></i></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $nomeEtapa; ?></td>
                                                    <td><?php echo $duracao . " " . $s; ?></td>

                                                    <td class="d-flex justify-content-center">
                                                        <button class="btn text-info btn-sm" data-toggle="modal" data-target="#editetapaemfluxo" onclick="populate(<?php echo $id; ?>)"><i class="fas fa-edit"></i></button>
                                                        <a href="includes/configuracao.inc.php?dltetapaemfluxo=<?php echo $id; ?>&idfluxo=<?php echo $idfluxo; ?>">
                                                            <button class="btn text-danger btn-sm" onClick="return confirm('Você realmente deseja deletar essa fluxo?');"><i class="fas fa-trash-alt"></i></button>
                                                        </a>
                                                        <?php
                                                        if ($_SESSION["userperm"] == 'Administrador') {
                                                        ?>

                                                        <?php
                                                        }
                                                        ?>
                                                    </td>
                                                </tr>
                                            <?php
                                            } ?>
                                        </tbody>
                                    </table>
                                    <div class="container-fluid">
                                        <hr>
                                        <div class="row d-flex justify-content-center">
                                            <div class="col d-flex justify-content-end">
                                                <h6>Tempo para Execução: <b class="px-1 text-fab"><?php echo $contagemDias; ?> dias</b></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Add Etapa -->
        <div class="modal fade" id="addEtapa" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007A5A;">
                        <h5 class="modal-title text-white">Adicionar Etapa</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/configuracao.inc.php" method="post">
                            <div class="form-row" hidden>
                                <div class="form-group col-md">
                                    <label class="text-black" for="idfluxo">idfluxo</label>
                                    <input type="text" class="form-control" id="idfluxo" name="idfluxo" value="<?php echo $idfluxo; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class='ml-2 label-control' for='idetapa'>Etapa <b class="text-success">*</b></label>
                                    <select class='form-select w-100' id='idetapa' name='idetapa' required>
                                        <option value="0">Selecione uma Etapa</option>
                                        <?php
                                        $ret = mysqli_query($conn, "SELECT * FROM etapa ORDER BY nome ASC");
                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class="text-black" for="duracao">Duração (dias)</label>
                                    <input type="number" step="0.5" min='0.5' class="form-control" id="duracao" name="duracao" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="addEtapaToFluxo" id="addEtapaToFluxo" class="btn btn-fab">Adicionar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Edit Etapa -->
        <div class="modal fade" id="editetapaemfluxo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007A5A;">
                        <h5 class="modal-title text-white">Editar Etapa</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/configuracao.inc.php" method="post">
                            <div class="form-row" hidden>
                                <div class="form-group col-md">
                                    <label class="text-black" for="editid">id</label>
                                    <input type="text" class="form-control" id="editid" name="editid">
                                </div>
                                <div class="form-group col-md">
                                    <label class="text-black" for="editidfluxo">id</label>
                                    <input type="text" class="form-control" id="editidfluxo" name="editidfluxo" value="<?php echo $idfluxo; ?>">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class='ml-2 label-control' for='editidetapa'>Etapa <b class="text-success">*</b></label>
                                    <select class='form-select w-100' id='editidetapa' name='editidetapa' required>
                                        <option value="0">Selecione uma Etapa</option>
                                        <?php
                                        $ret = mysqli_query($conn, "SELECT * FROM etapa ORDER BY nome ASC");
                                        while ($row = mysqli_fetch_array($ret)) {
                                        ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['nome']; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class="text-black" for="editduracao">Duração (dias)</label>
                                    <input type="number" step="0.5" min='0.5' class="form-control" id="editduracao" name="editduracao" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="editEtapaToFluxo" id="editEtapaToFluxo" class="btn btn-fab">Salvar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>



        <?php include_once 'php/footer_index.php' ?>

        <script>
            function populate(id) {
                //Recuperar o valor do campo
                var pesquisa = id;
                console.log(pesquisa);

                //Verificar se há algo digitado
                if (pesquisa != '') {
                    var dados = {
                        id: pesquisa
                    }
                    $.post('pesq_idetapaemfluxo.php', dados, function(retorna) {
                        var array = retorna.split(',');
                        // $result = $id . ',' . $nome . ',' . $parametro1 . ',' . $parametro2 . ',' . $iterev;

                        var id = array[0];
                        var idetapa = array[1];
                        var duracao = array[2];

                        document.getElementById('editid').value = id;
                        document.getElementById('editidetapa').value = idetapa;
                        document.getElementById('editduracao').value = duracao;

                    });
                }
            }

            $(document).ready(function() {
                $('#tabela').DataTable({
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
                        [0, "asc"]
                    ]
                });

            });
        </script>
    <?php

} else {
    header("location: index");
    exit();
}

    ?>