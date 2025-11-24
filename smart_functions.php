<?php
class SmartSPK {
    private $koneksi;
    // BOBOT SESUAI EXCEL: [C1, C2, C3, C4, C5]
    // C1=0.2 (Cost), C2=0.2 (Cost), C3=0.3 (Benefit), C4=0.2 (Benefit), C5=0.1 (Benefit)
    private $bobot = [0.2, 0.2, 0.3, 0.2, 0.1];

    public function __construct($db) {
        $this->koneksi = $db;
    }

    public function hitung() {
        $data = [];
        $result = $this->koneksi->query("SELECT * FROM alternatif");
        
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        // Cari Min & Max
        $min = []; $max = [];
        foreach (['c1', 'c2', 'c3', 'c4', 'c5'] as $k) {
            $col = array_column($data, $k);
            $min[$k] = min($col);
            $max[$k] = max($col);
        }

        // Hitung Utility & Skor Akhir
        foreach ($data as &$row) {
            // C1 & C2 (COST): (Max - Nilai) / (Max - Min)
            $row['u1'] = ($max['c1'] - $row['c1']) / ($max['c1'] - $min['c1']);
            $row['u2'] = ($max['c2'] - $row['c2']) / ($max['c2'] - $min['c2']);
            
            // C3, C4, C5 (BENEFIT): (Nilai - Min) / (Max - Min)
            $row['u3'] = ($row['c3'] - $min['c3']) / ($max['c3'] - $min['c3']);
            $row['u4'] = ($row['c4'] - $min['c4']) / ($max['c4'] - $min['c4']);
            $row['u5'] = ($row['c5'] - $min['c5']) / ($max['c5'] - $min['c5']);

            // Hitung Skor Akhir
            $row['nilai_akhir'] = 
                ($row['u1'] * $this->bobot[0]) +
                ($row['u2'] * $this->bobot[1]) +
                ($row['u3'] * $this->bobot[2]) +
                ($row['u4'] * $this->bobot[3]) +
                ($row['u5'] * $this->bobot[4]);
        }

        // Ranking (Sort Descending)
        usort($data, function($a, $b) {
            return $b['nilai_akhir'] <=> $a['nilai_akhir'];
        });

        return $data;
    }
}
?>