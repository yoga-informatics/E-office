<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sm_id = $_POST['sm_id_disposisi'];
    $tujuan_disposisi = $_POST['tujuan_disposisi'];
    $catatan = $_POST['catatan'];
    $tgl_disposisi = $_POST['tgl_disposisi'];

    // Insert data disposisi ke database
    $query = "INSERT INTO tb_disposisi (sm_id, tujuan_disposisi, catatan, tgl_disposisi, status_dispo)
              VALUES ('$sm_id', '$tujuan_disposisi', '$catatan', '$tgl_disposisi', 1)";  // status_dispo diset ke 1 (misal: belum selesai)

    if (mysqli_query($koneksi, $query)) {
        // Redirect setelah berhasil
        header("Location: periksa_sm.php");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}

mysqli_close($koneksi);
?>
