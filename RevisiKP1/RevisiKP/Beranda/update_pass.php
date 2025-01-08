
<?php
include 'koneksi.php'; // Menghubungkan ke database

// Proses saat form di-submit untuk mengubah password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pg = $_POST['id_pg']; // Mendapatkan ID pengguna
    $password_baru = md5($_POST['password']); // Hashing password baru

    // Update password di database
    $sql = "UPDATE tb_pengguna SET password='$password_baru' WHERE id_pg='$id_pg'";

    if ($koneksi->query($sql) === TRUE) {
        echo "<script>alert('Password berhasil diperbarui!'); window.location.href='pengguna.php';</script>";
    } else {
        echo "<script>alert('Error: " . $sql . "<br>" . $koneksi->error . "'); window.location.href='pengguna.php';</script>";
    }
} else {
    // Jika form tidak di-submit dengan benar
    echo "<script>alert('Terjadi kesalahan.'); window.location.href='pengguna.php';</script>";
}
?>