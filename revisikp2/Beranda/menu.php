<?php if ($_SESSION['akses'] == 'Admin') { ?>    
<nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li class="dropdown">
            <a href="index.php" class="dropbtn">Master Data</a>
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
<?php }elseif ($_SESSION['akses'] == 'Pimpinan') { ?>
<nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="periksa_sm.php">Periksa Surat Masuk</a></li>
        <li><a href="login.php">Keluar</a></li>
    </ul>
</nav>
<?php }elseif ($_SESSION['akses'] == 'Kasiopslahta') { ?>
<nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="periksa_sm_Kasiopslahta.php">Periksa Surat Masuk</a></li>
        <li><a href="login.php">Keluar</a></li>
    </ul>
</nav>
<?php }elseif ($_SESSION['akses'] == 'KasiSisfo') { ?>
<nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="periksa_sm_KasiSisfo.php">Periksa Surat Masuk</a></li>
        <li><a href="login.php">Keluar</a></li>
    </ul>
</nav>
<?php }elseif ($_SESSION['akses'] == 'Patuud') { ?>
<nav>
    <ul>
        <li><a href="index.php">Dashboard</a></li>
        <li><a href="periksa_sm_patuud.php">Periksa Surat Masuk</a></li>
        <li><a href="login.php">Keluar</a></li>
    </ul>
</nav>
<?php } ?>  
