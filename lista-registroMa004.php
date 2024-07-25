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
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Registro de Manutenção editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "deleted") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Registro de Manutenção  foi deletada!</p></div>";
                    } else if ($_GET["error"] == "edit") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Registro de Manutenção  editada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "sent") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Registro de Manutenção  foi criada com sucesso!</p></div>";
                    } else if ($_GET["error"] == "senteerror") {
                        echo "<div class='my-2 pb-0 alert alert-danger pt-3 text-center'><p>ERRO ao enviar Registro de Manutenção !</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row py-4 d-flex justify-content-center">
                    <div class="col-sm-10">
                        <div class="row d-flex justify-content-around">
                            <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                                <h5 class="text-muted"><b>Formulário - FRM.PRO.004</b></h5>
                                <small class="text-muted">Registro de Manutenção</small>
                            </div>
                            <div class="col-sm d-none d-sm-block">
                                <div class="d-flex justify-content-evenly">
                                    <div class="d-flex justify-content-center p-1">
                                        <a href="registroManutencao004"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Abrir FRM.PRO.004</button></a>
                                    </div>
                                    <!--  <div class="d-flex justify-content-center p-1">
                                        <a href=""><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> Exportar</button></a>
                                    </div> -->
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
                                                    <th>Máquina</th>
                                                    <th>Data Prevista</th>
                                                    <th>Data Realizada</th>
                                                    <th>Responsável</th>
                                                    <th></th>
                                                    <!--   <th>Status</th> -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                require_once 'db/dbh.php';
                                                $sql = "SELECT id, idMaquina, idManutencaoSemanal, idManutencaoMensal, dataPrevista, dataRealizada, responsavel, observacao FROM omregistromanutencao";
                                                $result = $conn->query($sql);

                                                if ($result === false) {
                                                    echo "Erro na consulta: " . mysqli_error($conn);
                                                } else {
                                                    while ($row = mysqli_fetch_array($result)) {
                                                ?>
                                                        <tr>
                                                            <td style="text-align: center; padding: 2%;"><?php echo $row['id']; ?></td>
                                                            <td style="text-align: center; padding: 2%;"><?php echo $row['idMaquina']; ?></td>
                                                            <td style="text-align: center; padding: 2%"><?php echo date('d/m/Y', strtotime($row['dataPrevista'])); ?></td>
                                                            <td style="text-align: center; padding: 2%"><?php echo date('d/m/Y', strtotime($row['dataRealizada'])); ?></td> 
                                                            <td style="text-align: center; padding: 2%;"><?php echo $row['responsavel']; ?></td>
                                                            <!-- 
                                                            <td style="text-align: center; padding: 2%;">
                                                                <?php
                                                                $sqlStatus = "SELECT id, status FROM frmstatus WHERE id = {$row['id']}";
                                                                $resultStatus = $conn->query($sqlStatus);

                                                                if ($row['frmStatus'] == 'Pendente') {
                                                                    echo '<span class="badge bg-warning text-dark">' . $row['frmStatus'] . '</span>';
                                                                } elseif ($row['frmStatus'] == 'Concluída') {
                                                                    echo '<span class="badge bg-success text-white">' . $row['frmStatus'] . '</span>';
                                                                }
                                                                ?>
                                                            </td> -->
                                                            <td style="display: flex;  padding: 1.3em;">
                                                                <a style="padding: 0 0.3em;" href="">
                                                                    <!-- <a href="editfrm?id=<?php echo $row['']; ?>">  -->
                                                                    <button class="btn btn-info btn-sm"><i class="far fa-edit"></i></button></a>
                                                                <a style="padding: 0 0.3em;" href="">
                                                                    <button class="btn btn-warning btn-sm"><i class="far fa-file-pdf"></i></button></a>

                                                                <?php if ($_SESSION["userperm"] == 'Administrador') { ?>
                                                                    <a style="padding: 0 0.3em;" href="">
                                                                        <button class="btn btn-danger btn-sm" onClick="return confirm('Você realmente deseja deletar esse formulário?');"><i class="far fa-trash-alt"></i></button></a>
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
                    ],
                    "columnDefs": [{
                        "width": "100px",
                        "targets": 5
                    }, ]
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