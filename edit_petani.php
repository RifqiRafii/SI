<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_query($koneksi, "SELECT * FROM alternatif WHERE id='$id'");
$d = mysqli_fetch_array($data);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Petani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">Edit Data Petani</div>
            <div class="card-body">
                <form action="proses_petani.php?aksi=edit" method="POST">
                    <input type="hidden" name="id" value="<?php echo $d['id']; ?>">
                    
                    <div class="mb-3">
                        <label>Nama Petani</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $d['nama']; ?>" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>C1 (Biaya Tetap)</label>
                            <input type="number" name="c1" class="form-control" value="<?php echo $d['c1']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>C2 (Biaya Variabel)</label>
                            <input type="number" name="c2" class="form-control" value="<?php echo $d['c2']; ?>" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>C3 (Produksi)</label>
                            <input type="number" step="0.01" name="c3" class="form-control" value="<?php echo $d['c3']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>C4 (Harga)</label>
                            <input type="number" name="c4" class="form-control" value="<?php echo $d['c4']; ?>" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>C5 (Lahan)</label>
                            <input type="number" step="0.1" name="c5" class="form-control" value="<?php echo $d['c5']; ?>" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Update Data</button>
                    <a href="data_petani.php" class="btn btn-light w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>