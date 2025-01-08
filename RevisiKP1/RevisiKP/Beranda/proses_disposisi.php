<?php
include 'koneksi.php';

$sm_id = $_POST['sm_id'];
$tujuan_disposisi = $_POST['tujuan_disposisi'];
$catatan = $_POST['catatan'];

// Masukkan ke dalam tb_disposisi
$query = "INSERT INTO tb_disposisi (sm_id, tujuan_disposisi, catatan, status_dispo) VALUES ('$sm_id', '$tujuan_disposisi', '$catatan', 0)";
mysqli_query($conn, $query);

header("Location: surat_masuk.php?status=disposisi_success");
exit;
?>
