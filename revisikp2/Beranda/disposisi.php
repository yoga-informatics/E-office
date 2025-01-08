<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Office</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="../css/disposisi.css">
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo" />
            <div class="logo-text">
                <h1>E-OFFICE</h1>
                <p>KODIKLAT TNI AD</p>
            </div>
        </div>
        <nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li class="dropdown">
            <a href="" class="dropbtn">Master Data</a>
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
            <a href="" class="dropbtn">Laporan</a>
            <div class="dropdown-content">
                <a href="laporan_masuk.php">Laporan Masuk</a>
                <a href="laporan_keluar.php">Laporan Keluar</a>
            </div>
        </li>
        <li><a href="login.php">Keluar</a></li>
    </ul>
</nav>
        
            <div class="admin-profile">
                <i class="fas fa-user-circle"></i>
                <span>Admin</span>
            </div>
        </div>
    </div>
    <div class="content">
        <h2>Data Disposisi</h2>
        <h3>Data Disposisi Surat</h3>
        <table>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>No Agenda</th>
                    <th>No Surat Masuk</th>
                    <th>Pengirim</th>
                    <th>Tujuan Disposisi</th>
                    <th>Status</th>
                    <th>Catatan Disposisi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>123</td>
                    <td>456</td>
                    <td>Pengirim A</td>
                    <td>Tujuan A</td>
                    <td>Sudah</td>
                    <td>Catatan A</td>
                </tr>
            </tbody>
        </table>
        <div class="pagination">
            <span>Previous</span>
            <span class="current-page">1</span>
            <span>Next</span>
        </div>
    </div>
</body>
</html>