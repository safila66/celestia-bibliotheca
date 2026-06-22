<?= $this->extend('admin/template') ?>

<?= $this->section('styles') ?>
<style>
    .scanner-container {
        max-width: 600px;
        margin: 40px auto;
        background: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        text-align: center;
    }
    .scanner-header {
        margin-bottom: 20px;
    }
    .scanner-header h2 {
        color: var(--deep-navy, #0D1535);
        font-family: 'Cinzel', serif;
        margin-top: 0;
    }
    #reader {
        width: 100%;
        margin-bottom: 20px;
    }
    #reader button {
        background: var(--gold, #C9A84C);
        color: #fff;
        border: none;
        padding: 8px 16px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }
    #scanResult {
        display: none;
        padding: 15px;
        border-radius: 4px;
        background: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        margin-top: 20px;
        font-weight: bold;
    }
    #scanError {
        display: none;
        padding: 15px;
        border-radius: 4px;
        background: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        margin-top: 20px;
        font-weight: bold;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="scanner-container">
    <div class="scanner-header">
        <h2>QR Code Scanner</h2>
        <p>Arahkan QR Code pengunjung ke kamera untuk verifikasi.</p>
    </div>
    
    <div id="reader"></div>

    <div id="scanResult"></div>
    <div id="scanError"></div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false
        );
        
        let isProcessing = false;

        function onScanSuccess(decodedText, decodedResult) {
            if (isProcessing) return;
            isProcessing = true;
            
            // Tampilkan pesan loading
            const resultDiv = document.getElementById('scanResult');
            const errorDiv = document.getElementById('scanError');
            
            resultDiv.style.display = 'none';
            errorDiv.style.display = 'none';
            
            html5QrcodeScanner.pause();
            
            fetch(decodedText, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            })
            .then(response => {
                if(!response.ok) throw new Error("Respons jaringan bermasalah.");
                return response.json();
            })
            .then(data => {
                if(data.status === 'success') {
                    resultDiv.innerText = "✅ " + data.message;
                    resultDiv.style.display = 'block';
                } else {
                    errorDiv.innerText = "❌ Gagal memverifikasi tiket.";
                    errorDiv.style.display = 'block';
                }
                
                // Resume scanner setelah 3 detik
                setTimeout(() => { 
                    resultDiv.style.display = 'none';
                    errorDiv.style.display = 'none';
                    isProcessing = false;
                    html5QrcodeScanner.resume(); 
                }, 3000);
            })
            .catch(err => {
                errorDiv.innerText = "❌ URL QR Code tidak valid atau error sistem.";
                errorDiv.style.display = 'block';
                
                setTimeout(() => { 
                    errorDiv.style.display = 'none';
                    isProcessing = false;
                    html5QrcodeScanner.resume(); 
                }, 3000);
            });
        }

        function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning
        }

        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    });
</script>
<?= $this->endSection() ?>
