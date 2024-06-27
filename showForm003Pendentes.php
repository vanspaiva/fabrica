<?php 
session_start();
if(($_SESSION['userperm']) == "Colaborador(a)" ) {
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
   <!-- Includes all JS & CSS for the JavaScript Data Grid -->
   <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
 </head>
    <style>
        .truncate {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px; /* Adjust the max-width as needed */
        }
        body > h1, #center{
            text-align: center;
            
        }
        .pendentes{
            background-color: red;
            color: white;
            font-weight: bolder;
            padding: 3px;
            border-radius: 5px;
        }
        .aprovados{
            background-color: green;
            color: white;
            font-weight: bolder;
            padding: 3px;
            border-radius: 5px;
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
    <div class="col-sm-10 container" >
            <div style="padding: 50px 0;" class="row d-flex  justify-content-center">
                <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                    <h5 class="text-muted"><b>Registro de Limpezas Pendentes</b></h5>
                    <small class="text-muted">Gerenciamento de Registros</small>
                </div>
                <div class="col-sm d-none d-sm-block">
                    <div class="d-flex  justify-content-between">
                        <div class="d-flex justify-content-center p-1">
                            <a href="novoRegistro003"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Novo Registro</button></a>
                        </div>
                        <div class="d-flex justify-content-center p-1">
                            <a href="showForm003"><button class="btn btn-fab btn-sm">Lista de Registos</button>
                            </a>
                        </div>
<!--                         <div class="d-flex justify-content-center p-1">
                            <a href=""><button class="btn btn-outline-fab btn-sm"><i class="fas fa-thumbtack"></i> Atividades</button></a>
                        </div> -->
                        <div class="d-flex justify-content-center p-1">
                            <a href="registroLimpezaPdf003"><button class="btn btn-outline-fab btn-sm"><i class="far fa-file-excel"></i> Exportar</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   <!-- Your grid container -->
        <div style="overflow-x: auto; margin: auto; display: grid; place-items: center;"> 
            <div style="width: 1300px;">
                <table border="1" id="myTable" style="width: 1300px;" class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th>Setor</th>
                            <th>Área Administrativa</th>
                            <th>Data</th>
                            <th>Período</th>
                            <th>Responsável</th>
                            <th>Tipo de Limpeza</th>
                            <th>Status</th>
                            <th>Data de Publicação</th>
                            <th>Data de Validade</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                require_once 'db/dbh.php';
                                $sql = "SELECT * FROM form_inf_003 WHERE conferido = 'PEND'";
                                $ret = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_array($ret)) {
                                    ?>
                                        <tr>
                                            <td style="vertical-align: middle;"><?php echo $row["setor"] ?></td>
                                            <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                            <td style="vertical-align: middle;"><?php  formatData($row['data']); ?></td>
                                            <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                            <td style="vertical-align: middle;"><?php echo $row["responsavel"]; ?></td>
                                            <td class=" truncate"><?php echo nl2br($row["tipo_limpeza"]); ?></td>
                                            <td style="vertical-align: middle;"><?php
                                            if($row["conferido"] == "PEND"){
                                                    echo   "<span class='pendentes'>
                                                                Pendente
                                                            </span>";
                                            }
                                            else{
                                                echo "
                                                <span class='aprovados'>
                                                    Aprovado
                                                </span>

                                                ";
                                            }
                                            ?>
                                            </td>
                                            <td style="text-align: center; vertical-align: middle;"><?php  formatData($row["form_data_publicacao"]);?></td>
                                            <td style="vertical-align: middle;"><?php formatData($row["form_data_publicacao"]); ?></td>

                                            <td style="text-align: center; vertical-align: middle;">
                                                <a href="aprovRegistroLimpeza003.php?id=<?php echo $row["id"]; ?>">
                                                <button  type="button" class="btn btn-success"  onClick="return confirm('Você realmente deseja aprovar esse Registro?');"><i class="bi bi-hand-thumbs-up-fill" style="color: #ffff;"></i>Aprovar</button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php
                                    }
                                ?>
                    </tbody>
                </table>
            </div>
        </div>
 </body>
 <?php include_once 'php/footer_index.php' ?>
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
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
                    "columnDefs": [
                        { "width": "30px", "targets": 0 },
                        { "width": "30px", "targets": 1 },
                        { "width": "100px", "targets": 2 },
                        { "width": "50px", "targets": 3 },
                        { "width": "50px", "targets": 4 },
                        { "width": "50px", "targets": 5 },
                        { "width": "50px", "targets": 6 },
                        { "width": "50px", "targets": 7 },
                        { "width": "50px", "targets": 8 },
                        { "width": "50px", "targets": 9 },
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

