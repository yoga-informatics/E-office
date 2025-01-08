<?php
session_start();
include 'koneksi.php';

// Menampilkan semua data surat masuk
$sql = "SELECT * FROM tb_sk";
$result = $koneksi->query($sql);

// Query untuk mendapatkan statistik tahunan
$yearly_stats_query = "SELECT YEAR(tgl_sk) AS tahun, COUNT(*) AS jumlah FROM tb_sk GROUP BY YEAR(tgl_sk)";
$yearly_stats_result = $koneksi->query($yearly_stats_query);

// Menyimpan data tahunan untuk digunakan dalam diagram
$tahun = [];
$jumlah_tahun = [];
while ($statRow = $yearly_stats_result->fetch_assoc()) {
    $tahun[] = $statRow['tahun'];
    $jumlah_tahun[] = $statRow['jumlah'];
}

// Filter pencarian berdasarkan tanggal
$startDate = isset($_POST['start_date']) ? $_POST['start_date'] : '';
$endDate = isset($_POST['end_date']) ? $_POST['end_date'] : '';
$dateFilteredResult = null;

if ($startDate && $endDate) {
    $dateFilteredQuery = "SELECT * FROM tb_sk WHERE tgl_sk BETWEEN '$startDate' AND '$endDate'";
    $dateFilteredResult = $koneksi->query($dateFilteredQuery);
}

// Pilihan tahun untuk statistik bulanan
$selectedYear = isset($_POST['selected_year']) ? $_POST['selected_year'] : (count($tahun) > 0 ? $tahun[0] : '');

// Query untuk mendapatkan statistik bulanan berdasarkan tahun yang dipilih
$monthly_stats_query = "SELECT MONTH(tgl_sk) AS bulan, COUNT(*) AS jumlah FROM tb_sk WHERE YEAR(tgl_sk) = '$selectedYear' GROUP BY MONTH(tgl_sk)";
$monthly_stats_result = $koneksi->query($monthly_stats_query);

$bulan = [];
$jumlah_bulan = [];
while ($monthRow = $monthly_stats_result->fetch_assoc()) {
    $bulan[] = $monthRow['bulan'];
    $jumlah_bulan[] = $monthRow['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Surat Keluar</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="../css/laporan_suratmasuk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .container-diagram, .search-container {
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        @media print {
            .header, nav, .search-profile, .pagination, .no-print, .search-container {
                display: none;
            }
            .container {
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo" />
            <h1>E-OFFICE</h1>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Master Data</a>
                    <div class="dropdown-content">
                        <a href="arsip_sm.php">Arsip Surat Masuk</a>
                        <a href="arsip_sk.php">Arsip Surat Keluar</a>                        
                        <a href="kategori.php">Kategori Surat</a>
                    </div>
                </li>
                <li><a href="surat_masuk.php">Surat Masuk</a></li>
                <li><a href="surat_keluar.php">Surat Keluar</a></li>
                <li><a href="pengguna.php">Pengguna</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Laporan</a>
                    <div class="dropdown-content">
                        <a href="laporan_masuk.php">Laporan Masuk</a>
                        <a href="laporan_keluar.php">Laporan Keluar</a>
                    </div>
                </li>
                <li><a href="login.php">Keluar</a></li>
            </ul>
        </nav>
    </div>
     <!-- Form Pencarian Berdasarkan Tanggal -->
     <div class="search-container no-print">
        <h4>Pencarian Surat Berdasarkan Tanggal</h4>
        <form method="POST" action="">
            <label for="start_date">Tanggal Mulai:</label>
            <input type="date" id="start_date" name="start_date" value="<?= $startDate; ?>" required>
            <label for="end_date">Tanggal Akhir:</label>
            <input type="date" id="end_date" name="end_date" value="<?= $endDate; ?>" required>
            <button type="submit">Cari</button>
        </form>
    </div>


    <div class="container">
        <h3 class="m-0 font-weight-bold text-primary">Laporan Surat Keluar</h3>
        <button id="print-button" class="print-button no-print">Cetak Semua</button>
        <table class="data-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Kode</th>
                    <th>No. Surat Keluar</th>
                    <th>Tgl. Keluar</th>
                    <th>Tgl. Surat</th>
                    <th>Penerima</th>
                    <th>Perihal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $data = $dateFilteredResult ?: $result;
                if ($data->num_rows > 0) {
                    $no = 1;
                    while ($row = $data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $no++ . "</td>";
                        echo "<td>" . $row["kode"] . "</td>";
                        echo "<td>" . $row["nomor_sk"] . "</td>";
                        echo "<td>" . $row["tgl_keluar"] . "</td>";
                        echo "<td>" . $row["tgl_sk"] . "</td>";
                        echo "<td>" . $row["penerima_sk"] . "</td>";
                        echo "<td>" . $row["perihal_sk"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='7'>Data tidak ditemukan</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Statistik Bulanan -->
    <div class="container-diagram no-print">
        <h4>Statistik Bulanan Surat Masuk</h4>
        <form method="POST" action="">
            <label for="selected_year">Pilih Tahun:</label>
            <select name="selected_year" id="selected_year" onchange="this.form.submit()">
                <?php foreach ($tahun as $year): ?>
                    <option value="<?= $year; ?>" <?= $year == $selectedYear ? 'selected' : ''; ?>><?= $year; ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <canvas id="monthlyStatsChart"></canvas>
    </div>

    <script>
        // Data untuk statistik bulanan
        const bulan = <?= json_encode($bulan); ?>;
        const jumlah_bulan = <?= json_encode($jumlah_bulan); ?>;

        // Menampilkan diagram batang menggunakan Chart.js
        const ctx = document.getElementById('monthlyStatsChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: bulan.map(b => b + ' - ' + ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'][b - 1]),
                datasets: [{
                    label: 'Jumlah Surat Masuk',
                    data: jumlah_bulan,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Statistik Bulanan Surat Masuk Tahun ' + '<?= $selectedYear; ?>'
                    }
                }, 
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        // Fungsi untuk mencetak
        document.getElementById("print-button").onclick = function() {
            window.print();
        };
    </script>
</body>
</html>