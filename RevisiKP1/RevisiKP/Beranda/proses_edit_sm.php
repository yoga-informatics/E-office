<?php
session_start();
include 'koneksi.php';

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the form data
    $id_sm = $_POST['id_sm'];
    $tgl_sm = $_POST['tgl_sm'];
    $nomor_agenda = $_POST['nomor_agenda'];
    $kode_surat = $_POST['kode_surat'];
    $nomor_surat = $_POST['nomor_surat'];
    $tgl_surat = $_POST['tgl_surat'];
    $kategori = $_POST['kategori'];
    $pengirim = $_POST['pengirim'];
    $perihal_surat = $_POST['perihal_surat'];
    $status = $_POST['status'];

    // Update the record in the database
    $query = "UPDATE tb_sm SET tgl_sm = ?, nomor_agenda = ?, kode_surat = ?, nomor_sm = ?, tgl_surat = ?, kategori = ?, pengirim = ?, perihal_surat = ?, status = ? WHERE id_sm = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'ssssssssii', $tgl_sm, $nomor_agenda, $kode_surat, $nomor_surat, $tgl_surat, $kategori, $pengirim, $perihal_surat, $status, $id_sm);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data surat masuk berhasil diperbarui.";
        header("Location: surat_masuk.php");
    } else {
        $_SESSION['error'] = "Gagal memperbarui data surat masuk.";
        header("Location: surat_masuk.php");
    }

    mysqli_stmt_close($stmt);
    mysqli_close($koneksi);
} else {
    $_SESSION['error'] = "Permintaan tidak valid.";
    header("Location: surat_masuk.php");
}
?>
