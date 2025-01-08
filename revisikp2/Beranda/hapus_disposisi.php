<?php
include 'koneksi.php';

if (isset($_GET['id_sm'])) {
    $id_sm = $_GET['id_sm'];

    // Fetch the file name associated with the letter
    $query = "SELECT nama_file FROM file_surat WHERE surat_id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id_sm);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $nama_file);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // Delete the letter record from tb_sm
    $delete_sm_query = "DELETE FROM tb_sm WHERE id_sm = ?";
    $stmt_sm = mysqli_prepare($koneksi, $delete_sm_query);
    mysqli_stmt_bind_param($stmt_sm, 'i', $id_sm);
    $success_sm = mysqli_stmt_execute($stmt_sm);
    mysqli_stmt_close($stmt_sm);

    // Delete the file record from file_surat
    $delete_file_query = "DELETE FROM file_surat WHERE surat_id = ?";
    $stmt_file = mysqli_prepare($koneksi, $delete_file_query);
    mysqli_stmt_bind_param($stmt_file, 'i', $id_sm);
    $success_file = mysqli_stmt_execute($stmt_file);
    mysqli_stmt_close($stmt_file);

    // If both deletions are successful, delete the physical file
    if ($success_sm && $success_file && !empty($nama_file)) {
        $filePath = 'suratmasuk/' . $nama_file;
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the server
        }
    }

    // Redirect back to the page after deletion
    header('Location: periksa_sm.php');
    exit;
} else {
    echo 'Invalid request.';
}
?>
