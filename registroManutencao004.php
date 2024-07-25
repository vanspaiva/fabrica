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

                                <form action="includes/registroManutencao004.inc.php" method="POST">
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
                                            <div class="form-group mx-2">
                                                <label class="control-label" style="color:black;">Identificador Máquina</label>
                                                <input class="form-control" name="omIdentificadorMaquina" id="omIdentificadorMaquina" type="text" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        document.getElementById('idMaquina').addEventListener('input', function() {
                                            var idMaquina = this.value.trim();

                                            if (idMaquina) {
                                                fetch(`busca_maquina.php?idMaquina=${encodeURIComponent(idMaquina)}`)
                                                    .then(response => response.json())
                                                    .then(data => {
                                                        if (data.omNomeMaquina) {
                                                            document.getElementById('omNomeMaquina').value = data.omNomeMaquina;
                                                            document.getElementById('omIdentificadorMaquina').value = data.omIdentificadorMaquina || 'Não disponível';
                                                        } else if (data.error) {
                                                            document.getElementById('omNomeMaquina').value = data.error;
                                                            document.getElementById('omIdentificadorMaquina').value = '';
                                                        } else {
                                                            document.getElementById('omNomeMaquina').value = 'Máquina não encontrada';
                                                            document.getElementById('omIdentificadorMaquina').value = '';
                                                        }
                                                    })
                                                    .catch(error => {
                                                        console.error('Erro ao buscar dados:', error);
                                                        document.getElementById('omNomeMaquina').value = 'Erro ao buscar dados';
                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                    });
                                            } else {
                                                document.getElementById('omNomeMaquina').value = '';
                                                document.getElementById('omIdentificadorMaquina').value = '';
                                            }
                                        });
                                    </script>

                                    <div id="main" class="font-montserrat">
                                        <div class="container-fluid">
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
                                                                    <a class="nav-link active text-tab" id="pills-fechados-tab" data-toggle="pill" href="#pills-fechados" role="tab" aria-controls="pills-fechados" aria-selected="true">Mensal</a>
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
                                                                            <tbody id="tableBodyMensal"></tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                                <!-- Modal -->
                                                                <div class="modal fade" id="checkboxModal" tabindex="-1" role="dialog" aria-labelledby="checkboxModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title" id="checkboxModalLabel">Atividades</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body" id="modalBody">

                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-primary" id="submitModal">Enviar</button>
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <script>
                                                                    document.getElementById('idMaquina').addEventListener('input', function() {
                                                                        var idMaquina = this.value.trim();
                                                                        if (idMaquina) {
                                                                            fetch(`busca_maquina.php?idMaquina=${encodeURIComponent(idMaquina)}`)
                                                                                .then(response => response.json())
                                                                                .then(data => {
                                                                                    processarDadosMaquina(data);
                                                                                })
                                                                                .catch(error => {
                                                                                    console.error('Erro ao buscar dados:', error);
                                                                                    exibirMensagemErro();
                                                                                });
                                                                        } else {
                                                                            limparCampos();
                                                                        }
                                                                    })

                                                                    function processarDadosMaquina(data) {
                                                                        if (data.omNomeMaquina && data.omNomeMaquina !== 'Máquina não encontrada') {
                                                                            document.getElementById('omNomeMaquina').value = data.omNomeMaquina;
                                                                            document.getElementById('omIdentificadorMaquina').value = data.omIdentificadorMaquina || 'Não disponível';
                                                                            atualizarLinhasTabelaSemanal(data.atividadesSemanal || []);
                                                                            atualizarLinhasTabelaMensal(data.atividadesMensal || []);
                                                                        } else {
                                                                            exibirMensagemNaoEncontrada();
                                                                        }
                                                                    }

                                                                    function exibirMensagemErro() {
                                                                        document.getElementById('omNomeMaquina').value = 'Erro ao buscar dados';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function exibirMensagemNaoEncontrada() {
                                                                        document.getElementById('omNomeMaquina').value = 'Máquina não encontrada';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function limparCampos() {
                                                                        document.getElementById('omNomeMaquina').value = '';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function atualizarLinhasTabelaSemanal(atividades) {
                                                                        atualizarTabela("tableBody", atividades, "observacaoSemanal");
                                                                    }

                                                                    function atualizarLinhasTabelaMensal(atividades) {
                                                                        atualizarTabela("tableBodyMensal", atividades, "observacaoMensal");
                                                                    }

                                                                    function atualizarTabela(idTabela, atividades, nomeCampoObservacao) {
                                                                        var datasPrevistas = obterDatasPrevistas(idTabela);
                                                                        var tableBody = document.getElementById(idTabela);
                                                                        tableBody.innerHTML = "";

                                                                        datasPrevistas.forEach(function(dataPrevista) {
                                                                            var row = document.createElement("tr");
                                                                            row.appendChild(criarCelula("input", "form-control", "text", dataPrevista, true));
                                                                            row.appendChild(criarCelula("input", "form-control", "datetime-local", "", false, true));
                                                                            row.appendChild(criarCelula("input", "form-control", "text", "", false, false, "capitalize"));
                                                                            row.appendChild(criarCelula("textarea", "form-control", "text", "", false, false, "", nomeCampoObservacao));
                                                                            row.appendChild(criarBotaoTipo(atividades));
                                                                            tableBody.appendChild(row);
                                                                        });
                                                                    }

                                                                    function obterDatasPrevistas(idTabela) {
                                                                        return idTabela === "tableBody" ? ["03/06 a 05/06", "10/06 a 12/06", "17/06 a 24/06", "24/06 a 26/06"] : ["03/06 a 17/06"];
                                                                    }

                                                                    function criarCelula(tag, classe, tipo, valor, desativado, required = false, transform = "", nomeCampo = "") {
                                                                        var cell = document.createElement("td");
                                                                        var element = document.createElement(tag);
                                                                        element.className = classe;
                                                                        element.type = tipo;
                                                                        element.value = valor;
                                                                        element.disabled = desativado;
                                                                        element.required = required;
                                                                        element.style.textTransform = transform;
                                                                        element.name = nomeCampo;
                                                                        cell.appendChild(element);
                                                                        return cell;
                                                                    }

                                                                    function criarBotaoTipo(atividades) {
                                                                        var td = document.createElement("td");
                                                                        var btnToggle = document.createElement("button");
                                                                        btnToggle.type = "button";
                                                                        btnToggle.className = "btn btn-primary toggle-checkboxes-btn";
                                                                        btnToggle.dataset.toggle = "modal";
                                                                        btnToggle.dataset.target = "#checkboxModal";
                                                                        btnToggle.innerHTML = "Selecionar Atividades ▼";
                                                                        btnToggle.addEventListener("click", function() {
                                                                            atualizarModal(atividades);
                                                                        });
                                                                        td.appendChild(btnToggle);
                                                                        return td;
                                                                    }

                                                                    function atualizarModal(atividades) {
                                                                        var modalBody = document.getElementById("modalBody");
                                                                        modalBody.innerHTML = "";

                                                                        atividades.forEach(function(atividade) {
                                                                            var div = document.createElement("div");
                                                                            div.className = "form-check";
                                                                            var input = document.createElement("input");
                                                                            input.className = "form-check-input";
                                                                            input.type = "checkbox";
                                                                            input.value = atividade;
                                                                            input.id = "check-" + atividade;
                                                                            var label = document.createElement("label");
                                                                            label.className = "form-check-label";
                                                                            label.htmlFor = "check-" + atividade;
                                                                            label.appendChild(document.createTextNode(atividade));
                                                                            div.appendChild(input);
                                                                            div.appendChild(label);
                                                                            modalBody.appendChild(div);
                                                                        });
                                                                    }
                                                                </script>
                                                                <script>
                                                                    document.getElementById('idMaquina').addEventListener('input', function() {
                                                                        var idMaquina = this.value.trim();

                                                                        if (idMaquina) {
                                                                            fetch(`busca_maquina.php?idMaquina=${encodeURIComponent(idMaquina)}`)
                                                                                .then(response => response.json())
                                                                                .then(data => {
                                                                                    processarDadosMaquina(data);
                                                                                })
                                                                                .catch(error => {
                                                                                    console.error('Erro ao buscar dados:', error);
                                                                                    exibirMensagemErro();
                                                                                });
                                                                        } else {
                                                                            limparCampos();
                                                                        }
                                                                    });

                                                                    function processarDadosMaquina(data) {
                                                                        if (data.omNomeMaquina && data.omNomeMaquina !== 'Máquina não encontrada') {
                                                                            document.getElementById('omNomeMaquina').value = data.omNomeMaquina;
                                                                            document.getElementById('omIdentificadorMaquina').value = data.omIdentificadorMaquina || 'Não disponível';
                                                                            atualizarLinhasTabelaSemanal(data.atividadesSemanal || []);
                                                                            atualizarLinhasTabelaMensal(data.atividadesMensal || []);
                                                                        } else {
                                                                            exibirMensagemNaoEncontrada();
                                                                        }
                                                                    }

                                                                    function exibirMensagemErro() {
                                                                        document.getElementById('omNomeMaquina').value = 'Erro ao buscar dados';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function exibirMensagemNaoEncontrada() {
                                                                        document.getElementById('omNomeMaquina').value = 'Máquina não encontrada';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function limparCampos() {
                                                                        document.getElementById('omNomeMaquina').value = '';
                                                                        document.getElementById('omIdentificadorMaquina').value = '';
                                                                        atualizarLinhasTabelaSemanal([]);
                                                                        atualizarLinhasTabelaMensal([]);
                                                                    }

                                                                    function atualizarLinhasTabelaSemanal(atividades) {
                                                                        atualizarTabela("tableBody", atividades, "observacaoSemanal");
                                                                    }

                                                                    function atualizarLinhasTabelaMensal(atividades) {
                                                                        atualizarTabela("tableBodyMensal", atividades, "observacaoMensal");
                                                                    }

                                                                    function atualizarTabela(idTabela, atividades, nomeCampoObservacao) {
                                                                        var datasPrevistas = obterDatasPrevistas(idTabela);
                                                                        var tableBody = document.getElementById(idTabela);
                                                                        tableBody.innerHTML = "";
                                                                        datasPrevistas.forEach(function(dataPrevista) {
                                                                            var row = document.createElement("tr");
                                                                            row.appendChild(criarCelula("input", "form-control", "text", dataPrevista, true));
                                                                            row.appendChild(criarCelula("input", "form-control", "datetime-local", "", false, true));
                                                                            row.appendChild(criarCelula("input", "form-control", "text", "", false, false, "capitalize"));
                                                                            row.appendChild(criarCelula("textarea", "form-control", "text", "", false, false, "", nomeCampoObservacao));
                                                                            row.appendChild(criarBotaoTipo(atividades));
                                                                            tableBody.appendChild(row);
                                                                        });
                                                                    }

                                                                    function obterDatasPrevistas(idTabela) {
                                                                        return idTabela === "tableBody" ? ["03/06 a 05/06", "10/06 a 12/06", "17/06 a 24/06", "24/06 a 26/06"] : ["03/06 a 17/06"];
                                                                    }

                                                                    function criarCelula(tipoElemento, className, tipo, valor, leitura, obrigatorio, transformacao, nomeCampo) {
                                                                        var td = document.createElement("td");
                                                                        var elemento = document.createElement(tipoElemento);
                                                                        elemento.className = className;
                                                                        elemento.type = tipo;
                                                                        if (leitura) elemento.readOnly = true;
                                                                        if (obrigatorio) elemento.required = true;
                                                                        if (transformacao) elemento.style.textTransform = transformacao;
                                                                        if (nomeCampo) elemento.name = nomeCampo;
                                                                        elemento.value = valor;
                                                                        td.appendChild(elemento);
                                                                        return td;
                                                                    }

                                                                    function criarBotaoTipo(atividades) {
                                                                        var td = document.createElement("td");
                                                                        var btnToggle = document.createElement("button");
                                                                        btnToggle.type = "button";
                                                                        btnToggle.className = "btn btn-primary toggle-checkboxes-btn";
                                                                        btnToggle.dataset.toggle = "modal";
                                                                        btnToggle.dataset.target = "#checkboxModal";
                                                                        btnToggle.innerHTML = "Selecionar Atividades ▼";
                                                                        btnToggle.addEventListener("click", function() {
                                                                            atualizarModal(atividades);
                                                                        });
                                                                        td.appendChild(btnToggle);
                                                                        return td;
                                                                    }

                                                                    function atualizarModal(atividades) {
                                                                        var modalBody = document.getElementById("modalBody");
                                                                        modalBody.innerHTML = "";

                                                                        atividades.forEach(function(atividade) {
                                                                            var div = document.createElement("div");
                                                                            div.className = "form-check";
                                                                            var input = document.createElement("input");
                                                                            input.className = "form-check-input";
                                                                            input.type = "checkbox";
                                                                            input.value = atividade;
                                                                            input.id = "check-" + atividade;
                                                                            var label = document.createElement("label");
                                                                            label.className = "form-check-label";
                                                                            label.htmlFor = "check-" + atividade;
                                                                            label.appendChild(document.createTextNode(atividade));
                                                                            div.appendChild(input);
                                                                            div.appendChild(label);
                                                                            modalBody.appendChild(div);
                                                                        });
                                                                    }

                                                                    function coletarDadosTabela(idTabela) {
                                                                        var tabela = document.getElementById(idTabela);
                                                                        var linhas = tabela.getElementsByTagName('tr');
                                                                        var dados = [];

                                                                        for (var i = 0; i < linhas.length; i++) {
                                                                            var celulas = linhas[i].getElementsByTagName('td');
                                                                            if (celulas.length > 0) {
                                                                                var linhaDados = {
                                                                                    dataPrevista: celulas[0].getElementsByTagName('input')[0].value,
                                                                                    dataRealizada: celulas[1].getElementsByTagName('input')[0].value,
                                                                                    responsabilidade: celulas[2].getElementsByTagName('input')[0].value,
                                                                                    observacao: celulas[3].getElementsByTagName('textarea')[0].value
                                                                                };
                                                                                dados.push(linhaDados);
                                                                            }
                                                                        }
                                                                        return dados;
                                                                    }

                                                                    function coletarDadosModal() {
                                                                        var checkboxes = document.querySelectorAll('#modalBody input[type="checkbox"]:checked');
                                                                        var atividadesSelecionadas = Array.from(checkboxes).map(checkbox => checkbox.value);
                                                                        return atividadesSelecionadas;
                                                                    }

                                                                    function enviarDados() {
                                                                        var dadosTabelaSemanal = coletarDadosTabela("tableBody");
                                                                        var dadosTabelaMensal = coletarDadosTabela("tableBodyMensal");
                                                                        var atividadesSelecionadas = coletarDadosModal();
                                                                        var idMaquina = document.getElementById('idMaquina').value.trim(); // Certifique-se de capturar o idMaquina

                                                                        var formData = new FormData();
                                                                        formData.append('dadosTabelaSemanal', JSON.stringify(dadosTabelaSemanal));
                                                                        formData.append('dadosTabelaMensal', JSON.stringify(dadosTabelaMensal));
                                                                        formData.append('atividadesSelecionadas', atividadesSelecionadas.join(','));
                                                                        formData.append('idMaquina', idMaquina); // Adiciona idMaquina ao FormData

                                                                        // Adicione um log para verificar o conteúdo do FormData
                                                                        for (var pair of formData.entries()) {
                                                                            console.log(pair[0] + ': ' + pair[1]);
                                                                        }

                                                                        fetch('includes/salvar_regManutencao004.inc.php', {
                                                                                method: 'POST',
                                                                                body: formData
                                                                            })
                                                                            .then(response => {
                                                                                return response.text(); // Recebe a resposta como texto
                                                                            })
                                                                            .then(text => {
                                                                                console.log('Resposta:', text); // Log da resposta para verificação
                                                                                return JSON.parse(text); // Tenta analisar como JSON
                                                                            })
                                                                            .then(data => {
                                                                                if (data.success) {
                                                                                    alert(data.message);
                                                                                } else {
                                                                                    alert(data.message);
                                                                                }
                                                                            })
                                                                            .catch(error => {
                                                                                console.error('Erro:', error);
                                                                                alert('Ocorreu um erro ao enviar os dados.');
                                                                            });
                                                                    }

                                                                    document.getElementById('submitModal').addEventListener('click', function() {
                                                                        enviarDados();
                                                                    });
                                                                </script>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <button class="btn btn-fab" type="submit" name="submit" id="submit">Salvar</button>
                                </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="js/scripts.js"></script>
        <script src="js/menu.js"></script>
        <script>
            <?php require_once "config/firebaseConfig.php"; ?>
            const firebaseConfig = <?php echo json_encode($firebaseConfig); ?>;
        </script>

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