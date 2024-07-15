<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';
}
else {
    header("location: login");
    exit();
}
?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<style>

    main{
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        height: calc(100vh - 300px);
    }
    #reader {
            width: 300px; /* Ajuste o tamanho desejado */
            height: 300px;
        }
</style>
<body>
    <?php
        include_once 'php/navbar.php';
        include_once 'php/lateral-nav.php';
    ?>
    <main>
        <div id="reader"></div>
        <input class="btn " type="file" id="file-input" accept="image/*" />
    </main>
<script>
// Primeiro, obtemos a lista de câmeras disponíveis
Html5Qrcode.getCameras().then(devices => {
    if (devices && devices.length) {
        // Seleciona a primeira câmera disponível
        var cameraId = devices[0].id;

        // Cria uma instância do Html5Qrcode e inicia a leitura do QR code
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.start(
            cameraId,
            {
                fps: 10,    // Opcional, frames por segundo para a leitura do QR code
                qrbox: { width: 250, height: 250 }  // Opcional, caixa delimitadora para a UI
            },
            (decodedText, decodedResult) => {
                // Ação a ser realizada quando um código for lido
                console.log(`Código lido: ${decodedText}`);
            },
            (errorMessage) => {
                // Erro na leitura, ignorar
                console.log(`Erro na leitura: ${errorMessage}`);
            }
        ).catch(err => {
            // Falha ao iniciar a leitura, tratar o erro
            console.error(`Falha ao iniciar a leitura: ${err}`);
        });
    }
}).catch(err => {
    // Falha ao obter as câmeras, tratar o erro
    console.error(`Erro ao obter as câmeras: ${err}`);
});

document.getElementById('file-input').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const html5QrCode = new Html5Qrcode("reader");
        html5QrCode.scanFile(file, true)
            .then(decodedText => {
                // Redireciona imediatamente para o URL lido da imagem
                window.location.href = decodedText;
            })
            .catch(err => {
                // Falha ao ler o QR code da imagem, tratar o erro
                console.error(`Erro ao ler o QR code da imagem: ${err}`);
            });
    }
});
</script>
</body>
<?php include_once 'php/footer_index.php' ?>