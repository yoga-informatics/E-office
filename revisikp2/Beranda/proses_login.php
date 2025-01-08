<?php
session_start();

// Menghubungkan ke database
include 'koneksi.php';

// Mendapatkan username dan password yang dikirimkan
$username = $_POST['username'];
$password = md5($_POST['password']); // Hash password dengan MD5

// Memeriksa apakah pengguna ada di tb_pengguna
$query = "SELECT * FROM tb_pengguna WHERE username='$username' AND password='$password' LIMIT 1";
$result = mysqli_query($koneksi, $query);

// Debug: Periksa apakah query SQL berjalan
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

if (mysqli_num_rows($result) == 1) {
    // Pengguna ditemukan
    $data = mysqli_fetch_assoc($result);

    // Menyimpan informasi pengguna ke dalam variabel sesi
    $_SESSION['pengguna_type'] = 'pengguna';

    $_SESSION['pengguna'] = $data['id_pg'];
    $_SESSION['nama'] = $data['nama_lengkap'];
    $_SESSION['jabatan'] = $data['jabatan'];
    $_SESSION['akses'] = $data['izin_akses'];

    // Pengalihan berdasarkan peran akses
    if ($_SESSION['akses'] == 'Admin') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=index.php'>";
        exit();
    }elseif ($_SESSION['akses'] == 'Pimpinan') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=index_pimpinan.php'>";
        exit();
    }elseif ($_SESSION['akses'] == 'Kasiopslahta') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=index_Kasiopslahta.php'>";
        exit();
    }elseif ($_SESSION['akses'] == 'KasiSisfo') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=index_KasiSisfo.php'>";
        exit();
    }elseif ($_SESSION['akses'] == 'Patuud') {
        echo '<script language="javascript" type="text/javascript">
        alert("Anda Berhasil Masuk, Selamat Datang '.$_SESSION['nama'].'!");</script>';
        echo "<meta http-equiv='refresh' content='0; url=index_Patuud.php'>";
        exit();
    }
    
}

// Jika login gagal, kembali ke halaman login dengan pesan error
header("Location: login.php?error=1");
exit();
?>
 