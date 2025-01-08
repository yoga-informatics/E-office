<?php
session_start();
include 'koneksi.php';

if (isset($_GET['id_sm'])) {
    $id_sm = $_GET['id_sm'];

    // Fetch the file path from the database
    $query = "SELECT nama_file FROM file_surat WHERE surat_id = '$id_sm'";
    $result = mysqli_query($koneksi, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $filePath = 'path/to/your/files/' . $row['nama_file']; // Update this path accordingly
        
        if (file_exists($filePath)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="' . basename($filePath) . '"');
            readfile($filePath);
            exit;
        } else {
            echo "File not found.";
        }
    } else {
        echo "No record found.";
    }
} else {
    echo "Invalid request.";
}
?>
