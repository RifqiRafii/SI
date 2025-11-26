<?php
session_start();
if($_SESSION['status'] != "login"){
    header("location:login.php?pesan=belum_login");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Dashboard SPK Garam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        .rumus-box {
            background-color: #f8f9fa;
            border-left: 5px solid #0d6efd;
            padding: 15px;
            margin-bottom: 15px;
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php"><i class="bi bi-calculator"></i> SPK Garam Madura</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_kriteria.php">Data Kriteria</a></li>
                    <li class="nav-item"><a class="nav-link" href="data_petani.php">Petani (Alternatif)</a></li>
                    <li class="nav-item"><a class="nav-link" href="hasil.php">Hasil Perhitungan</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-danger btn-sm text-white ms-3 px-3" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container" style="margin-top: 80px;">
        
        <div class="alert alert-success shadow-sm border-0">
            <h4 class="alert-heading"><i class="bi bi-person-circle"></i> Selamat Datang, Admin!</h4>
            <p class="mb-0">Sistem Pendukung Keputusan Pemilihan Usaha Tani Garam Paling Efisien di Kecamatan Pademawu.</p>
        </div>

        <div class="row">
            <div class="col-md-7">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-book"></i> Apa itu Metode SMART?</h5>
                    </div>
                    <div class="card-body">
                        <p class="text-justify">
                            <strong>SMART</strong> (<em>Simple Multi Attribute Rating Technique</em>) adalah metode pengambilan keputusan multi-kriteria yang dikembangkan oleh Edward pada tahun 1977. 
                        </p>
                        <p>
                            Metode ini bekerja dengan cara memberikan bobot pada setiap kriteria yang menggambarkan seberapa penting kriteria tersebut dibandingkan dengan kriteria lainnya.
                        </p>
                        <hr>
                        <h6 class="fw-bold text-primary">Langkah-Langkah Perhitungan:</h6>
                        <ol class="list-group list-group-numbered list-group-flush">
                            <li class="list-group-item">Identifikasikan <strong>Kriteria</strong> dan <strong>Pembobotan.</strong></li>
                            <li class="list-group-item">Melakukan <strong>Normalisasi Bobot</strong> (Total bobot harus = 1).</li>
                            <li class="list-group-item">Menentukan <strong>Alternatif</strong> (Data Petani yang akan dinilai).</li>
                            <li class="list-group-item">Menentukan Nilai <strong>Utility</strong> (Mengubah data mentah ke skala 0-1).</li>
                            <li class="list-group-item">Menghitung <strong>Nilai Akhir</strong> (Perankingan).</li>
                        </ol>
                    </div>
                </div>
            </div>

            <div class="col-md-5">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-dark text-white">
                        <h5 class="mb-0"><i class="bi bi-code-slash"></i> Rumus Perhitungan</h5>
                    </div>
                    <div class="card-body">
                        
                        <h6 class="fw-bold">1. Rumus Utility (Normalisasi Data)</h6>
                        <p class="text-muted small mb-1">Digunakan untuk mengubah Rupiah/Ton/Ha menjadi angka 0 s.d 1.</p>
                        
                        <div class="rumus-box">
                            <span class="text-success">Kriteria Benefit (Keuntungan):</span><br>
                            (Nilai - Min) / (Max - Min)
                            <br><span class="text-danger">Note : Benefit semakin besar nilai nya maka akan semakin baik</span>
                        </div>
                        
                        <div class="rumus-box">
                            <span class="text-success">Kriteria Cost (Biaya):</span><br>
                            (Max - Nilai) / (Max - Min)
                            <br><span class="text-danger">Note : Cost semakin kecil nilai nya maka akan semakin baik</span>
                        </div>

                        <h6 class="fw-bold mt-4">2. Rumus Nilai Akhir</h6>
                        <p class="text-muted small mb-1">Menjumlahkan hasil kali Utility dengan Bobot.</p>
                        <div class="rumus-box">
                            Nilai = Σ (Utility × Bobot)
                        </div>

                        <div class="alert alert-info mt-3">
                            <i class="bi bi-info-circle-fill"></i> <strong>Keterangan:</strong><br>
                            Nilai Akhir tertinggi akan menjadi <strong>Ranking 1</strong> (Prioritas Utama).
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-5">
            <div class="col-md-4">
                <div class="card text-center shadow-sm border-primary">
                    <div class="card-body">
                        <h5 class="card-title">Data Kriteria</h5>
                        <p class="card-text">Atur bobot dan sifat kriteria.</p>
                        <a href="data_kriteria.php" class="btn btn-outline-primary w-100">Kelola Kriteria</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm border-success">
                    <div class="card-body">
                        <h5 class="card-title">Data Petani</h5>
                        <p class="card-text">Input data alternatif petani.</p>
                        <a href="data_petani.php" class="btn btn-outline-success w-100">Kelola Petani</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center shadow-sm border-warning">
                    <div class="card-body">
                        <h5 class="card-title">Hasil Perhitungan</h5>
                        <p class="card-text">Lihat ranking dan rekomendasi.</p>
                        <a href="hasil.php" class="btn btn-outline-warning w-100">Lihat Hasil</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>