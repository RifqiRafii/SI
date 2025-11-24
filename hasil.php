<?php
session_start();
include 'koneksi.php';
include 'smart_functions.php';

if($_SESSION['status'] != "login"){ header("location:login.php"); }

// Inisialisasi Objek SMART
$spk = new SmartSPK($koneksi);
$data_ranking = $spk->hitung(); // Ini data yang sudah diurutkan berdasarkan Ranking

// Kita buat copy data untuk tabel awal (biar urut abjad sesuai nama Petani, bukan ranking)
$data_awal = $data_ranking;
usort($data_awal, function($a, $b) {
    return strcmp($a['nama'], $b['nama']); // Urutkan berdasarkan Nama A-Z
});

// Definisi Bobot (Untuk ditampilkan)
$bobot = [
    'C1' => 0.2, 'C2' => 0.2, 'C3' => 0.3, 'C4' => 0.2, 'C5' => 0.1
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Detail Perhitungan SPK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">SPK Garam</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Kembali ke Dashboard</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <h2 class="mb-4 text-center">Detail Perhitungan Metode SMART</h2>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-secondary text-white">
                <h5 class="mb-0">1. Kriteria dan Bobot</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-sm w-auto">
                    <thead class="table-light">
                        <tr>
                            <th>Kode</th><th>Nama Kriteria</th><th>Sifat</th><th>Bobot</th><th>Normalisasi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr><td>C1</td><td>Biaya Tetap</td><td>Cost</td><td>20</td><td><?= $bobot['C1'] ?></td></tr>
                        <tr><td>C2</td><td>Biaya Variabel</td><td>Cost</td><td>20</td><td><?= $bobot['C2'] ?></td></tr>
                        <tr><td>C3</td><td>Jumlah Produksi</td><td>Benefit</td><td>30</td><td><?= $bobot['C3'] ?></td></tr>
                        <tr><td>C4</td><td>Harga Jual</td><td>Benefit</td><td>20</td><td><?= $bobot['C4'] ?></td></tr>
                        <tr><td>C5</td><td>Luas Lahan</td><td>Benefit</td><td>10</td><td><?= $bobot['C5'] ?></td></tr>
                        <tr class="fw-bold">
                            <td colspan="3" class="text-end">Total</td><td>100</td><td>1.0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">2. Data Alternatif (Mentah)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-sm">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>Nama Petani</th>
                                <th>C1 (Biaya Tetap)</th>
                                <th>C2 (Biaya Var)</th>
                                <th>C3 (Produksi)</th>
                                <th>C4 (Harga)</th>
                                <th>C5 (Lahan)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_awal as $row): ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td class="text-end"><?= number_format($row['c1'], 0, ',', '.') ?></td>
                                <td class="text-end"><?= number_format($row['c2'], 0, ',', '.') ?></td>
                                <td class="text-center"><?= $row['c3'] ?></td>
                                <td class="text-end"><?= number_format($row['c4'], 0, ',', '.') ?></td>
                                <td class="text-center"><?= $row['c5'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">3. Nilai Utility (Normalisasi 0-1)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>Nama Petani</th>
                                <th>U_C1</th><th>U_C2</th><th>U_C3</th><th>U_C4</th><th>U_C5</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_awal as $row): ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td class="text-center"><?= number_format($row['u1'], 4) ?></td>
                                <td class="text-center"><?= number_format($row['u2'], 4) ?></td>
                                <td class="text-center"><?= number_format($row['u3'], 4) ?></td>
                                <td class="text-center"><?= number_format($row['u4'], 4) ?></td>
                                <td class="text-center"><?= number_format($row['u5'], 4) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">4. Perhitungan Nilai Akhir (Utility x Bobot)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-sm">
                        <thead class="table-success text-center">
                            <tr>
                                <th rowspan="2" class="align-middle">Nama Petani</th>
                                <th>C1</th><th>C2</th><th>C3</th><th>C4</th><th>C5</th>
                                <th rowspan="2" class="align-middle bg-dark text-white">Total Nilai</th>
                            </tr>
                            <tr>
                                <th>(x 0.2)</th><th>(x 0.2)</th><th>(x 0.3)</th><th>(x 0.2)</th><th>(x 0.1)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data_awal as $row): 
                                // Hitung manual per kolom untuk ditampilkan
                                $sc1 = $row['u1'] * 0.2;
                                $sc2 = $row['u2'] * 0.2;
                                $sc3 = $row['u3'] * 0.3;
                                $sc4 = $row['u4'] * 0.2;
                                $sc5 = $row['u5'] * 0.1;
                            ?>
                            <tr>
                                <td><?= $row['nama'] ?></td>
                                <td class="text-center text-muted"><?= number_format($sc1, 4) ?></td>
                                <td class="text-center text-muted"><?= number_format($sc2, 4) ?></td>
                                <td class="text-center text-muted"><?= number_format($sc3, 4) ?></td>
                                <td class="text-center text-muted"><?= number_format($sc4, 4) ?></td>
                                <td class="text-center text-muted"><?= number_format($sc5, 4) ?></td>
                                <td class="text-center fw-bold bg-light"><?= number_format($row['nilai_akhir'], 4) ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-primary">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0 text-center">5. Hasil Perankingan Final</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-success text-center">
                    Rekomendasi Terbaik adalah <strong><?= $data_ranking[0]['nama'] ?></strong> 
                    dengan Nilai Akhir <strong><?= number_format($data_ranking[0]['nilai_akhir'], 4) ?></strong>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="table-dark text-center">
                            <tr>
                                <th width="10%">Ranking</th>
                                <th>Nama Petani</th>
                                <th>Nilai Akhir</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $rank = 1;
                            foreach($data_ranking as $row): 
                            ?>
                            <tr class="<?= ($rank==1) ? 'table-warning fw-bold' : '' ?>">
                                <td class="text-center"><?= $rank ?></td>
                                <td><?= $row['nama'] ?></td>
                                <td class="text-center"><?= number_format($row['nilai_akhir'], 4) ?></td>
                                <td class="text-center">
                                    <?php 
                                    if($rank <= 3) echo "<span class='badge bg-success'>Sangat Layak</span>";
                                    elseif($rank <= 15) echo "<span class='badge bg-info text-dark'>Cukup Layak</span>";
                                    else echo "<span class='badge bg-danger'>Kurang Layak</span>";
                                    ?>
                                </td>
                            </tr>
                            <?php 
                            $rank++;
                            endforeach; 
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>
</html>