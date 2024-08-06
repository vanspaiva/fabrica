<?php
session_start();
if (($_SESSION['userperm']) == "Colaborador(a)") {
    header("Location: dash");
}

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");

?>
    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Exemplo de uso do DataTables</title>
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>
    <style>
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;

            body,
            h1,
            #center {
                text-align: center;

            }

            .pendentes {
                background-color: red;
                color: white;
                font-weight: bolder;
                padding: 3px;
                border-radius: 5px;
            }

            .aprovados {
                background-color: green;
                color: white;
                font-weight: bolder;
                padding: 3px;
                border-radius: 5px;
            }
        }
    </style>
    <header>
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        include_once "includes/functions.inc.php";
        ?>
    </header>

    <body class="bg-light-gray2">
        <div class="col-sm-10 container">
            <div style="padding: 50px 0;" class="row d-flex  justify-content-center">
                <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                    <h5 class="text-muted"><b>Formulário - FRM.INF.004 Pendentes</b></h5>
                    <small class="text-muted">Gerenciamento de Registros</small>
                </div>
                <div class="col-sm d-none d-sm-block">
                    <div class="d-flex  justify-content-between">
                        <div class="d-flex justify-content-center p-1">
                            <a href="frm_inf_004"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Novo Registro</button></a>
                        </div>
                        <div class="d-flex justify-content-center p-1">
                            <a href="lista-frm"><button class="btn btn-fab btn-sm">Lista de Registos</button>
                            </a>
                        </div>
                        <div class="d-flex justify-content-center p-1">
                            <a href="registroLimpezaPdf003"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> Exportar</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div style="overflow-x: auto; margin: auto; display: grid; place-items: center;">
            <div style="width: 1300px;">
                <table id="myTable" style="width: 1300px;" class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Data de Publicação</th>
                            <th>Data de Manutenção</th>
                            <th>Setor</th>
                            <th>Responsável</th>
                            <th>Status</th>
                            <th>Aprovar Registro</th>
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
                                frmstatus.status AS frmStatus,
                                frm_inf_004.responsavel
                            FROM 
                                frm_inf_004
                                LEFT JOIN setor_arcondicionado ON setor_arcondicionado.descricao_setores = frm_inf_004.descricao_setor
                                LEFT JOIN frmstatus ON frm_inf_004.frmstatus_id = frmstatus.id
                            WHERE 
                                frmstatus.status = 'Pendente'
                            GROUP BY 
                                frm_inf_004.id
                            ORDER BY 
                                frm_inf_004.id DESC
                        ";

                        $result = $conn->query($query);
                        if ($result === false) {
                            echo "Erro na consulta: " . mysqli_error($conn);
                        } else {
                            while ($row = mysqli_fetch_array($result)) {
                        ?>
                                <tr>
                                    <td style="vertical-align: middle;"><?php echo formatData($row['data_publicacao']); ?></td>
                                    <td style="vertical-align: middle;"><?php echo formatData($row['data_manutencao']); ?></td>
                                    <td style="vertical-align: middle;"><?php echo $row["setor_descricao"]; ?></td>
                                    <td style="vertical-align: middle;"><?php echo $row["responsavel"]; ?></td>
                                    <td style="text-align: center; padding: 2%;">
                                        <?php
                                        if ($row['frmStatus'] == 'Pendente') {
                                            echo '<span class="badge bg-warning text-dark">' . $row['frmStatus'] . '</span>';
                                        } elseif ($row['frmStatus'] == 'Concluída') {
                                            echo '<span class="badge bg-success text-white">' . $row['frmStatus'] . '</span>';
                                        }
                                        ?>
                                    </td>

                                    </td>
                                    <td style="text-align: center; vertical-align: middle;">
                                        <a href="editfrm.php?id=<?php echo $row['frm_id']; ?>" class="btn" onClick="return confirm('Você realmente deseja aprovar esse Registro?');">
                                            <i class="fa-solid fa-check-double" style="color: #0b9314; font-size: 1.5em;"></i>
                                        </a>
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
    </body>
    <?php include_once 'php/footer_index.php' ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                "lengthMenu": [
                    [10, 40, 80, -1],
                    [10, 40, 80, "Todos"],
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
                ],
                "columnDefs": [{
                        "width:": "10rem",
                        "targets": 0
                    },
                    {
                        "width": "15rem",
                        "targets": 1
                    },
                    {
                        "width": "20rem",
                        "targets": 2
                    },
                    {
                        "width": "5rem",
                        "targets": 3
                    },
                    {
                        "width": "5rem",
                        "targets": 4
                    },
                ]
            });
        });
    </script>

    </html>
<?php
} else {
    header("location: index");
    exit();
}

?>