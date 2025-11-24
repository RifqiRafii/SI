<?php
session_start();
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM tb_kriteria WHERE kode='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Kriteria</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Edit Kriteria <?php echo $d['kode']; ?></div>
            <div class="card-body">
                <form action="proses_kriteria.php" method="POST">
                    <input type="hidden" name="kode" value="<?php echo $d['kode']; ?>">
                    <div class="mb-3">
                        <label>Nama Kriteria</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $d['nama']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label>Sifat</label>
                        <select name="sifat" class="form-select">
                            <option value="Cost" <?php if($d['sifat']=='Cost') echo 'selected'; ?>>Cost</option>
                            <option value="Benefit" <?php if($d['sifat']=='Benefit') echo 'selected'; ?>>Benefit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Bobot (Desimal, cth: 0.2)</label>
                        <input type="number" step="0.01" name="bobot" class="form-control" value="<?php echo $d['bobot']; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                    <a href="data_kriteria.php" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>