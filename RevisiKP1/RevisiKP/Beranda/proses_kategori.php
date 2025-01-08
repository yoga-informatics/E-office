<?php
// Detail koneksi database
include 'koneksi.php';

// Proses simpan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpan'])) {
    // Asumsi ada field form bernama 'nama_kategori'
    $nama_kategori = $_POST['kategori'];

    // Query SQL untuk memasukkan data
    $sql = "INSERT INTO tb_kategori (nama_kategori_s) VALUES ('$nama_kategori')";

    if ($koneksi->query($sql) === TRUE) {
        echo '<script language="javascript" type="text/javascript">
        alert("Data berhasil dimasukkan");</script>';
        echo "<meta http-equiv='refresh' content='0; url=kategori.php'>";
    } else {
        echo "Error: " . $sql . "<br>" . $koneksi->error;
    }
}

// Menutup koneksi database
$koneksi->close();
?>
