<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite('resources/css/app.css')
</head>

<style>
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(255, 255, 255, 0.8);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .loading-infinity {
        border: 4px solid rgba(0, 0, 0, 0.3);
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 2s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>
<body>
    <div class="loading-overlay" id="loadingOverlay" style="display: none;">
        <span class="loading loading-ring loading-lg"></span>
    </div>

    <script>
        var isLoading = false;

        window.onbeforeunload = function() {
            isLoading = true;
            document.getElementById('loadingOverlay').style.display = 'flex';
        };

        // Assuming this is your AJAX success function
        function handleSuccess() {
            console.log('Success!');
            isLoading = false;
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Sukses', 'Data telah diperbarui', 'success');
            setTimeout(function () {
                location.reload();
            }, 10);
        }

        // Assuming this is your AJAX error function
        function handleError() {
            console.error('Error');
            isLoading = false;
            document.getElementById('loadingOverlay').style.display = 'none';
            Swal.fire('Error', 'Terjadi kesalahan', 'error');
        }

        // Simulating an AJAX call with setTimeout
        setTimeout(function() {
            if (isLoading) {
                // If the loading flag is still true, simulate a successful response
                handleSuccess();
            }
        }, 2000);
    </script>
</body>
</html>
