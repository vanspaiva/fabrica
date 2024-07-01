<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
?>

<body class="bg-light-gray2">
    <?php
    include_once 'php/navbar.php';
    include_once 'php/lateral-nav.php';
    ?>

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
            <div class="row py-4 d-flex justify-content-center">
                <div class="col-sm-10">
                    <div class="row d-flex justify-content-around">
                        <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                            <h5 class="text-muted"><b>Formulário - FRM.INF.004</b></h5>
                            <small class="text-muted">Gerenciamento da Manutenção</small>
                        </div>
                        <div class="col-sm d-none d-sm-block">
                            <div class="d-flex justify-content-evenly">
                                <div class="d-flex justify-content-center p-1">
                                    <a href="FRM_INF_004"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Abrir FRM.004</button></a>
                                </div>
                                <div class="d-flex justify-content-center p-1">
                                    <a href="export"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> Exportar</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <br>
                    <div class="">
                        <div class="card-body">
                            <div class="content-panel">
                                <div class="table-responsive">
                                    <table id="tableProp" class="table table-striped table-advance table-hover">

                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Data Publicação</th>
                                                <th>Setor</th>
                                                <th>Descrição das Atividades</th>
                                                <th>Data Manutenção</th>
                                                <th>Responsável</th>
                                      <!--           <th>Conferido</th> -->
                                                <th>Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once 'db/dbh.php';
                                            $query = "
                                            SELECT 
                                                frm_inf_004.id AS frm_id,
                                                frm_inf_004.data_publicacao,
                                                frm_inf_004.data_manutencao,
                                                setor_arcondicionado.descricao_setores AS setor_descricao,
                                                checkbox_selecionados.descricao_checkbox AS atividade_descricao
                                            FROM 
                                                frm_inf_004
                                            LEFT JOIN 
                                                setor_arcondicionado ON frm_inf_004.descricao_setores = setor_arcondicionado.descricao_setores
                                            LEFT JOIN 
                                                checkbox_selecionados ON frm_inf_004.id_checkbox_selecionados = checkbox_selecionados.id
                                            ";
                                            $ret = mysqli_query($conn, $query);
                                            if ($ret === false) {
                                                echo "Erro na consulta: " . mysqli_error($conn);
                                            } else {
                                                while ($row = mysqli_fetch_array($ret)) {
                                            ?>

                                                    <tr>
                                                        <td style="text-align: center; padding: 2%;"><?php echo $row['frm_id']; ?></td>
                                                        <td style="text-align: center; padding: 2% 5% 1% 0%"><?php echo date('d/m/Y', strtotime($row['data_publicacao'])); ?></td>
                                                        <td style="text-align: center; padding: 2% 5% 1% 0%;"><?php echo $row['setor_descricao']; ?></td>
                                                        <td style="text-align: center; padding: 2% 5% 1% 0%;"><?php echo $row['atividade_descricao']; ?></td>
                                                        <td style="text-align: center; padding: 2% 5% 1% 0%;"><?php echo date('d/m/Y', strtotime($row['data_manutencao'])); ?></td>
                                                        <td style="text-align: center; padding: 2%;">
                                                            <?php
                                                            // Implementar a lógica para obter o responsável (usersName)
                                                            echo "Responsável"; // Substituir por lógica para obter o nome do responsável
                                                            ?>
                                                        </td>
                                                        <!-- <td style="text-align: center; padding: 2%;">
                                                            <?php if ($row['user_id']) : ?>
                                                                <i class="fas fa-check text-success"></i>
                                                            <?php else : ?>
                                                                <i class="fas fa-times text-danger"></i>
                                                            <?php endif; ?>
                                                        </td> -->
                                                        <td style="display: flex;  padding: 1.1em;">
                                                            <a href="editfrm?id=<?php echo $row['frm_id']; ?>">
                                                                <button class="btn btn-info btn-sm"><i class="far fa-edit"></i></button></a>
                                                            <a style="padding: 0 0.3em;" href="delfrm?id=<?php echo $row['frm_id']; ?>">
                                                                <button class="btn btn-warning btn-sm"><i class="far fa-file-pdf"></i></button></a>

                                                            <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                <a href="manageOs?id=<?php echo $row['frm_id']; ?>">
                                                                    <button class="btn btn-danger btn-sm" onClick="return confirm('Você realmente deseja deletar essa OS?');"><i class="far fa-trash-alt"></i></button></a>
                                                            <?php
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <?php include_once 'php/footer_index.php'; ?>
    <script>
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
                    [0, "desc"]
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
</body>

</html>
