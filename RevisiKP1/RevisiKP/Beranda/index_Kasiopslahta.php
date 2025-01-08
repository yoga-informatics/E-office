<?php 
session_start();
include 'koneksi.php';
// Periksa apakah session username telah diatur
if (!isset($_SESSION['pengguna_type'])) {
    echo '<script language="javascript" type="text/javascript">
    alert("Anda Tidak Berhak Masuk Kehalaman Ini!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=../index.php'>";
    exit;
}
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
        <div class="search-profile">
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
                <?php 
                      $sm = mysqli_query($koneksi, "SELECT count(*) as jumlah_sm FROM tb_sm");
                      $rsm = mysqli_fetch_assoc($sm);
                      ?>
                <h2>Surat Masuk</h2>
                <?php echo $rsm['jumlah_sm']; ?>
            </a>
            <a href="surat_keluar.php" class="card red">
                <i class="fas fa-envelope-open"></i>
                <?php 
                      $sk = mysqli_query($koneksi, "SELECT count(*) as jumlah_sk FROM tb_sk");
                      $rsk = mysqli_fetch_assoc($sk);
                      ?>
                <h2>Surat Keluar</h2>
                <?php echo $rsk['jumlah_sk']; ?>
            </a>
            <a href="periksa_sm.php" class="card blue">
                <i class="fas fa-file-signature"></i>
                <?php 
                      $d = mysqli_query($koneksi, "SELECT count(*) as jumlah_d FROM tb_disposisi");
                      $rd = mysqli_fetch_assoc($d);
                      ?>
                <h2>Disposisi</h2>
                <?php echo $rd['jumlah_d']; ?>
            </a>
        </div>

        <div class="welcome">
            <h1>SELAMAT DATANG <?php echo strtoupper($_SESSION['jabatan']); ?></h1>
            <p>Anda login sebagai <?php echo $_SESSION['jabatan']; ?>, Anda memiliki akses terhadap posisi anda</p>
        </div>
    </div>
</body>
</html>
