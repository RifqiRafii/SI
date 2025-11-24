<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login SPK Garam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    
    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <div class="text-center mb-4">
            <h4 class="fw-bold text-primary">SPK Garam Madura</h4>
            <p class="text-muted">Silakan login untuk masuk</p>
        </div>

        <?php 
        if(isset($_GET['pesan'])){
            if($_GET['pesan'] == "gagal"){
                echo "<div class='alert alert-danger'>Login gagal! Username atau password salah.</div>";
            } else if($_GET['pesan'] == "logout"){
                echo "<div class='alert alert-success'>Anda berhasil logout.</div>";
            } else if($_GET['pesan'] == "belum_login"){
                echo "<div class='alert alert-warning'>Silakan login dulu.</div>";
            }
        }
        ?>

        <form action="cek_login.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>
    </div>

</body>
</html>