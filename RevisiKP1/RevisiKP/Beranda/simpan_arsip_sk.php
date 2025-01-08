<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming sk_id is still coming from the form
    $sk_id = $_POST['sk_id_arsipsk'];  // Updated form input name to sk_id_arsipsk
    $tgl_arsipsk = $_POST['tgl_arsipsk'];  // Updated field name to tgl_arsipsk
    $lokasi_arsipsk = $_POST['lokasi_arsipsk'];  // Updated field name to lokasi_arsipsk

    // Insert data into tb_arsipsk_surat (updated table name)
    $query = "INSERT INTO tb_arsipsk (sk_id, tgl_arsipsk, lokasi_arsipsk)
              VALUES ('$sk_id', '$tgl_arsipsk', '$lokasi_arsipsk')";  // Updated field names

    if (mysqli_query($koneksi, $query)) {
        // Redirect after successful insertion
        header("Location: arsip_sk.php");  // Updated redirect page name
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
?>
