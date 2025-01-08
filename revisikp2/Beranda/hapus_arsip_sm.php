<?php
session_start();
include 'koneksi.php';

// Enable error reporting for debugging (Disable in production)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (isset($_GET['id'])) {
    $id_arsip = intval($_GET['id']); // Get the id from the URL

    // Prepare the SQL statement
    $stmt = $koneksi->prepare("DELETE FROM tb_arsip_surat WHERE id_arsip = ?");
    $stmt->bind_param("i", $id_arsip);

    if ($stmt->execute()) {
        // Redirect back to the arsip page with a success message
        header("Location: arsip_sm.php?status=success");
    } else {
        // Redirect back to the arsip page with an error message
        header("Location: arsip_sm.php?status=error");
    }

    $stmt->close();
} else {
    // Redirect back to the arsip page if no id is provided
    header("Location: arsip_sm.php");
}

$koneksi->close();
?>
