<?php include("php/head_index.php");

require_once 'includes/dbh.inc.php';

if (isset($_SESSION["useruid"]) && (($_SESSION["userperm"] == 'Administrador') || ($_SESSION["userperm"] == 'Comercial'))) {

?>

    <body class="bg-conecta">
        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
        ?>

        <link rel="stylesheet" href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
        <script src="https://cdn.tiny.cloud/1/zjf2h1vx7aqnqpv1gai59eeqiqb64jvhdg2tfv34o6i9i7lm/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
            tinymce.init({
                selector: 'textarea',
                plugin: 'a_tinymce_plugin',
                a_plugin_option: true,
                a_configuration_option: 400
            });
        </script>

        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div>
                <?php
                if (isset($_GET["error"])) {
                    if ($_GET["error"] == "stmtfailed") {
                        echo "<div class='my-2 pb-0 alert alert-warning pt-3 text-center'><p>Alguma coisa deu errado, tente novamente!</p></div>";
                    } else if ($_GET["error"] == "none") {
                        echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Produto editado com sucesso!</p></div>";
                    }
                }
                ?>
            </div>
            <div class="container-fluid">
                <div class="row d-flex justify-content-center">

                    <div class="col-sm-10 justify-content-start" id="titulo-pag">
                        <div class="d-flex">
                            <div class="col-sm-1">
                                <div class='col-sm-1 d-flex justify-content-start align-items-start' id='back'>
                                    <button class='button-back button-back-dark p-0 m-0 pt-2' type='button' onclick='history.go(-1)'><i class='fas fa-chevron-left fa-2x'></i></button>
                                </div>
                            </div>
                            <div class="col-sm-11 pt-2 row-padding-2">
                                <div class="row px-3">
                                    <h2>Informações do Produto</h2>
                                </div>
                            </div>
                        </div>
                        <!-- <h2>Informações do Produto</h2> -->
                        <br>
                        <div class="card">

                            <div class="card-body">
                                <?php

                                $ret = mysqli_query($conn, "SELECT * FROM produtos WHERE prodId='" . $_GET['id'] . "';");
                                while ($row = mysqli_fetch_array($ret)) {

                                ?>
                                    <section id="main-content">
                                        <section class="wrapper">
                                            <div class="row">

                                                <div class="col-md-12">
                                                    <div class="content-panel">

                                                        <p class="alert-warning"></p>

                                                        <form class="prodForm" action="includes/produtos.inc.php" method="post">
                                                            <div class="form-row" hidden>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="prodid">Prod ID</label>
                                                                    <input type="text" class="form-control" id="prodid" name="prodid" value="<?php echo $row['prodId']; ?>" required readonly>
                                                                    <small class="text-muted">ID não é editável</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="categoria">Categoria</label>
                                                                    <input type="text" class="form-control" id="categoria" name="categoria" value="<?php echo $row['prodCategoria']; ?>" required readonly>
                                                                    <small class="text-muted">Categoria não é editável</small>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="cdg">Callisto</label>
                                                                    <input type="text" class="form-control" id="cdg" name="cdg" value="<?php echo $row['prodCodCallisto']; ?>" required readonly>
                                                                    <small class="text-muted">Código cadastrado no Callisto</small>
                                                                </div>
                                                            </div>
                                                            <div class="form-row">

                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="descricao">Descrição</label>
                                                                    <input type="text" class="form-control" id="descricao" name="descricao" value="<?php echo $row['prodDescricao']; ?>" required>
                                                                </div>
                                                                <div class="form-group col-md">
                                                                    <label class="form-label text-black" for="anvisa">Anvisa</label>
                                                                    <input type="text" class="form-control" id="anvisa" name="anvisa" value="<?php echo $row['prodAnvisa']; ?>" required>
                                                                </div>
                                                            </div>

                                                            <div class="d-flex justify-content-end">
                                                                <button type="submit" name="update" class="btn btn-fab">Salvar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    <?php }

                                    ?>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
        </div>

        <?php include_once 'php/footer_index.php' ?>

    <?php

} else {
    header("location: index");
    exit();
}


    ?>