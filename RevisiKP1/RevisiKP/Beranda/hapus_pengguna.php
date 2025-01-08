<?php
include 'koneksi.php'; // Menghubungkan ke database

// Mengecek apakah parameter id_pg telah dikirim melalui URL
if (isset($_GET['id_pg'])) {
    $id_pg = $_GET['id_pg'];

    // Mengambil informasi foto pengguna sebelum menghapus data
    $query_foto = "SELECT foto FROM tb_pengguna WHERE id_pg = '$id_pg'";
    $result_foto = $koneksi->query($query_foto);
    $row_foto = $result_foto->fetch_assoc();

    // Hapus data pengguna dari database
    $sql = "DELETE FROM tb_pengguna WHERE id_pg = '$id_pg'";
    
    if ($koneksi->query($sql) === TRUE) {
        // Jika pengguna memiliki foto yang diunggah (bukan default), hapus juga file foto dari server
        if (!empty($row_foto['foto']) && file_exists("../image/" . $row_foto['foto'])) {
            unlink("../image/" . $row_foto['foto']); // Hapus file foto dari server
        }
        echo "<script>alert('Pengguna berhasil dihapus!'); window.location.href='pengguna.php';</script>";
    } else {
        echo "<script>alert('Error: " . $koneksi->error . "'); window.location.href='pengguna.php';</script>";
    }
} else {
    echo "<script>alert('ID pengguna tidak ditemukan.'); window.location.href='pengguna.php';</script>";
}
?>