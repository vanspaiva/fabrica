<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
    require_once 'db/dbh.php';
    require_once 'includes/functions.inc.php';
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
                                <a href="configuracoes">
                                    <span class="btn btn-outline-fab text-muted">
                                        <i class="fas fa-angle-left"></i>
                                    </span>
                                </a>
                            </div>
                            <div class="col d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>Fluxos</b></h5>
                                <small class="text-muted">Gerenciamento de fluxos</small>
                            </div>
                            <div class="col">
                                <div class="d-flex justify-content-end p-1">
                                    <span class="btn btn-fab mx-2 p-2 px-3" data-toggle="modal" data-target="#novofluxo"><i class="fas fa-plus"></i> Nova Modalidade</span>
                                </div>
                            </div>
                        </div>
                        <hr>

                        <div class="">
                            <div class="card-body">
                                <div class="content-panel">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $ret = mysqli_query($conn, "SELECT * FROM fluxo ORDER BY nome ASC;");

                                            while ($row = mysqli_fetch_array($ret)) {
                                                $id = $row["id"];
                                                $nome = $row["nome"];

                                                $encryptedId = hashItemNatural($id);
                                            ?>

                                                <tr>
                                                    <td><?php echo $nome; ?></td>

                                                    <td class="d-flex justify-content-center">
                                                        <button class="btn text-info btn-sm" data-toggle="modal" data-target="#editfluxo" onclick="populate(<?php echo $id; ?>)"><i class="fas fa-edit"></i></button>
                                                        <a href="descricaofluxo?id=<?php echo $encryptedId; ?>">
                                                            <button class="btn text-fab btn-sm"><i class="fas fa-ellipsis-v"></i></button>
                                                        </a>
                                                        <a href="includes/configuracao.inc.php?dltfluxo=<?php echo $id; ?>">
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal Add Modalidade -->
        <div class="modal fade" id="novofluxo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007A5A;">
                        <h5 class="modal-title text-white">Nova Modalidade</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/configuracao.inc.php" method="post">

                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class="text-black" for="nome">Nome <b class="text-success">*</b></label>
                                    <input type="text" class="form-control" id="nome" name="nome" required>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="submit" name="nvfluxo" id="nvfluxo" class="btn btn-fab">Criar</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>

        <!-- Modal Edit Modalidade -->
        <div class="modal fade" id="editfluxo" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007A5A;">
                        <h5 class="modal-title text-white">Editar Modalidade</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Fechar">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="includes/configuracao.inc.php" method="post">
                            <div class="form-row" hidden>
                                <div class="form-group col-md">
                                    <label class="text-black" for="editid">ID <b class="text-success">*</b></label>
                                    <input type="text" class="form-control" id="editid" name="editid" required>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md">
                                    <label class="text-black" for="editnome">Nome <b class="text-success">*</b></label>
                                    <input type="text" class="form-control" id="editnome" name="editnome" required>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit" name="edfluxo" id="edfluxo" class="btn btn-fab">Salvar</button>
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
                    $.post('pesq_idfluxo.php', dados, function(retorna) {
                        var array = retorna.split(',');
                        // $result = $id . ',' . $nome . ',' . $parametro1 . ',' . $parametro2 . ',' . $iterev;

                        var id = array[0];
                        var nome = array[1];

                        document.getElementById('editid').value = id;
                        document.getElementById('editnome').value = nome;

                    });
                }
            }

            $(document).ready(function() {
                $('#tableProp').DataTable({
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