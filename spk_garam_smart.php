<?php
// File: spk_garam_smart.php
// Halaman utama SPK Usaha Garam.

// Memasukkan file fungsi dan koneksi
require_once 'koneksi.php'; // Diaktifkan agar fungsi koneksi_db() dapat dipanggil
require_once 'smart_functions.php';

// Mendapatkan data (Mengganti getSimulatedData() dengan getDataFromDB())
$data = getDataFromDB(); 
$kriteriaData = $data['kriteria'];
$alternatifData = $data['alternatif'];
$dbError = $data['error'] ?? null;

// Jalankan Perhitungan SMART
$smartResults = calculateSMART($alternatifData, $kriteriaData);

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SPK Usaha Garam - Metode SMART (Modular PHP)</title>
    
    <!-- Bootstrap 5 CDN for CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
            margin-bottom: 50px;
        }
        .table-responsive-scroll {
            max-height: 400px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .table thead th {
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            z-index: 10;
        }
        .ranking-1 {
            background-color: #ffc107 !important; /* Yellow for best rank */
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <header class="mb-4 border-bottom pb-3">
        <h1 class="display-5 text-primary">SPK Usaha Garam (Metode SMART - Database Ready)</h1>
        <p class="lead text-muted">Aplikasi Pendukung Keputusan yang siap mengambil data dari MySQL.</p>
        <p class="small text-muted">Perhitungan dilakukan oleh fungsi di `smart_functions.php`.</p>
        
        <?php if ($dbError) : ?>
            <div class="alert alert-warning" role="alert">
                <strong>Peringatan!</strong> <?php echo $dbError; ?> Silakan periksa pengaturan database Anda di `koneksi.php`.
            </div>
        <?php else : ?>
            <div class="alert alert-success py-2" role="alert">
                Data diambil langsung dari database.
            </div>
        <?php endif; ?>
    </header>

    <div class="row">
        <!-- Kolom Kriteria dan Bobot -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">1. Kriteria & Bobot</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Kriteria</th>
                                <th class="text-center">Bobot (%)</th>
                                <th class="text-center">Tipe</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($kriteriaData as $k) : ?>
                            <tr>
                                <td><?php echo $k['nama']; ?></td>
                                <td class="text-center"><?php echo $k['bobot']; ?></td>
                                <td class="text-center"><span class="badge bg-<?php echo ($k['tipe'] === 'benefit' ? 'success' : 'danger'); ?>"><?php echo ucfirst($k['tipe']); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>Total</th>
                                <th class="text-center">100</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Kolom Data Alternatif dan Hasil -->
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">2. Data Nilai Alternatif (<?php echo count($alternatifData); ?> Petani)</h5>
                </div>
                <div class="card-body table-responsive-scroll">
                    <table class="table table-bordered table-sm">
                        <thead class="bg-light">
                            <tr>
                                <th>Alternatif</th>
                                <?php foreach ($kriteriaData as $k) : ?>
                                <th class="text-center"><?php echo $k['nama']; ?><br><small>(<?php echo ucfirst($k['tipe']); ?>)</small></th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($alternatifData as $a) : ?>
                            <tr>
                                <td><?php echo $a['nama']; ?></td>
                                <?php foreach ($kriteriaData as $k) : ?>
                                <td class="text-end">
                                    <?php 
                                        $value = $a['nilai'][$k['id']] ?? 0;
                                        // Cek apakah kriteria adalah mata uang (C1, C2) atau angka biasa (C3, C5)
                                        if ($k['id'] === 'C1' || $k['id'] === 'C2') {
                                            echo formatRupiah($value);
                                        } else {
                                            echo number_format($value, 2, ',', '.'); // Untuk Ton dan Ha
                                        }
                                    ?>
                                </td>
                                <?php endforeach; ?>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">3. Hasil Perangkingan SMART</h5>
                </div>
                <div class="card-body table-responsive-scroll">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th class="text-center bg-success text-white">Rank</th>
                                <th class="bg-success text-white">Alternatif</th>
                                <th class="text-center bg-success text-white">Nilai Akhir (Ui)</th>
                                <!-- Headers Utility (u(ai)) -->
                                <?php foreach ($kriteriaData as $index => $k) : ?>
                                <th class="text-center bg-success text-white">Utility u(C<?php echo $index + 1; ?>)</th>
                                <?php endforeach; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($smartResults)) : ?>
                                <tr><td colspan="<?php echo count($kriteriaData) + 3; ?>" class="text-center py-4 text-muted">Tidak ada data untuk dihitung.</td></tr>
                            <?php else : ?>
                                <?php foreach ($smartResults as $index => $result) : ?>
                                <tr class="<?php echo ($index === 0 ? 'ranking-1' : ''); ?>">
                                    <td class="text-center"><?php echo $index + 1; ?></td>
                                    <td><?php echo $result['nama']; ?></td>
                                    <td class="text-center"><?php echo number_format($result['finalValue'], 4); ?></td>
                                    <?php foreach ($kriteriaData as $k) : ?>
                                    <td class="text-center"><?php echo number_format($result['utilityValues'][$k['id']] ?? 0, 4); ?></td>
                                    <?php endforeach; ?>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 CDN for JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

</body>
</html>