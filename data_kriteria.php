<?php
session_start();
include 'koneksi.php';
if($_SESSION['status'] != "login"){ header("location:login.php"); }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Data Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">SPK Garam</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Dashboard</a>
                <a class="nav-link active" href="data_kriteria.php">Kriteria</a>
                <a class="nav-link" href="data_petani.php">Petani (Alternatif)</a>
                <a class="nav-link" href="hasil.php">Hasil</a>
                <a class="nav-link btn btn-danger btn-sm text-white ms-3" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Data Kriteria & Bobot</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kriteria</th>
                            <th>Sifat</th>
                            <th>Bobot</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = mysqli_query($koneksi, "SELECT * FROM tb_kriteria");
                        while($d = mysqli_fetch_array($data)){
                        ?>
                        <tr>
                            <td><b><?php echo $d['kode']; ?></b></td>
                            <td><?php echo $d['nama']; ?></td>
                            <td>
                                <span class="badge <?php echo ($d['sifat']=='Benefit')?'bg-success':'bg-danger'; ?>">
                                    <?php echo $d['sifat']; ?>
                                </span>
                            </td>
                            <td><?php echo $d['bobot']; ?></td>
                            <td>
                                <a href="edit_kriteria.php?id=<?php echo $d['kode']; ?>" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>