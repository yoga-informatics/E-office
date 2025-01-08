<?php
// Mulai sesi dan koneksi database
session_start();
include 'koneksi.php';

// Periksa apakah ID dikirim melalui POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // Query untuk mendapatkan nama file berdasarkan surat_id
    $queryFile = "SELECT fs.nama_file 
                  FROM file_surat fs 
                  WHERE fs.surat_id = ?";
    $stmt = mysqli_prepare($koneksi, $queryFile);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $fileRow = mysqli_fetch_assoc($result)) {
        $fileName = $fileRow['nama_file'];
        $filePath = 'suratkeluar/' . $fileName;

        // Hapus file dari folder
        if (file_exists($filePath)) {
            unlink($filePath); // Hapus file
        }
    }

    // Query untuk menghapus data dari tabel tb_arsip_sk
    $queryDelete = "DELETE FROM tb_arsip_sk WHERE sk_id = ?";
    $stmtDelete = mysqli_prepare($koneksi, $queryDelete);
    mysqli_stmt_bind_param($stmtDelete, "i", $id);
    $deleteResult = mysqli_stmt_execute($stmtDelete);

    if ($deleteResult) {
        echo 'success';
    } else {
        echo 'error: ' . mysqli_error($koneksi);
    }
} else {
    echo 'No ID received';
}