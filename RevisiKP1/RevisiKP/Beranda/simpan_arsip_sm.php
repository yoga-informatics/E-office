<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming sm_id is still coming from the form
    $sm_id = $_POST['sm_id_arsipsm'];  // Updated form input name to sm_id_arsipsm
    $tgl_arsipsm = $_POST['tgl_arsipsm'];  // Updated field name to tgl_arsipsm
    $lokasi_arsipsm = $_POST['lokasi_arsipsm'];  // Updated field name to lokasi_arsipsm

    // Insert data into tb_arsipsm_surat (updated table name)
    $query = "INSERT INTO tb_arsipsm (sm_id, tgl_arsipsm, lokasi_arsipsm)
              VALUES ('$sm_id', '$tgl_arsipsm', '$lokasi_arsipsm')";  // Updated field names

    if (mysqli_query($koneksi, $query)) {
        // Redirect after successful insertion
        header("Location: arsip_sm.php");  // Updated redirect page name
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
?>
