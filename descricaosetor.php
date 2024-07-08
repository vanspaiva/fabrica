<?php
session_start();

if (isset($_SESSION["useruid"]) && isset($_GET)) {
    include("php/head_tables.php");
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';

    $idsetor = deshashItemNatural($_GET["id"]);
    $nomeSetor = getNomeSetor($conn, $idsetor);
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
                                <a href="config_setores">
                                    <span class="btn btn-outline-fab text-muted">
                                        <i class="fas fa-angle-left"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="col d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted">Setor: <b><?php echo $nomeSetor; ?></b></h5>
                                <small class="text-muted">Controle de etapas do setor selecionado</small>
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
                                                <!-- <th>Ordem</th> -->
                                                <th>Etapa</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM setor_etapa WHERE idsetor = '{$idsetor}' ORDER BY id ASC ;");

                                            $contagemDias = 0;
                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $ordem = $row["id"];
                                                $idsetor = $row["idsetor"];
                                                $idetapa = $row["idetapa"];

                                                $nomeEtapa = getNomeEtapa($conn, $idetapa);

                                                $total = ultimoNumeroSetor($conn, $idsetor);

                                                $arrayIds = arrayIdEtapas($conn, $idsetor);
                                                $arrayIds = implode(",", $arrayIds);
                                            ?>

                                                <tr>
                                                    <!-- <td class="d-flex">
                                                        <b class="col text-center"><?php echo $ordem; ?></b>
                                                        <div class="col d-flex justify-content-center">
                                                            <?php
                                                            //if ($ordem != 1) {
                                                            ?>
                                                                <a class="btn text-fab btn-sm" href="includes/mudarposicao.inc.php?acao=mais&id=<?php echo $row["id"]; ?>&array=<?php echo $arrayIds; ?>&idsetor=<?php echo $idsetor; ?>"><i class="fas fa-arrow-up"></i></a>
                                                            <?php
                                                            //}
                                                            ?>
                                                            <?php
                                                            //if ($ordem != $total) {
                                                            ?>
                                                                <a class="btn text-fab btn-sm" href="includes/mudarposicao.inc.php?acao=menos&id=<?php echo $row["id"]; ?>&array=<?php echo $arrayIds; ?>&idsetor=<?php echo $idsetor; ?>"><i class="fas fa-arrow-down"></i></a>
                                                            <?php
                                                            //}
                                                            ?>
                                                        </div>
                                                    </td> -->
                                                    <td><?php echo $nomeEtapa; ?></td>

                                                    <td class="d-flex justify-content-center">
                                                        <button class="btn text-info btn-sm" data-toggle="modal" data-target="#editetapaemsetor" onclick="populate(<?php echo $id; ?>)"><i class="fas fa-edit"></i></button>
                                                        <a href="includes/configuracao.inc.php?dltetapaemsetor=<?php echo $id; ?>&idsetor=<?php echo $idsetor; ?>">
                                                            <button class="btn text-danger btn-sm" onClick="return confirm('Você realmente deseja deletar essa setor?');"><i class="fas fa-trash-alt"></i></button>
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
                                    <label class="text-black" for="idsetor">idsetor</label>
                                    <input type="text" class="form-control" id="idsetor" name="idsetor" value="<?php echo $idsetor; ?>">
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
                        

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="addEtapaToSetor" id="addEtapaToSetor" class="btn btn-fab">Adicionar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Edit Etapa -->
        <div class="modal fade" id="editetapaemsetor" tabindex="-1" role="dialog" aria-hidden="true">
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
                                    <label class="text-black" for="editidsetor">id</label>
                                    <input type="text" class="form-control" id="editidsetor" name="editidsetor" value="<?php echo $idsetor; ?>">
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
                            

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="editEtapaToSetor" id="editEtapaToSetor" class="btn btn-fab">Salvar</button>
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
                    $.post('pesq_idetapaemsetor.php', dados, function(retorna) {
                        var array = retorna.split(',');
                        // $result = $id . ',' . $nome . ',' . $parametro1 . ',' . $parametro2 . ',' . $iterev;

                        var id = array[0];
                        var idetapa = array[1];

                        document.getElementById('editid').value = id;
                        document.getElementById('editidetapa').value = idetapa;

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