<?php
session_start();
include 'koneksi.php';
if($_SESSION['status'] != "login"){ header("location:login.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Petani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">SPK Garam</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Dashboard</a>
                <a class="nav-link" href="data_kriteria.php">Kriteria</a>
                <a class="nav-link active" href="data_petani.php">Petani (Alternatif)</a>
                <a class="nav-link" href="hasil.php">Hasil</a>
                <a class="nav-link btn btn-danger btn-sm text-white ms-3" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Alternatif (20 Petani)</h5>
                <a href="tambah_petani.php" class="btn btn-success btn-sm">+ Tambah Petani</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>No</th>
                                <th>Nama Petani</th>
                                <th>C1 (Biaya Tetap)</th>
                                <th>C2 (Biaya Var)</th>
                                <th>C3 (Produksi)</th>
                                <th>C4 (Harga)</th>
                                <th>C5 (Lahan)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $data = mysqli_query($koneksi, "SELECT * FROM alternatif ORDER BY id ASC");
                            while($d = mysqli_fetch_array($data)){
                            ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td><?php echo $d['nama']; ?></td>
                                <td class="text-end">Rp <?php echo number_format($d['c1']); ?></td>
                                <td class="text-end">Rp <?php echo number_format($d['c2']); ?></td>
                                <td class="text-center"><?php echo $d['c3']; ?> Ton</td>
                                <td class="text-end">Rp <?php echo number_format($d['c4']); ?></td>
                                <td class="text-center"><?php echo $d['c5']; ?> Ha</td>
                                <td class="text-center" width="150px">
                                    <a href="edit_petani.php?id=<?php echo $d['id']; ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <a href="proses_petani.php?aksi=hapus&id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>