<style>
    .btn-link-conecta {
        font-weight: 400;
        color: #007A5A;
        text-decoration: none;
        background-color: transparent;
    }

    .btn-link-conecta:hover {
        color: #53B05C;
        text-decoration: underline;
    }

    .btn-link-conecta:focus,
    .btn-conecta.focus {
        text-decoration: underline;
    }

    .btn-link-conecta:disabled {
        color: #947a72;
        pointer-events: none;
    }
</style>

<div id="mySidenav" class="sidenav " style="z-index: 1030;">
    <a href="javascript:void(10)" class="closebtn" onclick="closeNav()">&times;</a>
    <div class="">
        <div class="row bg-light-gray" id="user-box">
            <?php
            require_once 'includes/dbh.inc.php';
            $user = $_SESSION["useruid"];
            ?>
            <div class="col-sm-3">
                <span class="btn btn-link-conecta" onclick="window.location='../profile?usuario=<?php echo $user; ?>'"><i class="fas fa-user fa-3x"></i></span>
            </div>
            <div class="col-sm-9">
                <?php
                if (isset($_SESSION["useruid"])) {
                    echo "<h5>" .  $_SESSION["userfirstname"] . "</h5>";
                    echo "<p>" . $_SESSION["userperm"] . "</p>";
                }
                ?>

            </div>
        </div>
    </div>

    <a href="index"> <i class="fas fa-home fa-1x"></i> Início</a>
    <a href="profile?usuario=<?php echo $user; ?>"> <i class="far fa-id-badge"></i> Meu Perfil</a>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
        echo "<hr style='border-top: 1px solid #606061;'>";
        echo "<h6 style='color: #ddd;'>Adm</h6>";
        echo "<a href='users'> <i class='fas fa-user fa-1x'></i> Usuários</a>";
        // echo "<a href='representantes'> <i class='fas fa-user-tie fa-1x'></i> Representantes</a>";
        // echo "<a href='setores'> <i class='fas fa-house-user fa-1x'></i> Setores</a>";
        // echo "<a href='sacconecta'> <i class='fas fa-question-circle fa-1x'></i> Sac Conecta</a>";
        // echo "<a href='forumsac'> <i class='fas fa-hashtag fa-1x'></i> Fórum</a>";
        // echo "<a href='gersac'><i class='fas fa-list fa-1x'></i>  Gerenciamento Sac</a>";
        echo "<a href='gercadastro'><i class='fas fa-cog fa-1x'></i>  Config. de Cadastro</a>";
        // echo "<a href='gercomercial'><i class='fas fa-cog fa-1x'></i>  Config. de Propostas</a>";


        // echo "<hr style='border-top: 1px solid #606061;'>";
        // echo "<h6 style='color: #ddd;'>Comercial</h6>";
        // echo "<a href='comercial'> <i class='fas fa-clipboard-list fa-1x'></i> Propostas</a>";
        // echo "<a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>";
        // echo "<a href='imagens-produtos'> <i class='far fa-image fa-1x'></i> Imagens dos Produtos</a>";
        // echo "<a href='relatorios'><i class='fas fa-chart-line fa-1x'></i> Relatórios Comercial</a>";
        // echo "<a href='financeiro'><i class='fas fa-university fa-1x'></i> Plano de Vendas</a>";
        // echo "<a href='convenios'><i class='fas fa-university fa-1x'></i> Convênios</a>";

        echo "<hr style='border-top: 1px solid #606061;'>";
        echo "<h6 style='color: #ddd;'>Gestor(a)</h6>";
        echo "<a href='historico'> <i class='fas fa-history fa-1x'></i> Histórico</a>";
        // echo "<a href='planejamento'> <i class='fas fa-clipboard-list fa-1x'></i> Análises de TC</a>";
        // echo "<a href='casos'><i class='bi bi-collection fa-1x'></i> Casos</a>";
        // echo "<a href='lista-os'><i class='fas fa-list fa-1x'></i> Gerenciamento de Os's</a>";
        // echo "<a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>";
        // echo "<a href='gerenciamento-agenda'><i class='fas fa-calendar-alt fa-1x'></i> Gerenciamento de Agenda</a>";
        // echo "<a href='relatoriosplan'><i class='fas fa-chart-line fa-1x'></i> Relatórios Planejamento</a>";


        // echo "<hr style='border-top: 1px solid #606061;'>";
        // echo "<h6 style='color: #ddd;'>Qualidade</h6>";
        // echo "<a href='documentos'> <i class='fas fa-clipboard-list fa-1x'></i> Documentos </a>";

        // echo "<hr style='border-top: 1px solid #606061;'>";
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Gestor(a)')) {
        echo "<hr style='border-top: 1px solid #606061;'>";
        echo "<h6 style='color: #ddd;'>Gestor</h6>";
        echo "<a href='historico'> <i class='fas fa-history fa-1x'></i> Histórico</a>";
        // echo "<a href='produtos'> <i class='fas fa-boxes fa-1x'></i> Produtos</a>";
    }
    ?>


    <a href='lista-os'><i class='fas fa-list fa-1x'></i> Gerenciamento de Os's</a>
    <a href="includes/logout.inc.php"><i class="fas fa-sign-out-alt"></i> Sair</a>


</div>