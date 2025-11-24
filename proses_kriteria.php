<?php
include 'koneksi.php';

$kode = $_POST['kode'];
$nama = $_POST['nama'];
$sifat = $_POST['sifat'];
$bobot = $_POST['bobot'];

mysqli_query($koneksi, "UPDATE tb_kriteria SET nama='$nama', sifat='$sifat', bobot='$bobot' WHERE kode='$kode'");

header("location:data_kriteria.php");
?>e