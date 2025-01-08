<?php
session_start();
include 'koneksi.php';

// Check if ID is provided
if (!isset($_GET['id_sm'])) {
    header('Location: surat_masuk.php');
    exit;
}

$id_sm = $_GET['id_sm'];

// Prepare and execute the delete query
$query = "DELETE FROM tb_sm WHERE id_sm = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_sm);

if ($stmt->execute()) {
    header('Location: surat_masuk.php');
    exit;
} else {
    echo "Error deleting record: " . $stmt->error;
}
?>
