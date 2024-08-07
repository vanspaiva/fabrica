<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seu Título</title>
    <!-- Inclua Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="col-sm-4 mt-2">    
        <div class="card shadow rounded py-2" style="border-top: #007A5A 7px solid;">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <h6 class="deactivated"><b>Módulo Ordem Produção</b></h6>
                </div>
                <hr>
                <div class="row d-flex justify-content-center my-1 py-1">
                    <div class="d-flex justify-content-between px-2">
                        <a href="novaos?t=op" class="btn btn-info mx-1"><i class="fas fa-plus"></i> Nova OP </a>
                        <a href="opetapas" class="btn btn-outline-info mx-1"> <i class="fas fa-th-large"></i> Etapas</a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="firstVisitModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Bem-vindo!</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Seja bem-vindo ao nosso site pela primeira vez! <br>
                    Para completar seu cadastro, por favor, clique no link abaixo:
                    <a href="pagina-de-cadastro.html" class="btn btn-primary mt-2">Completar Cadastro</a>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclua jQuery, Popper.js e Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function checkFirstVisit() {
            const visitFlag = 'firstVisit';
            if (!localStorage.getItem(visitFlag)) {
                localStorage.setItem(visitFlag, 'true');
                return true; // É a primeira visita
            }
            return false; // Não é a primeira visita
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (checkFirstVisit()) {
                $('#firstVisitModal').modal('show');
                alert("Bem-vindo ao nosso site pela primeira vez!"); // Alerta para primeira visita
            } else {
                alert("Bem-vindo de volta!"); // Alerta para visitas subsequentes
            }
        });
    </script>
</body>
</html>
