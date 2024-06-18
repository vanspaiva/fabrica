<?php 
include("php/head_tables.php");
?>

<!DOCTYPE html>
<html lang="en">
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
        body > h1{
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
 <body>
    <h1>Registro de Limpeza Pendentes</h1>
   <!-- Your grid container -->
        <div style="width:1300px;margin: auto;"> 
            <table border="1" id="myTable" class="table table-striped table-advance table-hover">
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
                                        <td style="vertical-align: middle;"><?php echo $row["setor"]; ?></td>
                                        <td style="vertical-align: middle;"><?php echo $row["area_adm"]; ?></td>
                                        <td style="vertical-align: middle; width: 170px;"><?php echo $row["data"]; ?></td>
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
                                            </span>";
                                        }
                                        ?>
                                        </td>
                                        <td style="text-align: center; vertical-align: middle;"><?php echo $row["form_data_publicacao"]; ?></td>
                                        <td style="vertical-align: middle;"><?php echo $row["form_data_validade"]; ?></td>
                                        <td style="text-align: center; vertical-align: middle;"><button  type="button" class="btn btn-success"><i class="bi bi-hand-thumbs-up-fill" style="color: #ffff;"></i>Aprovar</button></td>
                                    </tr>
                                <?php
                                }
                            ?>
                </tbody>
            </table>
        </div>
 </body>
<!-- jQuery (necessary for DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
 <script>
    $(document).ready(function() {
        $('#myTable').DataTable({
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
                    ],
                    "columnDefs": [
                        { "width": "30px", "targets": 0 },
                        { "width": "30px", "targets": 1 },
                        { "width": "50px", "targets": 2 },
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
