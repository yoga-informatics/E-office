<?php
session_start();
include 'koneksi.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $sm_id = $_POST['arsip_sm_id'];
    $tgl_arsip = $_POST['arsip_tgl_arsip'];
    $lokasi_arsip = $_POST['lokasi_arsip'];
    $no_sm = $_POST['arsip_no_sm'];


    // Insert into tb_arsip_surat
    $sql = "INSERT INTO tb_arsip_surat (sm_id, tgl_arsip, lokasi_arsip, no_sm) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param('isss', $sm_id, $tgl_arsip, $lokasi_arsip, $no_sm);
        if ($stmt->execute()) {
            header('Location: arsip_sm.php'); // Redirect to arsip_surat.php after successful insertion
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Error: " . $koneksi->error;
    }
}
$koneksi->close();
?>
