<?php
// File: smart_functions.php
// Berisi fungsi-fungsi untuk metode Simple Multi Attribute Rating Technique (SMART)
// dan helper untuk koneksi database.

// Pastikan file koneksi sudah dimasukkan sebelum file ini dipanggil di file utama
// require_once 'koneksi.php'; 

/**
 * Helper untuk format mata uang IDR
 */
function formatRupiah($number) {
    return 'Rp' . number_format($number, 0, ',', '.');
}

/**
 * FUNGSI INI DIGANTI: Fungsi ini kini berfungsi sebagai wrapper untuk mengambil 
 * data dari database jika koneksi tersedia.
 * @return array Data kriteria dan alternatif.
 */
function getDataFromDB() {
    // Coba buat koneksi
    $conn = koneksi_db();
    
    $kriteriaData = [];
    $alternatifData = [];
    $error = null;

    if ($conn) {
        // Koneksi berhasil, ambil data
        $kriteriaData = fetch_kriteria_from_db($conn);
        $alternatifData = fetch_alternatif_from_db($conn);
        $conn->close();
    } else {
        // Jika koneksi gagal (misalnya karena DB_PASS salah), gunakan data simulasi
        // agar aplikasi tetap bisa ditampilkan (fallback).
        $error = "Gagal terhubung ke database. Menampilkan data simulasi statis.";
        
        // Data Simulasi (sama persis dengan data manual Anda)
        $kriteriaData = [
            ['id' => 'C1', 'nama' => 'Biaya Tetap (Sewa, Pompa, dll)', 'tipe' => 'cost', 'bobot' => 20],
            ['id' => 'C2', 'nama' => 'Biaya Variabel (Tenaga, Angkut)', 'tipe' => 'cost', 'bobot' => 20],
            ['id' => 'C3', 'nama' => 'Jumlah Produksi (Ton)', 'tipe' => 'benefit', 'bobot' => 30],
            ['id' => 'C4', 'nama' => 'Harga Jual (Per Ton)', 'tipe' => 'benefit', 'bobot' => 20],
            ['id' => 'C5', 'nama' => 'Luas Lahan (Hektar)', 'tipe' => 'benefit', 'bobot' => 10],
        ];

        $alternatifData = [
            ['id' => 'A1', 'nama' => 'Petani A (Jurnal)', 'nilai' => ['C1' => 24509440.00, 'C2' => 14544200.00, 'C3' => 102.24, 'C4' => 1692000.00, 'C5' => 1.00]],
            ['id' => 'A2', 'nama' => 'Petani B', 'nilai' => ['C1' => 30000000.00, 'C2' => 17000000.00, 'C3' => 115.00, 'C4' => 1800000.00, 'C5' => 1.50]],
            ['id' => 'A3', 'nama' => 'Petani C', 'nilai' => ['C1' => 20000000.00, 'C2' => 10000000.00, 'C3' => 150.00, 'C4' => 2000000.00, 'C5' => 2.00]],
            ['id' => 'A4', 'nama' => 'Petani D', 'nilai' => ['C1' => 45000000.00, 'C2' => 25000000.00, 'C3' => 80.00, 'C4' => 1600000.00, 'C5' => 1.00]],
            ['id' => 'A5', 'nama' => 'Petani E', 'nilai' => ['C1' => 25000000.00, 'C2' => 12000000.00, 'C3' => 140.00, 'C4' => 1950000.00, 'C5' => 1.50]],
            ['id' => 'A6', 'nama' => 'Petani F', 'nilai' => ['C1' => 32000000.00, 'C2' => 15000000.00, 'C3' => 110.00, 'C4' => 1850000.00, 'C5' => 1.00]],
            ['id' => 'A7', 'nama' => 'Petani G', 'nilai' => ['C1' => 40000000.00, 'C2' => 20000000.00, 'C3' => 90.00, 'C4' => 1750000.00, 'C5' => 1.50]],
            ['id' => 'A8', 'nama' => 'Petani H', 'nilai' => ['C1' => 28000000.00, 'C2' => 13000000.00, 'C3' => 125.00, 'C4' => 1700000.00, 'C5' => 1.00]],
            ['id' => 'A9', 'nama' => 'Petani I', 'nilai' => ['C1' => 40000000.00, 'C2' => 20000000.00, 'C3' => 90.00, 'C4' => 1800000.00, 'C5' => 1.50]],
            ['id' => 'A10', 'nama' => 'Petani J', 'nilai' => ['C1' => 42000000.00, 'C2' => 22000000.00, 'C3' => 100.00, 'C4' => 1700000.00, 'C5' => 1.00]],
            ['id' => 'A11', 'nama' => 'Petani K', 'nilai' => ['C1' => 35000000.00, 'C2' => 17000000.00, 'C3' => 115.00, 'C4' => 1900000.00, 'C5' => 2.00]],
            ['id' => 'A12', 'nama' => 'Petani L', 'nilai' => ['C1' => 48000000.00, 'C2' => 28000000.00, 'C3' => 75.00, 'C4' => 1500000.00, 'C5' => 1.00]],
            ['id' => 'A13', 'nama' => 'Petani M', 'nilai' => ['C1' => 29000000.00, 'C2' => 13000000.00, 'C3' => 130.00, 'C4' => 1850000.00, 'C5' => 1.50]],
            ['id' => 'A14', 'nama' => 'Petani N', 'nilai' => ['C1' => 38000000.00, 'C2' => 19000000.00, 'C3' => 105.00, 'C4' => 1750000.00, 'C5' => 1.00]],
            ['id' => 'A15', 'nama' => 'Petani O', 'nilai' => ['C1' => 30000000.00, 'C2' => 14000000.00, 'C3' => 120.00, 'C4' => 1950000.00, 'C5' => 2.00]],
            ['id' => 'A16', 'nama' => 'Petani P', 'nilai' => ['C1' => 28000000.00, 'C2' => 13000000.00, 'C3' => 135.00, 'C4' => 1900000.00, 'C5' => 1.50]],
            ['id' => 'A17', 'nama' => 'Petani Q', 'nilai' => ['C1' => 40000000.00, 'C2' => 20000000.00, 'C3' => 100.00, 'C4' => 1700000.00, 'C5' => 1.00]],
            ['id' => 'A18', 'nama' => 'Petani R', 'nilai' => ['C1' => 35000000.00, 'C2' => 16000000.00, 'C3' => 120.00, 'C4' => 1800000.00, 'C5' => 1.00]],
        ];
    }
    
    return ['kriteria' => $kriteriaData, 'alternatif' => $alternatifData, 'error' => $error];
}

/**
 * Mendapatkan nilai Min dan Max untuk setiap kriteria.
 */
function getMinMaxValues($alternatifData, $kriteriaData) {
    // [Logika perhitungan tetap sama]
    $minMax = [];
    foreach ($kriteriaData as $k) {
        $values = array_column(array_column($alternatifData, 'nilai'), $k['id']);
        if (!empty($values)) {
            $minMax[$k['id']] = [
                'min' => min($values),
                'max' => max($values)
            ];
        }
    }
    return $minMax;
}

/**
 * Menghitung Nilai Utility (Normalisasi)
 */
function calculateUtility($Xij, $tipe, $min, $max) {
    // [Logika perhitungan tetap sama]
    if ($max == $min) {
        return 1.0;
    }
    if ($tipe == 'benefit') {
        return ($Xij - $min) / ($max - $min);
    } else {
        return ($max - $Xij) / ($max - $min);
    }
}

/**
 * Melakukan seluruh perhitungan SMART dan Perangkingan.
 */
function calculateSMART($alternatifData, $kriteriaData) {
    // [Logika perhitungan tetap sama]
    if (empty($alternatifData) || empty($kriteriaData)) {
        return [];
    }

    $minMax = getMinMaxValues($alternatifData, $kriteriaData);
    $results = [];

    foreach ($alternatifData as $alternatif) {
        $finalValue = 0;
        $utilityValues = [];

        foreach ($kriteriaData as $k) {
            $kId = $k['id'];
            $Xij = $alternatif['nilai'][$kId] ?? 0;
            $bobotNormalized = $k['bobot'] / 100;
            
            $minVal = $minMax[$kId]['min'] ?? 0;
            $maxVal = $minMax[$kId]['max'] ?? 0;

            // 1. Hitung Nilai Utility u(ai)
            $u_ai = calculateUtility($Xij, $k['tipe'], $minVal, $maxVal);
            $utilityValues[$kId] = $u_ai;

            // 2. Hitung Nilai Akhir (Ui) = Sum(Wj * u(ai))
            $finalValue += $bobotNormalized * $u_ai;
        }

        $results[] = [
            'id' => $alternatif['id'],
            'nama' => $alternatif['nama'],
            'finalValue' => $finalValue,
            'utilityValues' => $utilityValues,
        ];
    }

    // 3. Perangkingan
    usort($results, function ($a, $b) {
        return $b['finalValue'] <=> $a['finalValue'];
    });

    return $results;
}
?>