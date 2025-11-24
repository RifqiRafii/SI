<?php
// File: koneksi.php
// Konfigurasi koneksi database MySQL dan fungsi untuk mengambil data.

// Konfigurasi Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // Ganti dengan password MySQL Anda
define('DB_NAME', 'spk_garam_db'); // Nama database yang akan dibuat

// Fungsi untuk koneksi database (menggunakan MySQLi)
function koneksi_db() {
    // Suppress warnings in production, but show errors for debugging
    $conn = @new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Cek koneksi
    if ($conn->connect_error) {
        // Tampilkan error jika koneksi gagal (hanya di lingkungan dev)
        // Di lingkungan nyata, ini akan di-log, bukan di-die
        die("Koneksi database gagal: " . $conn->connect_error);
    }

    return $conn;
}

/**
 * Mengambil data kriteria dari tabel 'kriteria'.
 * @param mysqli $conn Objek koneksi database.
 * @return array Data kriteria.
 */
function fetch_kriteria_from_db($conn) {
    $kriteria = [];
    $sql = "SELECT id_kriteria, nama_kriteria, tipe_kriteria, bobot FROM kriteria ORDER BY id_kriteria ASC";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Pastikan bobot adalah integer
            $row['bobot'] = (int)$row['bobot'];
            $kriteria[] = [
                'id' => $row['id_kriteria'],
                'nama' => $row['nama_kriteria'],
                'tipe' => $row['tipe_kriteria'],
                'bobot' => $row['bobot']
            ];
        }
    }
    return $kriteria;
}

/**
 * Mengambil data alternatif dan nilai-nilainya dari tabel 'alternatif' dan 'nilai_alternatif'.
 * @param mysqli $conn Objek koneksi database.
 * @return array Data alternatif yang sudah termasuk nilai kriteria.
 */
function fetch_alternatif_from_db($conn) {
    $alternatif = [];
    
    // 1. Ambil semua alternatif
    $sql_alt = "SELECT id_alternatif, nama_alternatif FROM alternatif ORDER BY id_alternatif ASC";
    $result_alt = $conn->query($sql_alt);

    if ($result_alt && $result_alt->num_rows > 0) {
        while ($row_alt = $result_alt->fetch_assoc()) {
            $alternatif[$row_alt['id_alternatif']] = [
                'id' => $row_alt['id_alternatif'],
                'nama' => $row_alt['nama_alternatif'],
                'nilai' => [] // Akan diisi di langkah 2
            ];
        }
    }

    // 2. Ambil semua nilai kriteria
    $sql_nilai = "SELECT id_alternatif, id_kriteria, nilai FROM nilai_alternatif";
    $result_nilai = $conn->query($sql_nilai);

    if ($result_nilai && $result_nilai->num_rows > 0) {
        while ($row_nilai = $result_nilai->fetch_assoc()) {
            $alt_id = $row_nilai['id_alternatif'];
            $k_id = $row_nilai['id_kriteria'];
            $nilai = (float)$row_nilai['nilai'];
            
            // Masukkan nilai ke dalam struktur alternatif yang sudah ada
            if (isset($alternatif[$alt_id])) {
                $alternatif[$alt_id]['nilai'][$k_id] = $nilai;
            }
        }
    }
    
    // Kembalikan sebagai array yang diindeks secara numerik
    return array_values($alternatif);
}

// Catatan: Fungsi-fungsi di atas adalah *blueprint* untuk koneksi database nyata.
?>