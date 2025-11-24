<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard SPK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">SPK Garam</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_petani.php">Data Petani</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil.php">Hasil Perhitungan</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white ms-3" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="p-5 mb-4 bg-light rounded-3 shadow-sm">
            <div class="container-fluid py-3">
                <h1 class="display-5 fw-bold">Halo Admin!</h1>
                <p class="col-md-8 fs-4">Selamat datang di Sistem Pendukung Keputusan.</p>
                <hr>
                <p>Sistem ini menggunakan metode <strong>SMART (Simple Multi Attribute Rating Technique)</strong> untuk menentukan prioritas petani garam berdasarkan efisiensi biaya dan hasil produksi.</p>
                <a class="btn btn-primary btn-lg" href="hasil.php">Lihat Ranking</a>
            </div>
        </div>
    </div>

</body>
</html>