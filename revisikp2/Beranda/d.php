<?php
session_start();

// Memeriksa apakah pengguna sudah login
if (!isset($_SESSION['pengguna'])) {
    header("Location: login.php");
    exit();
}

// Misalkan ini adalah data jumlah surat, Anda harus menggantinya dengan data dari database Anda
$jumlah_surat_rahasia = 2;
$jumlah_surat_nota_dinas = 3;
$jumlah_surat_undangan = 3;

$jumlah_surat_keluar_rahasia = 1;
$jumlah_surat_keluar_nota_dinas = 3;
$jumlah_surat_keluar_undangan = 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Office</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        
        <?php include 'menu.php' ?>
        <!-- <nav>
            <ul>
                <li><a href="d.php">Dashboard</a></li>
                <li class="dropdown">
                    <a href="" class="dropbtn">Master Data</a>
                    <div class="dropdown-content">
                        <a href="arsip_surat.php">Arsip Surat</a>
                        <a href="disposisi.php">Disposisi</a>
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
            </ul>
        </nav> -->
        
            <div class="admin-profile">
                <i class="fas fa-user-circle"></i>
                <span><?php echo $_SESSION['nama']; ?></span>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="cards">
            <a href="surat_masuk.php" class="card green">
                <i class="fas fa-inbox"></i>
                <h2>Surat Masuk</h2>
                <div class="popup">
                    <p>Surat Rahasia: <?php echo $jumlah_surat_rahasia; ?></p>
                    <p>Surat Nota Dinas: <?php echo $jumlah_surat_nota_dinas; ?></p>
                    <p>Surat Undangan: <?php echo $jumlah_surat_undangan; ?></p>
                </div>
            </a>
            <a href="surat_keluar.php" class="card red">
                <i class="fas fa-envelope-open"></i>
                <h2>Surat Keluar</h2>
                <div class="popup">
                    <p>Surat Rahasia: <?php echo $jumlah_surat_keluar_rahasia; ?></p>
                    <p>Surat Nota Dinas: <?php echo $jumlah_surat_keluar_nota_dinas; ?></p>
                    <p>Surat Undangan: <?php echo $jumlah_surat_keluar_undangan; ?></p>
                </div>
            </a>
            <a href="pengguna.php" class="card yellow">
                <i class="fas fa-users"></i>
                <h2>Pengguna</h2>
            </a>
            <a href="disposisi.php" class="card blue">
                <i class="fas fa-file-signature"></i>
                <h2>Disposisi</h2>
            </a>
        </div>
        <div class="welcome">
            <h1>SELAMAT DATANG <?php echo strtoupper($_SESSION['jabatan']); ?></h1>
            <p>Anda login sebagai <?php echo $_SESSION['jabatan']; ?>, Anda memiliki akses penuh terhadap sistem</p>
        </div>
    </div>
</body>
</html>
