<?php
session_start();
include 'koneksi.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $sk_id = $_POST['arsip_sk_id'];
    $tgl_arsip_sk = $_POST['arsip_tgl_arsip_sk'];
    $lokasi_arsip_sk = $_POST['lokasi_arsip_sk'];
    $no_sk = $_POST['arsip_no_sk'];


    // Insert into tb_arsip_surat
    $sql = "INSERT INTO tb_arsip_sk (sk_id, tgl_arsip_sk, lokasi_arsip_sk, no_sk) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $koneksi->prepare($sql)) {
        $stmt->bind_param('isss', $sk_id, $tgl_arsip_sk, $lokasi_arsip_sk, $no_sk);
        if ($stmt->execute()) {
            header('Location: arsip_sk.php'); // Redirect to arsip_surat.php after successful insertion
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
