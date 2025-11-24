<?php
include 'koneksi.php';

$aksi = $_GET['aksi'];

// Tambah Data
if($aksi == "tambah"){
    $nama = $_POST['nama'];
    $c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $c4 = $_POST['c4'];
    $c5 = $_POST['c5'];

    mysqli_query($koneksi, "INSERT INTO alternatif VALUES(NULL, '$nama', '$c1', '$c2', '$c3', '$c4', '$c5')");
    header("location:data_petani.php?pesan=tambah_sukses");

// Edit Data
} elseif($aksi == "edit"){
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $c1 = $_POST['c1'];
    $c2 = $_POST['c2'];
    $c3 = $_POST['c3'];
    $c4 = $_POST['c4'];
    $c5 = $_POST['c5'];

    mysqli_query($koneksi, "UPDATE alternatif SET nama='$nama', c1='$c1', c2='$c2', c3='$c3', c4='$c4', c5='$c5' WHERE id='$id'");
    header("location:data_petani.php?pesan=edit_sukses");

// Hapus Data
} elseif($aksi == "hapus"){
    $id = $_GET['id'];
    mysqli_query($koneksi, "DELETE FROM alternatif WHERE id='$id'");
    header("location:data_petani.php?pesan=hapus_sukses");
}
?>