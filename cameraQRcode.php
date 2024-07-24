<?php
session_start();

if (isset($_SESSION["useruid"])) {
    include("php/head_index.php");
    require_once 'db/dbh.php';
} else {
    header("location: login");
    exit();
}
?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://unpkg.com/html5-qrcode/minified/html5-qrcode.min.js"></script>
<style>
    main {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        margin: 10px;
    }
    #reader {
        width: 300px;
        height: 350px;
    }
</style>
<body>
    <?php
    include_once 'php/navbar.php';
    include_once 'php/lateral-nav.php';
    ?>
    <main>
    <button id="start-scan-btn" class="btn btn-primary m-5">Iniciar Leitura</button>
    <div id="reader"></div>
    </main>
    <script>
        document.getElementById('start-scan-btn').addEventListener('click', function() {
            Html5Qrcode.getCameras().then(devices => {
                if (devices && devices.length) {
                    let backCameraId = devices[0].id;
                    for (let i = 0; i < devices.length; i++) {
                        if (devices[i].label.toLowerCase().includes('back')) {
                            backCameraId = devices[i].id;
                            break;
                        }
                    }
                    const html5QrCode = new Html5Qrcode("reader");
                    html5QrCode.start(
                        backCameraId,
                        {
                            fps: 10,
                            qrbox: 250,
                            rememberLastUsedCamera: true,
                            supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
                        },
                        (decodedText, decodedResult) => {
                            console.log(`Código lido: ${decodedText}`);
                            window.location.href = decodedText; // Redireciona para o URL lido
                        },
                        (errorMessage) => {
                            console.log(`Erro na leitura: ${errorMessage}`);
                        }
                    ).catch(err => {
                        console.error(`Falha ao iniciar a leitura: ${err}`);
                    });
                }
            }).catch(err => {
                console.error(`Erro ao obter as câmeras: ${err}`);
            });
        });
    </script>
</body>
<?php include_once 'php/footer_index.php' ?>
