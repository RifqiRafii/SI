<!DOCTYPE html>
<html>
<head>
    <title>Tambah Petani</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5 mb-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-success text-white">Tambah Data Petani</div>
            <div class="card-body">
                <form action="proses_petani.php?aksi=tambah" method="POST">
                    <div class="mb-3">
                        <label>Nama Petani</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>C1 (Biaya Tetap - Rp)</label>
                            <input type="number" name="c1" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label>C2 (Biaya Variabel - Rp)</label>
                            <input type="number" name="c2" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>C3 (Produksi - Ton)</label>
                            <input type="number" step="0.01" name="c3" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>C4 (Harga Jual - Rp)</label>
                            <input type="number" name="c4" class="form-control" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label>C5 (Lahan - Ha)</label>
                            <input type="number" step="0.1" name="c5" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success w-100">Simpan Data</button>
                    <a href="data_petani.php" class="btn btn-light w-100 mt-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>