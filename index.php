<?php
// session_start();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Fábrica</title>
    <!-- Favicon-->
    <link rel="shortcut icon" href="https://s3-ap-northeast-1.amazonaws.com/g0v-hackmd-images/uploads/upload_354996bcb85d6a2dac07942e7066358d.png" />
    <!-- Custom Google font-->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet" />
    <!-- Bootstrap icons-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styleslp.css" rel="stylesheet" />
</head>

<body class="d-flex flex-column h-100">
    <main class="flex-shrink-0">

        <?php

        if (isset($_SESSION)) {
        ?>
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index"><span class="fw-bolder text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="auto" height="50" viewBox="0 0 100 119.857">
                                <g id="Grupo_1034" data-name="Grupo 1034" transform="translate(-272.921 -645)">
                                    <g id="Grupo_1030" data-name="Grupo 1030" transform="translate(391.364 645)">
                                        <g id="Grupo_1028" data-name="Grupo 1028" transform="translate(0.854 53.387)">
                                            <path id="Caminho_2284" data-name="Caminho 2284" d="M363.719,713.82h11v7.748h-11v22.389H355.2V689.728h22.544v7.747H363.719Z" transform="translate(-355.198 -678.262)" />
                                            <path id="Caminho_2285" data-name="Caminho 2285" d="M401.162,747.516h-8.6l-1.472-9.839h-10.46l-1.472,9.839h-7.824l8.677-54.229h12.472Zm-5.811-65.7-7.9,8.6h-5.732l5.268-8.6Zm-13.634,48.5h8.211L385.9,702.892h-.155Z" transform="translate(-347.937 -681.82)" />
                                            <path id="Caminho_2286" data-name="Caminho 2286" d="M420.118,702.2v1.936c0,5.578-1.7,9.064-5.5,10.846v.155c4.57,1.782,6.352,5.81,6.352,11.543V731.1c0,8.366-4.417,12.86-12.938,12.86h-13.4V689.728h12.86C416.322,689.728,420.118,693.833,420.118,702.2Zm-16.966-4.727v14.333h3.332c3.175,0,5.112-1.395,5.112-5.733v-3.022c0-3.874-1.316-5.578-4.338-5.578Zm0,22.08V736.21h4.88c2.867,0,4.417-1.317,4.417-5.346v-4.725c0-5.036-1.628-6.584-5.5-6.584Z" transform="translate(-337.455 -678.262)" />
                                            <path id="Caminho_2287" data-name="Caminho 2287" d="M434.141,743.957c-.464-1.395-.774-2.246-.774-6.663v-8.523c0-5.036-1.7-6.893-5.578-6.893h-2.943v22.078h-8.521V689.728h12.86c8.832,0,12.628,4.1,12.628,12.474v4.26c0,5.578-1.782,9.14-5.578,10.922v.155c4.261,1.782,5.656,5.811,5.656,11.466v8.366a16,16,0,0,0,.928,6.586Zm-9.3-46.482v16.656h3.331c3.177,0,5.114-1.393,5.114-5.732v-5.346c0-3.874-1.317-5.578-4.338-5.578Z" transform="translate(-327.695 -678.262)" />
                                            <path id="Caminho_2288" data-name="Caminho 2288" d="M437.8,689.728h8.523v54.229H437.8Z" transform="translate(-318.031 -678.262)" />
                                            <path id="Caminho_2289" data-name="Caminho 2289" d="M472.883,723.929v7.206c0,8.677-4.338,13.634-12.706,13.634s-12.7-4.957-12.7-13.634v-28.2c0-8.676,4.338-13.635,12.7-13.635s12.706,4.959,12.706,13.635V708.2h-8.057v-5.81c0-3.874-1.7-5.346-4.415-5.346s-4.417,1.472-4.417,5.346v29.283c0,3.873,1.7,5.268,4.417,5.268s4.415-1.395,4.415-5.268v-7.748Z" transform="translate(-313.679 -678.455)" />
                                            <path id="Caminho_2290" data-name="Caminho 2290" d="M496.855,743.957h-8.6l-1.472-9.839H476.325l-1.472,9.839h-7.825l8.676-54.229h12.474Zm-19.445-17.2h8.211l-4.028-27.426h-.155Z" transform="translate(-304.88 -678.262)" />
                                        </g>
                                        <g id="Grupo_1029" data-name="Grupo 1029">
                                            <path id="Caminho_2291" data-name="Caminho 2291" d="M374.473,656.549v.99h-2.9v-1.188c0-4.883-1.847-8.579-6.864-8.579s-6.863,3.629-6.863,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.966,11.549s-9.964-4.883-9.964-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,7,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.834-11.484C371.634,645,374.473,649.883,374.473,656.549Z" transform="translate(-354.609 -645)" />
                                            <path id="Caminho_2292" data-name="Caminho 2292" d="M374.756,645.273v46.2H371.72v-46.2Z" transform="translate(-346.91 -644.877)" />
                                            <path id="Caminho_2293" data-name="Caminho 2293" d="M397.045,656.549v.99h-2.9v-1.188c0-4.883-1.849-8.579-6.864-8.579s-6.864,3.629-6.864,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.964,11.549s-9.965-4.883-9.965-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,6.995,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.834-11.484C394.208,645,397.045,649.883,397.045,656.549Z" transform="translate(-344.453 -645)" />
                                            <path id="Caminho_2294" data-name="Caminho 2294" d="M402.729,691.47V648.045h-9.438v-2.772h21.845v2.772h-9.371V691.47Z" transform="translate(-337.204 -644.877)" />
                                            <path id="Caminho_2295" data-name="Caminho 2295" d="M426.727,666.655v2.772H414.121V688.7H429.3v2.772H411.086v-46.2H429.3v2.772H414.121v18.61Z" transform="translate(-329.197 -644.877)" />
                                            <path id="Caminho_2296" data-name="Caminho 2296" d="M442.568,691.4h-3.035l-9.768-40.851V691.47h-2.706v-46.2h4.356l9.7,40.851,9.636-40.851h4.354v46.2h-2.9V650.42Z" transform="translate(-322.01 -644.877)" />
                                            <path id="Caminho_2297" data-name="Caminho 2297" d="M454.668,681.26l-2.31,10.229h-2.772l10.1-46.262h4.422L474.4,691.49h-3.035l-2.311-10.229Zm.463-2.64h13.463l-6.8-29.895Z" transform="translate(-311.875 -644.897)" />
                                            <path id="Caminho_2298" data-name="Caminho 2298" d="M489.475,656.549v.99h-2.9v-1.188c0-4.883-1.847-8.579-6.863-8.579s-6.864,3.629-6.864,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.966,11.549s-9.964-4.883-9.964-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,7,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.833-11.484C486.636,645,489.475,649.883,489.475,656.549Z" transform="translate(-302.864 -645)" />
                                        </g>
                                    </g>
                                    <g id="Grupo_1033" data-name="Grupo 1033" transform="translate(272.921 648.597)">
                                        <g id="Grupo_1032" data-name="Grupo 1032">
                                            <g id="Grupo_1031" data-name="Grupo 1031">
                                                <path id="Caminho_2299" data-name="Caminho 2299" d="M291.19,699.134h23.585v16.608H291.19v48H272.921V647.481h48.331v16.608H291.19Z" transform="translate(-272.921 -647.481)" fill="#007a5a" />
                                            </g>
                                            <path id="Caminho_2300" data-name="Caminho 2300" d="M356.214,647.482V763.653H306.678v-16.61h31.259v-31.3H317.023v-16.61h20.914V647.482Z" transform="translate(-257.732 -647.48)" fill="#007a5a" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder align-items-center">
                            <!-- <li class="nav-item"><a class="nav-link" href="index">Home</a></li> -->
                            <li class="nav-item"><a class="nav-link" href="https://cpmhindustria.sharepoint.com/sites/IntranetGrupofix?sw=auth">Intranet</a></li>
                            <li class="nav-item"><a class="nav-link" href="dash">
                                    <span class="btn btn-primary btn-sm">Dashboard</span>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </nav>

        <?php

        } else {
        ?>
            <!-- Navigation-->
            <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
                <div class="container px-5">
                    <a class="navbar-brand" href="index"><span class="fw-bolder text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="auto" height="50" viewBox="0 0 100 119.857">
                                <g id="Grupo_1034" data-name="Grupo 1034" transform="translate(-272.921 -645)">
                                    <g id="Grupo_1030" data-name="Grupo 1030" transform="translate(391.364 645)">
                                        <g id="Grupo_1028" data-name="Grupo 1028" transform="translate(0.854 53.387)">
                                            <path id="Caminho_2284" data-name="Caminho 2284" d="M363.719,713.82h11v7.748h-11v22.389H355.2V689.728h22.544v7.747H363.719Z" transform="translate(-355.198 -678.262)" />
                                            <path id="Caminho_2285" data-name="Caminho 2285" d="M401.162,747.516h-8.6l-1.472-9.839h-10.46l-1.472,9.839h-7.824l8.677-54.229h12.472Zm-5.811-65.7-7.9,8.6h-5.732l5.268-8.6Zm-13.634,48.5h8.211L385.9,702.892h-.155Z" transform="translate(-347.937 -681.82)" />
                                            <path id="Caminho_2286" data-name="Caminho 2286" d="M420.118,702.2v1.936c0,5.578-1.7,9.064-5.5,10.846v.155c4.57,1.782,6.352,5.81,6.352,11.543V731.1c0,8.366-4.417,12.86-12.938,12.86h-13.4V689.728h12.86C416.322,689.728,420.118,693.833,420.118,702.2Zm-16.966-4.727v14.333h3.332c3.175,0,5.112-1.395,5.112-5.733v-3.022c0-3.874-1.316-5.578-4.338-5.578Zm0,22.08V736.21h4.88c2.867,0,4.417-1.317,4.417-5.346v-4.725c0-5.036-1.628-6.584-5.5-6.584Z" transform="translate(-337.455 -678.262)" />
                                            <path id="Caminho_2287" data-name="Caminho 2287" d="M434.141,743.957c-.464-1.395-.774-2.246-.774-6.663v-8.523c0-5.036-1.7-6.893-5.578-6.893h-2.943v22.078h-8.521V689.728h12.86c8.832,0,12.628,4.1,12.628,12.474v4.26c0,5.578-1.782,9.14-5.578,10.922v.155c4.261,1.782,5.656,5.811,5.656,11.466v8.366a16,16,0,0,0,.928,6.586Zm-9.3-46.482v16.656h3.331c3.177,0,5.114-1.393,5.114-5.732v-5.346c0-3.874-1.317-5.578-4.338-5.578Z" transform="translate(-327.695 -678.262)" />
                                            <path id="Caminho_2288" data-name="Caminho 2288" d="M437.8,689.728h8.523v54.229H437.8Z" transform="translate(-318.031 -678.262)" />
                                            <path id="Caminho_2289" data-name="Caminho 2289" d="M472.883,723.929v7.206c0,8.677-4.338,13.634-12.706,13.634s-12.7-4.957-12.7-13.634v-28.2c0-8.676,4.338-13.635,12.7-13.635s12.706,4.959,12.706,13.635V708.2h-8.057v-5.81c0-3.874-1.7-5.346-4.415-5.346s-4.417,1.472-4.417,5.346v29.283c0,3.873,1.7,5.268,4.417,5.268s4.415-1.395,4.415-5.268v-7.748Z" transform="translate(-313.679 -678.455)" />
                                            <path id="Caminho_2290" data-name="Caminho 2290" d="M496.855,743.957h-8.6l-1.472-9.839H476.325l-1.472,9.839h-7.825l8.676-54.229h12.474Zm-19.445-17.2h8.211l-4.028-27.426h-.155Z" transform="translate(-304.88 -678.262)" />
                                        </g>
                                        <g id="Grupo_1029" data-name="Grupo 1029">
                                            <path id="Caminho_2291" data-name="Caminho 2291" d="M374.473,656.549v.99h-2.9v-1.188c0-4.883-1.847-8.579-6.864-8.579s-6.863,3.629-6.863,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.966,11.549s-9.964-4.883-9.964-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,7,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.834-11.484C371.634,645,374.473,649.883,374.473,656.549Z" transform="translate(-354.609 -645)" />
                                            <path id="Caminho_2292" data-name="Caminho 2292" d="M374.756,645.273v46.2H371.72v-46.2Z" transform="translate(-346.91 -644.877)" />
                                            <path id="Caminho_2293" data-name="Caminho 2293" d="M397.045,656.549v.99h-2.9v-1.188c0-4.883-1.849-8.579-6.864-8.579s-6.864,3.629-6.864,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.964,11.549s-9.965-4.883-9.965-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,6.995,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.834-11.484C394.208,645,397.045,649.883,397.045,656.549Z" transform="translate(-344.453 -645)" />
                                            <path id="Caminho_2294" data-name="Caminho 2294" d="M402.729,691.47V648.045h-9.438v-2.772h21.845v2.772h-9.371V691.47Z" transform="translate(-337.204 -644.877)" />
                                            <path id="Caminho_2295" data-name="Caminho 2295" d="M426.727,666.655v2.772H414.121V688.7H429.3v2.772H411.086v-46.2H429.3v2.772H414.121v18.61Z" transform="translate(-329.197 -644.877)" />
                                            <path id="Caminho_2296" data-name="Caminho 2296" d="M442.568,691.4h-3.035l-9.768-40.851V691.47h-2.706v-46.2h4.356l9.7,40.851,9.636-40.851h4.354v46.2h-2.9V650.42Z" transform="translate(-322.01 -644.877)" />
                                            <path id="Caminho_2297" data-name="Caminho 2297" d="M454.668,681.26l-2.31,10.229h-2.772l10.1-46.262h4.422L474.4,691.49h-3.035l-2.311-10.229Zm.463-2.64h13.463l-6.8-29.895Z" transform="translate(-311.875 -644.897)" />
                                            <path id="Caminho_2298" data-name="Caminho 2298" d="M489.475,656.549v.99h-2.9v-1.188c0-4.883-1.847-8.579-6.863-8.579s-6.864,3.629-6.864,8.513c0,11.22,16.7,11.417,16.7,24.155,0,6.665-2.9,11.549-9.966,11.549s-9.964-4.883-9.964-11.549v-2.377h2.9v2.574c0,4.95,1.914,8.514,7,8.514s7-3.564,7-8.514c0-11.086-16.7-11.285-16.7-24.153,0-6.929,3.036-11.417,9.833-11.484C486.636,645,489.475,649.883,489.475,656.549Z" transform="translate(-302.864 -645)" />
                                        </g>
                                    </g>
                                    <g id="Grupo_1033" data-name="Grupo 1033" transform="translate(272.921 648.597)">
                                        <g id="Grupo_1032" data-name="Grupo 1032">
                                            <g id="Grupo_1031" data-name="Grupo 1031">
                                                <path id="Caminho_2299" data-name="Caminho 2299" d="M291.19,699.134h23.585v16.608H291.19v48H272.921V647.481h48.331v16.608H291.19Z" transform="translate(-272.921 -647.481)" fill="#007a5a" />
                                            </g>
                                            <path id="Caminho_2300" data-name="Caminho 2300" d="M356.214,647.482V763.653H306.678v-16.61h31.259v-31.3H317.023v-16.61h20.914V647.482Z" transform="translate(-257.732 -647.48)" fill="#007a5a" />
                                        </g>
                                    </g>
                                </g>
                            </svg>
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 small fw-bolder align-items-center">
                            <!-- <li class="nav-item"><a class="nav-link" href="index">Home</a></li> -->
                            <li class="nav-item"><a class="nav-link" href="https://cpmhindustria.sharepoint.com/sites/IntranetGrupofix?sw=auth">Intranet</a></li>
                            <li class="nav-item"><a class="nav-link" href="login">
                                    <span class="btn btn-primary btn-sm">Login</span>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <?php

        }
        ?>
        <!-- Header-->
        <header class="py-5">
            <div class="container px-5 pb-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-xxl-5">
                        <!-- Header text content-->
                        <div class="text-center text-xxl-start">
                            <div class="badge bg-gradient-primary-to-secondary text-white mb-4">
                                <div class="text-uppercase">Technology &middot; Agricultural &middot; Machinery</div>
                            </div>
                            <!-- <div class="fs-3 fw-light text-muted">Otimização de trabalho</div> -->
                            <h1 class="display-3 fw-bolder mb-5"><span class="text-gradient d-inline">Sistemas Fábrica</span></h1>
                            <div class="d-grid gap-3 d-sm-flex justify-content-sm-center justify-content-xxl-start mb-3">
                                <a class="btn btn-primary btn-lg px-5 py-3 me-sm-3 fs-6 fw-bolder" href="login">Login</a>
                                <a class="btn btn-outline-dark btn-lg px-5 py-3 fs-6 fw-bolder" href="cadastro">Cadastro</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-7">
                        <!-- Header profile picture
                        <div class="d-flex justify-content-center mt-5 mt-xxl-0">
                            <div class="profile">
                                < !-- TIP: For best results, use a photo with a transparent background like the demo example below-- >
                                < !-- Watch a tutorial on how to do this on YouTube (link)-- >
                                <img class="profile-img" src="index/assetsnew/trator2.png" alt="..." />

                            </div>
                        </div> -->
                    </div>
                </div>
            </div>
        </header>
        <!-- About Section-->
        <section class="bg-light py-5">
            <div class="container px-5">
                <div class="row gx-5 justify-content-center">
                    <div class="col-xxl-8">
                        <div class="text-center my-5">
                            <h2 class="display-5 fw-bolder"><span class="text-gradient d-inline">Dúvidas e IT's</span></h2>
                            <p class="lead fw-light mb-4">Acesse a Intranet para mais informações</p>
                            <p class="text-muted"><a href="https://cpmhindustria.sharepoint.com/sites/IntranetGrupofix?sw=auth" target="_blank">Intranet Grupofix</a></p>
                            <!-- <div class="d-flex justify-content-center fs-2 gap-4">
                                <a class="text-gradient" href="#!"><i class="bi bi-twitter"></i></a>
                                <a class="text-gradient" href="#!"><i class="bi bi-linkedin"></i></a>
                                <a class="text-gradient" href="#!"><i class="bi bi-github"></i></a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer-->
    <footer class="bg-white py-4 mt-auto">
        <div class="container px-5">
            <div class="row align-items-center justify-content-between flex-column flex-sm-row">
                <div class="col-auto">
                    <div class="small m-0">Sistemas Fábrica CPMH Digital &copy; 2021 - <?php echo date("Y"); ?></div>
                </div>
                <div class="col-auto">
                    <a class="small" href="https://www.cpmhdigital.com.br/politica_de_privacidade/" target="_blank">Política de Privacidade</a>
                    <span class="mx-1">&middot;</span>
                    <a class="small" href="https://www.cpmhdigital.com.br/termos-e-condicoes/" target="_blank">Termos e condições</a>
                    <span class="mx-1">&middot;</span>
                    <a class="small" href="https://www.cpmhdigital.com.br/contato/" target="_blank">Contato</a>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>