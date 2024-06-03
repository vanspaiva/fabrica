<style>
    details summary::-webkit-details-marker,
    details summary::marker {
        display: none;
        content: "";
    }

    Plan a {
        font-size: small !important;
    }

    .flag {
        transform: scale(0.8);
        transition: ease all 0.4s;
    }

    .flag:hover {
        transform: scale(1);
    }
</style>

<div id="mySidenav" class="sidenav shadow font-montserrat" style="z-index: 1030;">
    <div class="container-fluid">
        <div class="row text-center mt-5">
            <a href="javascript:void(10)" class="closebtn mt-5 pt-3" onclick="closeNav()" style="font-weight: 700; color: #007A5A; font-size: 10pt;">
                x
            </a>
        </div>
        <div class="row">
            <div class="col d-flex justify-content-around align-items-center">
                <span class="bg-fab p-1 mx-2" style="border-radius: 5px;"> <img src="images/logo-b.png" alt="" style="max-width: 20px;"></span>
                <div>
                    <small class="p-0" style="font-weight: 700; color: #007A5A; font-size: 10pt;">🏭 Fábrica</small>
                    <br>
                    <small style="font-weight: 400; color: silver;">Powered by CPMH</small>
                </div>
            </div>
        </div>

    </div>
    <div class="">
        <div class="row" id="user-box">
            <?php
            require_once 'db/dbh.php';
            $user = $_SESSION["useruid"];
            ?>
            <div class="col d-flex justify-content-center py-2">
                <?php
                if (isset($_SESSION["useruid"])) {
                    //echo "<h5 style='color: #373342;'>" .  $_SESSION["userfirstname"] . "</h5>";
                    echo "<span class='badge badge-gray'>" . $_SESSION["userperm"] . "</span>";
                }
                ?>

            </div>
        </div>
    </div>

    <a href="dash"> <i class="fas fa-home fa-1x"></i> Início</a>
    <a href="profile"> <i class="far fa-id-badge"></i> Meu Perfil</a>
    <a href='lista-os'><i class='fas fa-list fa-1x'></i> Gerenciamento de Os's</a>
    <a href='configuracoes'><i class='fas fa-cog fa-1x'></i> Configurações</a>
    <a class="deactivated" href="#"> <i class="far fa-life-ring fa-1x mr-1"></i> Suporte</a>
    <a class="deactivated" href="#"> <i class="fas fa-comments fa-1x mr-1"></i> Chat</a>
    <a class="deactivated" href="#"> <i class="fas fa-bell fa-1x mr-1"></i> Notificações</a>
    

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Administrador')) {
    ?>
        <!--<hr style="border-color: #007A5A; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #007A5A; font-size: 10pt;' class="px-3"> <i class="fas fa-user-lock"></i> <b> Adm</b> <i class="fas fa-sort-down"></i> </span>
            </summary>
            <div>
                <a href='users'> <i class='fas fa-user fa-1x'></i> Usuários</a>
                <a href='gercadastro'><i class="fas fa-user-cog fa-1x"></i> Ajustes de Cadastro</a>
                <a href='configuracoes'><i class='fas fa-cog fa-1x'></i> Configurações</a>

            </div>
        </details>


        <!--<hr style="border-color: #007A5A; width: 100px;">-->
        <details class="p-2">
            <summary>
                <span style='color: #007A5A; font-size: 10pt;' class="px-3"> <i class="fas fa-user-tie"></i> <b> Gestor</b> <i class="fas fa-sort-down"></i> </span>
            </summary>
            <div>
                <a href='historico'> <i class='fas fa-history fa-1x'></i> Histórico</a>
                <a href='pcp'> <i class="fas fa-users-cog"></i> PCP</a>
                <!--<a href='bi'><i class="bi bi-file-bar-graph"></i> BI</a>-->
            </div>
        </details>


    <?php
    }
    ?>

    <?php
    if (isset($_SESSION["useruid"]) && ($_SESSION["userperm"] == 'Gestor(a)')) {
    ?>
        <details class="p-2">
            <summary>
                <span style='color: #007A5A; font-size: 10pt;' class="px-3"> <i class="fa-solid fa-user-tie"></i> <b> Gestor</b> <i class="fas fa-sort-down"></i> </span>
            </summary>
            <div>
                <a href='historico'> <i class='fas fa-history fa-1x'></i> Histórico</a>
                <a href='pcp'> <i class="fas fa-users-cog"></i> PCP</a>
                <!--<a href='bi'><i class="bi bi-file-bar-graph"></i> BI</a>-->
            </div>
        </details>

    <?php
    }
    ?>



    <a href="includes/logout.inc.php" style="bottom: 0; position: relative;" class="sairbtn"><i class="fas fa-sign-out-alt"></i> Sair</a>




</div>