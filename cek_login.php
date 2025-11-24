<?php
session_start();
include 'koneksi.php';

// Menangkap data yang dikirim dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Seleksi data admin dengan username dan password yang sesuai
$data = mysqli_query($koneksi,"SELECT * from tb_admin where username='$username' and password='$password'");

// Menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($data);

if($cek > 0){
    $_SESSION['username'] = $username;
    $_SESSION['status'] = "login";
    header("location: index.php");
}else{
    header("location: login.php?pesan=gagal");
}
?>