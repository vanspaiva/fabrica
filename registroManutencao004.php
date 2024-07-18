<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';
?>

    <body class="bg-light-gray2">

        <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';

        if (isset($_SESSION['successMessage'])) {
            echo '<div class="alert alert-success" role="alert">' . $_SESSION['successMessage'] . '</div>';
            unset($_SESSION['successMessage']);
        } elseif (isset($_SESSION['errorMessage'])) {
            echo '<div class="alert alert-danger" role="alert">' . $_SESSION['errorMessage'] . '</div>';
            unset($_SESSION['errorMessage']);
        }
        function getUserId($conn, $useruid)
        {
            $stmt = $conn->prepare("SELECT usersId FROM users WHERE usersUid = ?");
            $stmt->bind_param("s", $useruid);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                return $row['usersId'];
            } else {
                return null;
            }
        }
        ?>
        <style>
            .details-row {
                background-color: #f9f9f9;
            }

            .details-row td {
                padding: 10px 15px;
            }

            .checkbox-container {
                display: none;
            }

            .toggle-row-btn,
            .toggle-checkboxes-btn {
                background: #1b8614;
                padding: 3%;
                border: none;
                cursor: pointer;
            }

            .toggle-row-btn i,
            .toggle-checkboxes-btn i {
                font-size: 1.2em;
            }
        </style>
        <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
        <div id="main">
            <div class="container-fluid">

                <div class="col-sm-12 mx-2 justify-content-start">
                    <div class="card">
                        <div class="card-head"></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm py-2">
                                    <h3 class="font-weight-semibold" style="text-align: center;">Registro de Manutenção</h3>
                                    <h5 class="font-weight-regular" style="text-align: center;">Formulário</h5>
                                    <h6 class="font-weight-regular" style="text-align: center;">FRM.PRO.004</h6>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-sm-12 mx-2 py-4 justify-content-start">
                    <div class="card">
                        <div class="card-body">

                            <?php
                            $ret = mysqli_query($conn, "SELECT * FROM users WHERE usersUid='" . $_SESSION["useruid"] . "';");
                            while ($row = mysqli_fetch_array($ret)) {
                                $responsavel = $_SESSION["useruid"];
                            ?>

                                <form action="includes/" method="POST">
                                    <h4 class="text-fab">Dados de Registro</h4>

                                    <div style="display: none !important;" class='d-flex justify-content-around'>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Data de Publicação<b style='color: red;'>*</b></label>
                                            <input class='form-control' name='dataPublicacao' id='dataPublicacao' type='date' required value='2023-10-18'>
                                        </div>
                                        <div class='form-group d-inline-block flex-fill m-2'>
                                            <label class='control-label' style='color:black;'>Validade</label>
                                            <input class='form-control' name='dataValidade' id='dataValidade' type='date' readonly value='2025-10-18'>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('dataPublicacao').addEventListener('change', function() {

                                            var dataPublicacao = new Date(this.value);

                                            var doisAnosDepois = new Date(dataPublicacao);
                                            doisAnosDepois.setFullYear(dataPublicacao.getFullYear() + 2);

                                            doisAnosDepois.setDate(doisAnosDepois.getDate() + 1);

                                            if (doisAnosDepois.getMonth() === 1 && doisAnosDepois.getDate() === 29) {

                                                if (!isBissexto(doisAnosDepois.getFullYear())) {
                                                    doisAnosDepois.setDate(28)
                                                }
                                            }

                                            var dia = ("0" + doisAnosDepois.getDate()).slice(-2);
                                            var mes = ("0" + (doisAnosDepois.getMonth() + 1)).slice(-2);
                                            var ano = doisAnosDepois.getFullYear();
                                            var dataValidadeFormatada = ano + "-" + mes + "-" + dia

                                            document.getElementById('dataValidade').value = dataValidadeFormatada
                                        });

                                        function isBissexto(ano) {
                                            return (ano % 4 === 0 && ano % 100 !== 0) || (ano % 400 === 0);
                                        }
                                    </script>

                                    <div class="container mt-5">
                                        <div class="d-flex justify-content-center">
                                            <div class="form-group mx-2">
                                                <label class="control-label" style="color:black;">Nº Máquina<b style="color: red;">*</b></label>
                                                <input class="form-control" name="idMaquina" id="idMaquina" type="text">
                                            </div>
                                            <div class="form-group mx-2">
                                                <label class="control-label" style="color:black;">Nome Máquina</label>
                                                <input class="form-control" name="omNomeMaquina" id="omNomeMaquina" type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="main" class="font-montserrat">
                                        <div class="container-fluid">
                                            <div class="row d-flex justify-content-center">
                                                <div class="col">
                                                    <?php
                                                    if (isset($_GET["error"])) {
                                                        if ($_GET["error"] == "statusatualizado") {
                                                            echo "<div class='my-2 pb-0 alert alert-success pt-3 text-center'><p>Novo status salvo com sucesso!</p></div>";
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <div class="row py-4 d-flex justify-content-center">
                                                <div class="col-sm-10 justify-content-start" id="">

                                                    <div class="d-flex justify-content-between">
                                                        <h2 class="text-conecta" style="font-weight: 400;">Registro de Manutenção <span style="font-weight: 700;">Semanal e Mensal</span></h2>
                                                    </div>

                                                    <hr style="border: 1px solid #2b8401">
                                                    <br>
                                                    <div class="card shadow" style="overflow: scroll;">
                                                        <div class="card-body">
                                                            <!--semanal, mensal-->
                                                            <!--Tabs for large devices-->
                                                            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true">Semanal</a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link active text-tab" id="pills-fechados-tab" data-toggle="pill" href="#pills-fechados" role="tab" aria-controls="pills-fechados" aria-selected="false">Mensal</a>
                                                                </li>
                                                            </ul>

                                                            <ul class="nav nav-pills mb-3" id="pills-tab-small" role="tablist">
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link text-tab" id="pills-abertos-tab" data-toggle="pill" href="#pills-abertos" role="tab" aria-controls="pills-abertos" aria-selected="true">
                                                                        <div class="svg-iten-nav" style="padding: 1em;">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                                <path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm80 64c-8.8 0-16 7.2-16 16l0 64c0 8.8 7.2 16 16 16l288 0c8.8 0 16-7.2 16-16l0-64c0-8.8-7.2-16-16-16L80 256z" />
                                                                            </svg>

                                                                        </div>
                                                                    </a>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <a class="nav-link active text-tab" id="pills-fechados-tab" data-toggle="pill" href="#pills-fechados" role="tab" aria-controls="pills-fechados" aria-selected="true">
                                                                        <div class="svg-iten-nav" style="padding: 1em;">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                                                                <path d="M128 0c17.7 0 32 14.3 32 32l0 32 128 0 0-32c0-17.7 14.3-32 32-32s32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 48L0 160l0-48C0 85.5 21.5 64 48 64l48 0 0-32c0-17.7 14.3-32 32-32zM0 192l448 0 0 272c0 26.5-21.5 48-48 48L48 512c-26.5 0-48-21.5-48-48L0 192zm64 80l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm128 0l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zM64 400l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16zm144-16c-8.8 0-16 7.2-16 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0zm112 16l0 32c0 8.8 7.2 16 16 16l32 0c8.8 0 16-7.2 16-16l0-32c0-8.8-7.2-16-16-16l-32 0c-8.8 0-16 7.2-16 16z" />
                                                                            </svg>
                                                                        </div>
                                                                    </a>
                                                                </li>
                                                            </ul>

                                                            <div class="tab-content" id="pills-tabContent">
                                                                <div class="tab-pane fade" id="pills-abertos" role="tabpanel" aria-labelledby="pills-abertos-tab">
                                                                    <h5 style="padding-top: 20px !important;" class="text-dark-gray" id="titulo-tab-small">Semanal</h5>
                                                                    <p style="color: silver;">Manutenção Semanal</p>
                                                                    <div class="content-panel">
                                                                        <table id="tableAberto" class="table table-striped table-advance table-hover">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>Data Prevista</th>
                                                                                    <th>Data e Hora Realizados<b style="color: red;">*</b></th>
                                                                                    <th>Responsável</th>
                                                                                    <th>Observação</th>
                                                                                    <th>Tipo<b style="color: red;">*</b></th>
                                                                                </tr>
                                                                            </thead>
                                                                            <tbody id="tableBody"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>

                                                            
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="checkboxModal" tabindex="-1" role="dialog" aria-labelledby="checkboxModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="checkboxModalLabel">Selecione as Atividades</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body" id="modalBody">
                                                                                <!-- Conteúdo do modal será adicionado dinamicamente -->
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-primary">Salvar mudanças</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                                <script>
                                                                    // Dados das manutenções semanais
                                                                    var manutencoesSemanais = [{
                                                                            dataPrevista: "03/06 a 05/06",
                                                                            atividades: ["Verificação e drenagem da água", "Limpar bandejas e serpentinas"]
                                                                        },
                                                                        {
                                                                            dataPrevista: "10/06 a 12/06",
                                                                            atividades: ["Verificação e drenagem da água", "Limpar bandejas e serpentinas"]
                                                                        },
                                                                        {
                                                                            dataPrevista: "17/06 a 24/06",
                                                                            atividades: ["Verificação e drenagem da água"]
                                                                        },
                                                                        {
                                                                            dataPrevista: "24/06 a 26/06",
                                                                            atividades: ["Verificação e drenagem da água"]
                                                                        }
                                                                    ];

                                                                    // Função para adicionar as linhas na tabela
                                                                    function adicionarLinhasTabela() {
                                                                        var tableBody = document.getElementById("tableBody");
                                                                        tableBody.innerHTML = "";

                                                                        manutencoesSemanais.forEach(function(manut, index) {
                                                                            var row = document.createElement("tr");

                                                                            // Coluna: Data Prevista
                                                                            var tdDataPrevista = document.createElement("td");
                                                                            var inputDataPrevista = document.createElement("input");
                                                                            inputDataPrevista.className = "form-control";
                                                                            inputDataPrevista.type = "text";
                                                                            inputDataPrevista.readOnly = true;
                                                                            inputDataPrevista.value = manut.dataPrevista;
                                                                            tdDataPrevista.appendChild(inputDataPrevista);
                                                                            row.appendChild(tdDataPrevista);

                                                                            // Coluna: Data e Hora Realizados
                                                                            var tdDataRealizados = document.createElement("td");
                                                                            var inputDataRealizados = document.createElement("input");
                                                                            inputDataRealizados.className = "form-control";
                                                                            inputDataRealizados.type = "datetime-local";
                                                                            inputDataRealizados.required = true;
                                                                            tdDataRealizados.appendChild(inputDataRealizados);
                                                                            row.appendChild(tdDataRealizados);

                                                                            // Coluna: Responsável
                                                                            var tdResponsavel = document.createElement("td");
                                                                            var inputResponsavel = document.createElement("input");
                                                                            inputResponsavel.className = "form-control";
                                                                            inputResponsavel.style.textTransform = "capitalize";
                                                                            inputResponsavel.required = true;
                                                                            tdResponsavel.appendChild(inputResponsavel);
                                                                            row.appendChild(tdResponsavel);

                                                                            // Coluna: Observação
                                                                            var tdObservacao = document.createElement("td");
                                                                            var textareaObservacao = document.createElement("textarea");
                                                                            textareaObservacao.className = "form-control";
                                                                            textareaObservacao.name = "observacaoSemanal";
                                                                            textareaObservacao.type = "text";
                                                                            tdObservacao.appendChild(textareaObservacao);
                                                                            row.appendChild(tdObservacao);

                                                                            // Coluna: Tipo (botão para abrir o modal)
                                                                            var tdTipo = document.createElement("td");
                                                                            var btnToggle = document.createElement("button");
                                                                            btnToggle.type = "button";
                                                                            btnToggle.className = "btn btn-primary toggle-checkboxes-btn";
                                                                            btnToggle.dataset.toggle = "modal";
                                                                            btnToggle.dataset.target = "#checkboxModal";
                                                                            btnToggle.innerHTML = "Selecionar Atividades ▼";
                                                                            btnToggle.addEventListener("click", function() {
                                                                                atualizarModal(manut.atividades);
                                                                            });
                                                                            tdTipo.appendChild(btnToggle);
                                                                            row.appendChild(tdTipo);

                                                                            tableBody.appendChild(row);
                                                                        });
                                                                    }

                                                                    // Função para atualizar o conteúdo do modal com as atividades específicas
                                                                    function atualizarModal(atividades) {
                                                                        var modalBody = document.getElementById("modalBody");
                                                                        modalBody.innerHTML = "";

                                                                        atividades.forEach(function(atividade) {
                                                                            var divCheck = document.createElement("div");
                                                                            divCheck.className = "form-check";
                                                                            var inputCheckbox = document.createElement("input");
                                                                            inputCheckbox.className = "form-check-input";
                                                                            inputCheckbox.type = "checkbox";
                                                                            inputCheckbox.value = atividade;
                                                                            var labelCheckbox = document.createElement("label");
                                                                            labelCheckbox.className = "form-check-label";
                                                                            labelCheckbox.innerHTML = atividade;
                                                                            divCheck.appendChild(inputCheckbox);
                                                                            divCheck.appendChild(labelCheckbox);
                                                                            modalBody.appendChild(divCheck);
                                                                        });
                                                                    }

                                                                    adicionarLinhasTabela();
                                                                </script>

                                                        <div class="tab-pane fade" id="pills-fechados" role="tabpanel" aria-labelledby="pills-fechados-tab">
                                                            <h5 class="text-dark-gray row-3" id="titulo-tab-small">Mensal</h5>
                                                            <p style="color: silver;">Manutenção Mensal</p>

                                                            <div class="content-panel">
                                                                <table id="tableArquivado" class="table table-striped table-advance table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Data Prevista</th>
                                                                            <th>Data e Hora Realizados<b style="color: red;">*</b></th>
                                                                            <th>Responsavel</th>
                                                                            <th>Observação</th>
                                                                            <th>Tipo<b style="color: red;">*</b></th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody id="tableBodyMensal">
                                                                        <!-- Linhas serão adicionadas dinamicamente aqui -->
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Modal  -->
                                                            <div class="modal fade" id="checkboxModal" tabindex="-1" role="dialog" aria-labelledby="checkboxModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="checkboxModalLabel">Selecione as Atividades</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body" id="modalBodyActivities">
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-primary" id="saveChangesBtn">Salvar mudanças</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            var manutencoesMensais = [{
                                                                dataPrevista: "03/06 a 17/06",
                                                                atividades: [
                                                                    "Verificação e drenagem da água",
                                                                    "Limpar bandejas e serpentinas"
                                                                ]
                                                            }, ];

                                                            function adicionarLinhasTabela() {
                                                                var tableBodyMensal = document.getElementById("tableBodyMensal");
                                                                tableBodyMensal.innerHTML = "";

                                                                manutencoesMensais.forEach(function(manut, index) {
                                                                    var row = document.createElement("tr");

                                                                    // Coluna: Data Prevista
                                                                    var tdDataPrevista = document.createElement("td");
                                                                    var inputDataPrevista = document.createElement("input");
                                                                    inputDataPrevista.className = "form-control";
                                                                    inputDataPrevista.type = "text";
                                                                    inputDataPrevista.readOnly = true;
                                                                    inputDataPrevista.value = manut.dataPrevista;
                                                                    tdDataPrevista.appendChild(inputDataPrevista);
                                                                    row.appendChild(tdDataPrevista);

                                                                    // Coluna: Data e Hora Realizados
                                                                    var tdDataRealizados = document.createElement("td");
                                                                    var inputDataRealizados = document.createElement("input");
                                                                    inputDataRealizados.className = "form-control";
                                                                    inputDataRealizados.type = "datetime-local";
                                                                    inputDataRealizados.required = true;
                                                                    tdDataRealizados.appendChild(inputDataRealizados);
                                                                    row.appendChild(tdDataRealizados);

                                                                    // Coluna: Responsável
                                                                    var tdResponsavel = document.createElement("td");
                                                                    var inputResponsavel = document.createElement("input");
                                                                    inputResponsavel.className = "form-control";
                                                                    inputResponsavel.style.textTransform = "capitalize";
                                                                    inputResponsavel.required = true;
                                                                    tdResponsavel.appendChild(inputResponsavel);
                                                                    row.appendChild(tdResponsavel);

                                                                    // Coluna: Observação
                                                                    var tdObservacao = document.createElement("td");
                                                                    var textareaObservacao = document.createElement("textarea");
                                                                    textareaObservacao.className = "form-control";
                                                                    textareaObservacao.name = "observacaoMensal";
                                                                    textareaObservacao.type = "text";
                                                                    tdObservacao.appendChild(textareaObservacao);
                                                                    row.appendChild(tdObservacao);

                                                                    // Coluna: Tipo (botão para abrir o modal)
                                                                    var tdTipo = document.createElement("td");
                                                                    var btnToggle = document.createElement("button");
                                                                    btnToggle.type = "button";
                                                                    btnToggle.className = "toggle-checkboxes-btn btn btn-primary";
                                                                    btnToggle.textContent = "Selecionar Atividades ▼";
                                                                    btnToggle.dataset.toggle = "modal";
                                                                    btnToggle.dataset.target = "#checkboxModal";
                                                                    btnToggle.addEventListener("click", function() {
                                                                        // Limpa o conteúdo anterior do modal
                                                                        var modalBody = document.getElementById("modalBodyActivities");
                                                                        modalBody.innerHTML = "";

                                                                        // Adiciona dinamicamente as atividades no modal
                                                                        manut.atividades.forEach(function(atividade) {
                                                                            var checkboxDiv = document.createElement("div");
                                                                            checkboxDiv.className = "form-check";
                                                                            var checkboxInput = document.createElement("input");
                                                                            checkboxInput.className = "form-check-input";
                                                                            checkboxInput.type = "checkbox";
                                                                            var checkboxLabel = document.createElement("label");
                                                                            checkboxLabel.className = "form-check-label";
                                                                            checkboxLabel.textContent = atividade;
                                                                            checkboxDiv.appendChild(checkboxInput);
                                                                            checkboxDiv.appendChild(checkboxLabel);
                                                                            modalBody.appendChild(checkboxDiv);
                                                                        });
                                                                    });
                                                                    tdTipo.appendChild(btnToggle);
                                                                    row.appendChild(tdTipo);

                                                                    tableBodyMensal.appendChild(row);
                                                                });
                                                            }

                                                            // Ativa a função para adicionar as linhas na tabela ao carregar a página
                                                            document.addEventListener("DOMContentLoaded", function() {
                                                                adicionarLinhasTabela();
                                                            });

                                                            document.getElementById("saveChangesBtn").addEventListener("click", function() {
                                                                // implementar a lógica para salvar as mudanças feitas no modal
                                                                // Por exemplo, ler quais checkboxes foram selecionados e realizar ações apropriadas
                                                                // Este exemplo apenas fecha o modal
                                                                $("#checkboxModal").modal("hide");
                                                            });
                                                        </script>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <button class="btn btn-fab" type="submit" name="submit" id="submit">Enviar</button>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script>
            $(document).ready(function() {
                $('.toggle-row-btn').click(function() {
                    var target = $(this).data('target');
                    $(target).toggle();
                    var currentText = $(this).val();
                    $(this).val(currentText === '▼' ? '▲' : '▼');
                });
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>
        <!--      <script>
            <?php require_once "config/firebaseConfig.php"; ?>
            const firebaseConfig = <?php echo json_encode($firebaseConfig); ?>;
        </script> -->

        <script src="js/uploadToFirebase.js"></script>

    </body>

    </html>
<?php
                            }
                        } else {
                            header("location: login");
                            exit();
                        }

?>