-- Buat Database Baru
CREATE DATABASE spk_garam_smart;
USE spk_garam_smart;

-- 1. Tabel Admin (Untuk Login)
CREATE TABLE tb_admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(255)
);

-- Insert User Admin (Password: admin)
INSERT INTO tb_admin (username, password) VALUES ('admin', 'admin');

-- 2. Tabel Kriteria (Opsional, untuk referensi)
CREATE TABLE tb_kriteria (
    kode VARCHAR(5) PRIMARY KEY,
    nama VARCHAR(100),
    sifat ENUM('Cost', 'Benefit'),
    bobot FLOAT
);

INSERT INTO tb_kriteria VALUES 
('C1', 'Biaya Tetap', 'Cost', 0.2),
('C2', 'Biaya Variabel', 'Cost', 0.2),
('C3', 'Jumlah Produksi', 'Benefit', 0.3),
('C4', 'Harga Jual', 'Benefit', 0.2),
('C5', 'Luas Lahan', 'Benefit', 0.1);

-- 3. Tabel Alternatif (Data 20 Petani SESUAI EXCEL)
CREATE TABLE alternatif (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100),
    c1 DOUBLE, -- Biaya Tetap (Cost)
    c2 DOUBLE, -- Biaya Variabel (Cost)
    c3 DOUBLE, -- Produksi (Benefit)
    c4 DOUBLE, -- Harga (Benefit)
    c5 DOUBLE  -- Lahan (Benefit)
);

-- Insert Data 20 Petani (Angka Persis dari Excel)
INSERT INTO alternatif (nama, c1, c2, c3, c4, c5) VALUES
('Petani A (dari jurnal)', 24509440, 14544200, 102.24, 1692000, 1),
('Petani B', 22000000, 13000000, 98, 1650000, 1),
('Petani C', 20500000, 12500000, 105, 1700000, 1.5),
('Petani D', 28000000, 16000000, 100, 1600000, 1),
('Petani E', 35000000, 18000000, 150, 1750000, 2),
('Petani F', 24000000, 14000000, 101, 1680000, 1),
('Petani G', 19000000, 11500000, 95, 1600000, 0.8),
('Petani H', 26000000, 15500000, 103, 1690000, 1.2),
('Petani I', 23500000, 14200000, 100, 1670000, 1),
('Petani J', 30000000, 17000000, 120, 1720000, 1.5),
('Petani K', 21000000, 13500000, 99, 1660000, 1),
('Petani L', 25000000, 15000000, 102, 1690000, 1),
('Petani M', 27500000, 16500000, 104, 1710000, 1.3),
('Petani N', 22500000, 13800000, 97, 1640000, 1),
('Petani O', 18500000, 11000000, 90, 1580000, 0.7),
('Petani P', 32000000, 17500000, 130, 1730000, 1.8),
('Petani Q', 24200000, 14400000, 101.5, 1685000, 1),
('Petani R', 29000000, 16800000, 110, 1700000, 1.4),
('Petani S', 20000000, 12800000, 96, 1630000, 0.9),
('Petani T', 25500000, 15200000, 102.5, 1695000, 1.1);