-- File: db_setup_and_insert.sql
-- Script SQL ini akan:
-- 1. Membuat database 'spk_garam_db' (jika belum ada).
-- 2. Membuat tabel Kriteria, Alternatif, dan Nilai_Alternatif.
-- 3. Mengisi tabel dengan data 5 Kriteria dan 18 Alternatif sesuai perhitungan manual Anda.

-- -------------------------------------------
-- LANGKAH 1: SETUP DATABASE DAN TABEL
-- -------------------------------------------

-- Membuat database (jika belum ada) dan menggunakannya
CREATE DATABASE IF NOT EXISTS spk_garam_db;
USE spk_garam_db;

-- 1. Membuat Tabel Kriteria
CREATE TABLE IF NOT EXISTS kriteria (
    id_kriteria VARCHAR(10) PRIMARY KEY,
    nama_kriteria VARCHAR(100) NOT NULL,
    tipe_kriteria ENUM('benefit', 'cost') NOT NULL,
    bobot INT NOT NULL,
    CHECK (bobot >= 0 AND bobot <= 100)
);

-- 2. Membuat Tabel Alternatif
CREATE TABLE IF NOT EXISTS alternatif (
    id_alternatif VARCHAR(10) PRIMARY KEY,
    nama_alternatif VARCHAR(100) NOT NULL
);

-- 3. Membuat Tabel Nilai Alternatif (Matriks Keputusan)
CREATE TABLE IF NOT EXISTS nilai_alternatif (
    id_nilai INT AUTO_INCREMENT PRIMARY KEY,
    id_alternatif VARCHAR(10) NOT NULL,
    id_kriteria VARCHAR(10) NOT NULL,
    nilai DECIMAL(15, 2) NOT NULL,
    FOREIGN KEY (id_alternatif) REFERENCES alternatif(id_alternatif) ON DELETE CASCADE,
    FOREIGN KEY (id_kriteria) REFERENCES kriteria(id_kriteria) ON DELETE CASCADE,
    UNIQUE KEY unique_nilai (id_alternatif, id_kriteria)
);

-- -------------------------------------------
-- LANGKAH 2: PENGHAPUSAN DAN PENGISIAN DATA
-- -------------------------------------------

-- Hapus data lama (penting jika script dijalankan ulang)
DELETE FROM nilai_alternatif;
DELETE FROM kriteria;
DELETE FROM alternatif;

-- PENGISIAN DATA KRITERIA (5 Kriteria)
INSERT INTO kriteria (id_kriteria, nama_kriteria, tipe_kriteria, bobot) VALUES
('C1', 'Biaya Tetap (Sewa, Pompa, dll)', 'cost', 20),
('C2', 'Biaya Variabel (Tenaga, Angkut)', 'cost', 20),
('C3', 'Jumlah Produksi (Ton)', 'benefit', 30),
('C4', 'Harga Jual (Per Ton)', 'benefit', 20),
('C5', 'Luas Lahan (Hektar)', 'benefit', 10);

-- PENGISIAN DATA ALTERNATIF (18 Petani)
INSERT INTO alternatif (id_alternatif, nama_alternatif) VALUES
('A1', 'Petani A (Jurnal)'), ('A2', 'Petani B'), ('A3', 'Petani C'), 
('A4', 'Petani D'), ('A5', 'Petani E'), ('A6', 'Petani F'), 
('A7', 'Petani G'), ('A8', 'Petani H'), ('A9', 'Petani I'), 
('A10', 'Petani J'), ('A11', 'Petani K'), ('A12', 'Petani L'), 
('A13', 'Petani M'), ('A14', 'Petani N'), ('A15', 'Petani O'), 
('A16', 'Petani P'), ('A17', 'Petani Q'), ('A18', 'Petani R');

-- PENGISIAN DATA NILAI ALTERNATIF (Matriks 18x5)
INSERT INTO nilai_alternatif (id_alternatif, id_kriteria, nilai) VALUES
-- Petani A (Jurnal)
('A1', 'C1', 24509440.00), ('A1', 'C2', 14544200.00), ('A1', 'C3', 102.24), ('A1', 'C4', 1692000.00), ('A1', 'C5', 1.00),
-- Petani B
('A2', 'C1', 30000000.00), ('A2', 'C2', 17000000.00), ('A2', 'C3', 115.00), ('A2', 'C4', 1800000.00), ('A2', 'C5', 1.50),
-- Petani C
('A3', 'C1', 20000000.00), ('A3', 'C2', 10000000.00), ('A3', 'C3', 150.00), ('A3', 'C4', 2000000.00), ('A3', 'C5', 2.00),
-- Petani D
('A4', 'C1', 45000000.00), ('A4', 'C2', 25000000.00), ('A4', 'C3', 80.00), ('A4', 'C4', 1600000.00), ('A4', 'C5', 1.00),
-- Petani E
('A5', 'C1', 25000000.00), ('A5', 'C2', 12000000.00), ('A5', 'C3', 140.00), ('A5', 'C4', 1950000.00), ('A5', 'C5', 1.50),
-- Petani F
('A6', 'C1', 32000000.00), ('A6', 'C2', 15000000.00), ('A6', 'C3', 110.00), ('A6', 'C4', 1850000.00), ('A6', 'C5', 1.00),
-- Petani G
('A7', 'C1', 40000000.00), ('A7', 'C2', 20000000.00), ('A7', 'C3', 90.00), ('A7', 'C4', 1750000.00), ('A7', 'C5', 1.50),
-- Petani H
('A8', 'C1', 28000000.00), ('A8', 'C2', 13000000.00), ('A8', 'C3', 125.00), ('A8', 'C4', 1700000.00), ('A8', 'C5', 1.00),
-- Petani I
('A9', 'C1', 40000000.00), ('A9', 'C2', 20000000.00), ('A9', 'C3', 90.00), ('A9', 'C4', 1800000.00), ('A9', 'C5', 1.50),
-- Petani J
('A10', 'C1', 42000000.00), ('A10', 'C2', 22000000.00), ('A10', 'C3', 100.00), ('A10', 'C4', 1700000.00), ('A10', 'C5', 1.00),
-- Petani K
('A11', 'C1', 35000000.00), ('A11', 'C2', 17000000.00), ('A11', 'C3', 115.00), ('A11', 'C4', 1900000.00), ('A11', 'C5', 2.00),
-- Petani L
('A12', 'C1', 48000000.00), ('A12', 'C2', 28000000.00), ('A12', 'C3', 75.00), ('A12', 'C4', 1500000.00), ('A12', 'C5', 1.00),
-- Petani M
('A13', 'C1', 29000000.00), ('A13', 'C2', 13000000.00), ('A13', 'C3', 130.00), ('A13', 'C4', 1850000.00), ('A13', 'C5', 1.50),
-- Petani N
('A14', 'C1', 38000000.00), ('A14', 'C2', 19000000.00), ('A14', 'C3', 105.00), ('A14', 'C4', 1750000.00), ('A14', 'C5', 1.00),
-- Petani O
('A15', 'C1', 30000000.00), ('A15', 'C2', 14000000.00), ('A15', 'C3', 120.00), ('A15', 'C4', 1950000.00), ('A15', 'C5', 2.00),
-- Petani P
('A16', 'C1', 28000000.00), ('A16', 'C2', 13000000.00), ('A16', 'C3', 135.00), ('A16', 'C4', 1900000.00), ('A16', 'C5', 1.50),
-- Petani Q
('A17', 'C1', 40000000.00), ('A17', 'C2', 20000000.00), ('A17', 'C3', 100.00), ('A17', 'C4', 1700000.00), ('A17', 'C5', 1.00),
-- Petani R
('A18', 'C1', 35000000.00), ('A18', 'C2', 16000000.00), ('A18', 'C3', 120.00), ('A18', 'C4', 1800000.00), ('A18', 'C5', 1.00);