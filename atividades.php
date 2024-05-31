<?php include("php/head_tables.php");

if (isset($_SESSION["useruid"])) {
?>

    <body class="bg-light-gray2">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        require_once 'db/dbh.php';

        $listaHoje = array();
        $listaAmanha = array();
        $listaOutro = array();

        $ret = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osStatus IN ('CRIADO', 'EM ANDAMENTO', 'PAUSADO');");
        while ($row = mysqli_fetch_array($ret)) {
            $id = $row['osId'];

            //Tempo restante
            $now = time(); // or your date as well
            $your_date = strtotime($row['dtExecucao']);
            $datediff = $now - $your_date;

            $temporestante = round($datediff / (60 * 60 * 24));
            $temporestante = $temporestante * (-1);
            $temporestante = $temporestante + 1;

            if ($temporestante == 0) {
                array_push($listaHoje, $id);
            } else if ($temporestante == 1) {
                array_push($listaAmanha, $id);
            } else {
                array_push($listaOutro, $id);
            }
        }

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
                <div class="row d-flex justify-content-around">
                    <div class="col-sm d-flex justify-content-start" style="flex-direction: column;">
                        <h5 class="text-muted"><b>OS - Quadro de Atividades</b></h5>
                        <small class="text-muted">Gerenciamento de pedidos</small>
                    </div>
                </div>
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                        A Fazer
                                    </div>
                                    <div class="container">
                                        <?php
                                        foreach ($listaOutro as &$id) {
                                            $retOutro = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osId ='" . $id . "';");
                                            while ($rowOutro = mysqli_fetch_array($retOutro)) {
                                                $status = $rowOutro['osStatus'];
                                                $descricao = $rowOutro['osDescricao'];
                                                $dataExecucao = $rowOutro['dtExecucao'];
                                                $dataVazia = '';
                                                $setor = $rowOutro['osSetor'];

                                                //Data Entrega
                                                if ($rowOutro['osDtEntregaReal'] == null) {
                                                    $dataVazia = true;
                                                    $temporestante = null;
                                                } else {
                                                    $dataVazia = false;
                                                    $dataEHoraEntrega = explode(" ", $rowOutro['osDtEntregaReal']);

                                                    $dataBDEntrega = $dataEHoraEntrega[0];
                                                    $dataBDEntrega = explode("-", $dataBDEntrega);
                                                    $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                    //Tempo restante
                                                    $now = time(); // or your date as well
                                                    $your_date = strtotime($rowOutro['osDtEntregaReal']);
                                                    $datediff = $now - $your_date;

                                                    $temporestante = round($datediff / (60 * 60 * 24));
                                                    $temporestante = $temporestante * (-1);
                                                }
                                                //Status
                                                if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                    $btn = '<a href="changestatus?id=' . $id . '&st=start"> <button class="btn btn-success btn-sm"><i class="fas fa-play-circle"></i></button></a>';
                                                } else if ($status == 'EM ANDAMENTO') {
                                                    $btn = '<a class="p-1" href="changestatus?id=' . $id . '&st=pause"> <button class="btn btn-danger btn-sm"><i class="fas fa-pause-circle"></i></button></a>';
                                                    $btn = $btn . '<a class="p-1" href="changestatus?id=' . $id . '&st=stop"> <button class="btn btn-warning btn-sm"><i class="fas fa-check-circle"></i></button></a>';
                                                } else if ($status == 'CONCLUÍDO') {
                                                    $btn = '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>';
                                                }

                                        ?>
                                                <div class="row p-2">
                                                    <div class="card w-100">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h4 style="text-align: start;"><b>Pedido <?php echo $id; ?></b></h4>
                                                                <a class="text-info" href="editaros?id=<?php echo $id; ?>">
                                                                    <i class="far fa-edit"></i></a>

                                                            </div>
                                                            <small><?php echo $setor; ?></small>
                                                            <hr>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <h5 class="p-1">Status: </h5>
                                                                <span class="badge bg-secondary text-white p-1"><?php echo $status; ?></span>
                                                            </div>
                                                            <p style="text-align: center;"><?php if (strlen($descricao > 50)) {
                                                                                                echo substr($descricao, 0, 50) . '...';
                                                                                            } else {
                                                                                                echo $descricao;
                                                                                            }
                                                                                            ?></p>


                                                            <br>
                                                            <div class="d-flex justify-content-center">

                                                                <?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $id . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo '<p>Data de Entrega: ' . $dataEntrega . '</p>';
                                                                } ?>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-center">
                                                                <?php echo $btn; ?>

                                                            </div>


                                                        </div>

                                                    </div>


                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                        Amanhã
                                    </div>
                                    <div class="container">
                                        <?php

                                        foreach ($listaAmanha as &$id) {
                                            $retAmanha = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osId ='" . $id . "';");
                                            while ($rowAmanha = mysqli_fetch_array($retAmanha)) {
                                                $status = $rowAmanha['osStatus'];
                                                $descricao = $rowAmanha['osDescricao'];
                                                $dataVazia = '';
                                                $dataExecucao = $rowAmanha['dtExecucao'];
                                                $setor = $rowAmanha['osSetor'];

                                                //Data Entrega
                                                if ($rowAmanha['osDtEntregaReal'] == null) {
                                                    $dataVazia = true;
                                                    $temporestante = null;
                                                } else {
                                                    $dataVazia = false;
                                                    $dataEHoraEntrega = explode(" ", $rowAmanha['osDtEntregaReal']);

                                                    $dataBDEntrega = $dataEHoraEntrega[0];
                                                    $dataBDEntrega = explode("-", $dataBDEntrega);
                                                    $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                    //Tempo restante
                                                    $now = time(); // or your date as well
                                                    $your_date = strtotime($rowAmanha['osDtEntregaReal']);
                                                    $datediff = $now - $your_date;

                                                    $temporestante = round($datediff / (60 * 60 * 24));
                                                    $temporestante = $temporestante * (-1);
                                                }

                                                //Status
                                                if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                    $btn = '<a href="changestatus?id=' . $id . '&st=start"> <button class="btn btn-success btn-sm"><i class="fas fa-play-circle"></i></button></a>';
                                                } else if ($status == 'EM ANDAMENTO') {
                                                    $btn = '<a class="p-1" href="changestatus?id=' . $id . '&st=pause"> <button class="btn btn-danger btn-sm"><i class="fas fa-pause-circle"></i></button></a>';
                                                    $btn = $btn . '<a class="p-1" href="changestatus?id=' . $id . '&st=stop"> <button class="btn btn-warning btn-sm"><i class="fas fa-check-circle"></i></button></a>';
                                                } else if ($status == 'CONCLUÍDO') {
                                                    $btn = '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>';
                                                }

                                        ?>
                                                <div class="row p-2">
                                                    <div class="card w-100">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h4 style="text-align: start;"><b>Pedido <?php echo $id; ?></b></h4>
                                                                <a class="text-info" href="editaros?id=<?php echo $id; ?>">
                                                                    <i class="far fa-edit"></i></a>

                                                            </div>
                                                            <small><?php echo $setor; ?></small>
                                                            <hr>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <h5 class="p-1">Status: </h5>
                                                                <span class="badge bg-secondary text-white p-1"><?php echo $status; ?></span>
                                                            </div>
                                                            <p style="text-align: center;"><?php if (strlen($descricao > 50)) {
                                                                                                echo substr($descricao, 0, 50) . '...';
                                                                                            } else {
                                                                                                echo $descricao;
                                                                                            }
                                                                                            ?></p>


                                                            <br>
                                                            <div class="d-flex justify-content-center">

                                                                <?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $id . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo '<p>Data de Entrega: ' . $dataEntrega . '</p>';
                                                                } ?>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-center">
                                                                <?php echo $btn; ?>

                                                            </div>


                                                        </div>

                                                    </div>


                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="card">
                            <div class="card-body">
                                <div class="content-panel">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1 d-flex justify-content-center">
                                        Hoje
                                    </div>
                                    <div class="container">
                                        <?php
                                        foreach ($listaHoje as &$id) {
                                            $retHoje = mysqli_query($conn, "SELECT * FROM ordenservico WHERE osId ='" . $id . "';");
                                            while ($rowHoje = mysqli_fetch_array($retHoje)) {
                                                $status = $rowHoje['osStatus'];
                                                $descricao = $rowHoje['osDescricao'];
                                                $dataVazia = '';
                                                $dataExecucao = $rowHoje['dtExecucao'];
                                                $setor = $rowHoje['osSetor'];

                                                //Data Entrega
                                                if ($rowHoje['osDtEntregaReal'] == null) {
                                                    $dataVazia = true;
                                                    $temporestante = null;
                                                } else {
                                                    $dataVazia = false;
                                                    $dataEHoraEntrega = explode(" ", $rowHoje['osDtEntregaReal']);

                                                    $dataBDEntrega = $dataEHoraEntrega[0];
                                                    $dataBDEntrega = explode("-", $dataBDEntrega);
                                                    $dataEntrega = $dataBDEntrega[2] . "/" . $dataBDEntrega[1] . "/" . $dataBDEntrega[0];

                                                    //Tempo restante
                                                    $now = time(); // or your date as well
                                                    $your_date = strtotime($rowHoje['osDtEntregaReal']);
                                                    $datediff = $now - $your_date;

                                                    $temporestante = round($datediff / (60 * 60 * 24));
                                                    $temporestante = $temporestante * (-1);
                                                }

                                                //Status
                                                if (($status == 'CRIADO') || ($status == 'PAUSADO')) {
                                                    $btn = '<a href="changestatus?id=' . $id . '&st=start"> <button class="btn btn-success btn-sm"><i class="fas fa-play-circle"></i></button></a>';
                                                } else if ($status == 'EM ANDAMENTO') {
                                                    $btn = '<a class="p-1" href="changestatus?id=' . $id . '&st=pause"> <button class="btn btn-danger btn-sm"><i class="fas fa-pause-circle"></i></button></a>';
                                                    $btn = $btn . '<a class="p-1" href="changestatus?id=' . $id . '&st=stop"> <button class="btn btn-warning btn-sm"><i class="fas fa-check-circle"></i></button></a>';
                                                } else if ($status == 'CONCLUÍDO') {
                                                    $btn = '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>';
                                                }

                                        ?>
                                                <div class="row p-2">
                                                    <div class="card w-100">
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between align-items-center">
                                                                <h4 style="text-align: start;"><b>Pedido <?php echo $id; ?></b></h4>
                                                                <a class="text-info" href="editaros?id=<?php echo $id; ?>">
                                                                    <i class="far fa-edit"></i></a>

                                                            </div>
                                                            <small><?php echo $setor; ?></small>
                                                            <hr>
                                                            <div class="d-flex justify-content-center align-items-center">
                                                                <h5 class="p-1">Status: </h5>
                                                                <span class="badge bg-secondary text-white p-1"><?php echo $status; ?></span>
                                                            </div>
                                                            <p style="text-align: center;"><?php if (strlen($descricao > 50)) {
                                                                                                echo substr($descricao, 0, 50) . '...';
                                                                                            } else {
                                                                                                echo $descricao;
                                                                                            }
                                                                                            ?></p>


                                                            <br>
                                                            <div class="d-flex justify-content-center">

                                                                <?php if ($dataVazia) {
                                                                    echo '<a href="editaros?id=' . $id . '" style="color: #000;">editar data</a>';
                                                                } else {
                                                                    echo '<p>Data de Entrega: ' . $dataEntrega . '</p>';
                                                                } ?>
                                                            </div>
                                                            <hr>
                                                            <div class="d-flex justify-content-center">
                                                                <?php echo $btn; ?>

                                                            </div>


                                                        </div>

                                                    </div>


                                                </div>
                                        <?php
                                            }
                                        }
                                        ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
        <script>
            $(document).ready(function() {
                $('#table').DataTable({
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