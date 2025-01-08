

<?php
include 'koneksi.php';

// Ambil data dari form
$id_sk = $_POST['id_sk'];
$tgl_sk = $_POST['tgl_sk'];
$nomor_agenda = $_POST['nomor_agenda'];
$kode = $_POST['kode'];
$nomor_sk = $_POST['nomor_sk'];
$tgl_keluar = $_POST['tgl_keluar'];
$penerima_sk = $_POST['penerima_sk'];
$perihal_sk = $_POST['perihal_sk'];

// Query untuk memperbarui data
$query = "UPDATE tb_sk SET 
    tgl_sk = '$tgl_sk',
    nomor_agenda = '$nomor_agenda',
    kode = '$kode',
    nomor_sk = '$nomor_sk',
    tgl_keluar = '$tgl_keluar',
    penerima_sk = '$penerima_sk',
    perihal_sk = '$perihal_sk'
    WHERE id_sk = $id_sk";

if (mysqli_query($koneksi, $query)) {
    header("Location: surat_keluar.php"); // Arahkan kembali ke halaman utama setelah berhasil
} else {
    echo "Error updating record: " . mysqli_error($koneksi);
}
?>