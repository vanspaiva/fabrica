<?php 
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_tables.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
        .aprovados{
            background-color: green;
            color: white;
            font-weight: bolder;
            padding: 5px;
            border-radius: 5px;
        } 
        .disabled-button {
            pointer-events: none;
            opacity: 0.5;        
        }
        .pendentes{
            background-color: red;
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
        if(($_SESSION['userperm']) == "Colaborador(a)" ) {
            $classe_css = "disabled-button";
        }
        else {
            $classe_css = null;
        }
    ?>
</header>
<body class="bg-light-gray2">
        <div class="col-sm-10 container" >
            <div style="padding: 50px 0;" class="row d-flex  justify-content-center">
                <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                    <h5 class="text-muted"><b>Registro de Limpezas</b></h5>
                    <small class="text-muted">Gerenciamento de Registros</small>
                </div>
                <div class="col-sm d-none d-sm-block">
                    <div class="d-flex  justify-content-between">
                        <div class="d-flex justify-content-center p-1">
                            <a href="novoRegistro003"><button class="btn btn-fab btn-sm"><i class="fas fa-plus"></i> Novo Registro</button></a>
                        </div>
                        <div class="d-flex justify-content-center p-1">
                            <a href="showForm003Pendentes" class="<?= $classe_css?>"><button class="btn  btn-sm btn-danger"> Registros Pendentes</button>
                            </a>
                        </div>
<!--                         <div class="d-flex justify-content-center p-1">
                            <a href=""><button class="btn btn-outline-fab btn-sm"><i class="fas fa-thumbtack"></i> Atividades</button></a>
                        </div> -->
                        <div class="d-flex justify-content-center p-1">
                            <a href="registroLimpezaPdf003"><button class="btn btn-warning btn-sm" ><i class="bi bi-file-earmark-pdf-fill"></i> PDF</button>    </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
   <!-- Your grid container -->
        <div style="overflow-x: auto; margin: auto; display: grid; place-items: center;"> 
            <div style="width: 1500px;">
                <table border="1" id="myTable" style="width: 1500px;" class="table table-striped table-advance table-hover">
                    <thead>
                        <tr>
                            <th style="text-align: center;">Setor</th>
                            <th style="text-align: center;">Departamento</th>
                            <th style="text-align: center;">Data</th>
                            <th style="text-align: center;" >Período</th>
                            <th style="text-align: center;" >Responsável</th>   
                            <th style="text-align: center;" >Tipo de Limpeza</th>
                            <th style="text-align: center;" >Status</th>
                            <th style="text-align: center;" >Data de Publicação</th>
                            <th style="text-align: center;" >Data de Validade</th>
                            <th style="text-align: center;" >Ação</th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php
                            require_once 'db/dbh.php';
                            $sql = "SELECT * FROM form_inf_003";
                            $ret = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_array($ret)) {
                                ?>
                                    <tr>
                                        <td style="vertical-align: middle;"><?php echo $row["setor"]; ?></td>
                                        <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                        <td style="vertical-align: middle; text-align: center;"><?php formatData($row["data"]); ?></td>
                                        <td style="vertical-align: middle;"><?php echo $row["periodo"]; ?></td>
                                        <td style="vertical-align: middle; width: 50px;"><?php echo $row["responsavel"]; ?></td>
                                        <td style="vertical-align: middle;" class=" truncate"><?php echo nl2br($row["tipo_limpeza"]); ?></td>
                                        <td style="vertical-align: middle; text-align: center;">
                                            <?php
                                                if($row["conferido"] == "PEND"){
                                                        echo   "<span class='pendentes'>
                                                                    Pendente
                                                                </span>";
                                                }
                                                else{
                                                    echo "
                                                    <span class='aprovados'>
                                                        Aprovado
                                                    </span>";
                                                }
                                            ?>
                                        <td style="text-align: center; vertical-align: middle;"><?php formatData($row["data_publicacao"]) ?></td>
                                        <td style="vertical-align: middle;text-align: center;"><?php formatData( $row["data_validade"]) ?></td>
                                        <td style="vertical-align: middle;">
                                            <a href="editRegistroLimpeza003.php?id=<?php echo $row["id"]; ?>">
                                                <button class="btn btn-info btn-sm"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                            <?php /* if ($_SESSION["userperm"] == 'Administrador') { */ ?>
                                                <a href="includes/deleterl003.inc.php?id=<?php echo $row["id"]; ?> " class="<?= $classe_css?>">
                                                    <button class="btn btn-danger btn-sm delete-btn" onClick="return confirm('Você realmente deseja deletar esse Registro?');"><i class="bi bi-trash"></i></button>
                                                </a>
                                            <?php
    
                                            ?>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                        </tbody>
                </table>
            </div>
        </div>
 <?php include_once 'php/footer_index.php' ?>
 </body>
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
 <script>

function showValue() {
            console.log(this.value);
        }

        window.onload = function() {
            const buttons = document.querySelectorAll('.delete-btn');
            buttons.forEach(button => {
                button.addEventListener('click', showValue);
            });
        };

    $(document).ready(function() {
        $('#myTable').DataTable({
                    "lengthMenu": [
                        [5, 10, 20, -1],
                        [5, 10, 20, "Todos"],
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
                        { "width": "90px", "targets": 2 },
                        { "width": "50px", "targets": 3 },
                        { "width": "50px", "targets": 4 },
                        { "width": "50px", "targets": 5 },
                        { "width": "50px", "targets": 6 },
                        { "width": "50px", "targets": 7 },
                        { "width": "50px", "targets": 8 },
                        { "width": "100px", "targets": 9 },
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

