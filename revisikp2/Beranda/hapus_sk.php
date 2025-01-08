<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi sudah benar

// Cek apakah id_sk tersedia di URL
if (!isset($_GET['id_sk'])) {
    header('Location: surat_keluar.php');
    exit;
}

$id_sk = $_GET['id_sk'];

// Query untuk menghapus data dari tb_sk berdasarkan id_sk
$query = "DELETE FROM tb_sk WHERE id_sk = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_sk); // Mengikat parameter id_sk dengan tipe integer

// Menjalankan query dan memeriksa apakah berhasil
if ($stmt->execute()) {
    // Jika berhasil, redirect ke halaman surat_keluar.php
    header('Location: surat_keluar.php');
    exit;
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error deleting record: " . $stmt->error;
}

// Tutup statement dan koneksi
$stmt->close();
$koneksi->close();
?>
