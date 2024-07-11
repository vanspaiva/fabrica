<style>
    #dropdown-secundario{
        display: none;
        color: black;
    }
  @media (max-width: 450px) {
    #lista-nav {
      display: none !important; /* Oculta o botão de toggle do dropdown */
    }
    #dropdown-secundario{
        display: block;
    }
  }
</style>

<nav class="nav navbar py-2 mt-auto justify-content-center bg-ft" style="max-height: 30px;">
</nav>
<nav class="nav navbar py-2 mt-auto justify-content-center bg-sg-color">
    <div class="container-fluid">
        <div class="d-flex flex-row align-items-center" style="width: 100%;">
            <div class="col-sm-4 d-flex justify-content-start align-itens-center">
                <!--Menu Hamburguer-->
                <span class="btn btn-link" onclick="openNav()" style="color: #fff !important;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="auto" viewBox="0 0 31.941 25.566">
                        <g id="Grupo_306" data-name="Grupo 306" transform="translate(-1007.867 -2832.489)">
                            <path id="Caminho_336" data-name="Caminho 336" d="M1023.986,2944.418q7.094,0,14.187,0a1.593,1.593,0,0,1,.336,3.167c-.161.015-.324.013-.486.013q-14.075,0-28.15,0a2.755,2.755,0,0,1-.847-.1,1.584,1.584,0,0,1,.436-3.071c.162-.01.324-.007.487-.007Z" transform="translate(-0.103 -100.738)" fill="#fff" />
                            <path id="Caminho_337" data-name="Caminho 337" d="M1019.854,2835.689q-5.166,0-10.332,0a1.589,1.589,0,0,1-1.541-2.166,1.563,1.563,0,0,1,1.362-1.021,2.806,2.806,0,0,1,.336-.011h20.364a1.649,1.649,0,0,1,1.722,1.11,1.592,1.592,0,0,1-1.542,2.087c-1.4.012-2.8,0-4.193,0Z" fill="#fff" />
                            <path id="Caminho_338" data-name="Caminho 338" d="M1016.864,3056.159c2.383,0,4.766,0,7.149,0a1.581,1.581,0,0,1,1.57,1.2,1.539,1.539,0,0,1-.711,1.74,2.031,2.031,0,0,1-.922.248q-7.093.023-14.186.007a1.6,1.6,0,1,1,.025-3.2Q1013.327,3056.155,1016.864,3056.159Z" transform="translate(-0.204 -201.306)" fill="#fff" />
                        </g>
                    </svg>

                </span>
            </div>
            <div class="col-sm-4 d-flex justify-content-center">

            </div>



            <!-- problema no nav -->
            <div class="col-sm-4 d-flex justify-content-end" id="lista-nav">
                <div class="d-flex justify-content-around align-items-center">
                    <span class="px-2 text-white"><i class="fas fa-comments"></i></span>
                    <span class="px-2 text-white"><i class="fas fa-bell"></i></span>
                    <span class="px-2 text-white"><a href="https://cpmhindustria.sharepoint.com/sites/IntranetGrupofix?sw=auth" target="_blank" class="text-white"><i class="far fa-life-ring"></i> </a></span>
                    <span class="px-2 text-white"><a href="dash" class="text-white"><i class="fas fa-home"></i> </a></span>
                    <span class="px-2 text-white">|</span>
                    <span class="px-2 text-white">
                        <div class="dropdown">
                            <button class="btn btn-dropdown-sg dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $_SESSION["userfirstname"]; ?></i>
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <span class="px-2 py-1">
                                    <h5 class="text-center text-white" style="font-size: 10pt; color: #8c8c8c;"><?php echo $_SESSION["userperm"]; ?></h5>
                                </span>
                                <!-- <li class="px-2 py-1"><a class="" href="index" style="color: black; text-decoration: none;"> <i class="fas fa-grip-vertical mr-1"></i> Módulos</a></li> -->
                                <li class="px-2 py-1"><a class="" href="profile" style="color: black; text-decoration: none;"> <i class="far fa-id-badge mr-1"></i> Meu Perfil</a></li>
                                <hr style="border: 1px solid #c1c1c1;">
                                <li class="px-2 py-1"><a class="sairbtn" href="includes/logout.inc.php" style="text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                            </ul>
                        </div>
                    </span>
                </div>
            </div>


            <div class="dropdown" id="dropdown-secundario">
                <button class="btn btn-dropdown-sg dropdown-toggle" type="button" data-toggle="dropdown"><?php echo $_SESSION["userfirstname"]; ?></i>
                    <span class="caret"></span></button>
                <ul class="dropdown-menu">
                    <span class="px-2 py-1">
                        <h5 class="text-center text-white" style="font-size: 10pt; color: #8c8c8c;"><?php echo $_SESSION["userperm"]; ?></h5>
                    </span>
                    <!-- <li class="px-2 py-1"><a class="" href="index" style="color: black; text-decoration: none;"> <i class="fas fa-grip-vertical mr-1"></i> Módulos</a></li> -->
                    <li class="px-2 py-1"><a class="" href="profile" style="color: black; text-decoration: none;"> <i class="far fa-id-badge mr-1"></i> Meu Perfil</a></li>
                    <hr style="border: 1px solid #c1c1c1;">
                    <li class="px-2 py-1"><a class="sairbtn" href="includes/logout.inc.php" style="text-decoration: none;"><i class="fas fa-sign-out-alt"></i> Sair</a></li>
                </ul>
            </div>



        </div>
    </div>
</nav>