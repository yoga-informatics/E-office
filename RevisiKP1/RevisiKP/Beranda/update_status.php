<?php
session_start();
include 'koneksi.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $idsm = $_POST['idsm'];
    $catatan = $_POST['catatan']; // Ambil catatan yang dikirim dari modal
    $tglDitanggapi = $_POST['tglDitanggapi']; // Ambil tgl_ditanggapi yang dikirim dari modal

    // Jika catatan kosong, ambil nilai tgl_disposisi sebagai tgl_ditanggapi
    if (empty($catatan)) {
        // Ambil tgl_disposisi dari tabel
        $query = "SELECT tgl_disposisi FROM tb_sm WHERE id_sm = '$idsm'";
        $result = mysqli_query($koneksi, $query);
        if ($row = mysqli_fetch_assoc($result)) {
            $tglDitanggapi = $row['tgl_disposisi']; // Ambil tgl_disposisi
        }
    }

    // Update the status of the letter, store the note (catatan), and the date of response (tgl_ditanggapi)
    $updateQuery = "UPDATE tb_sm SET status = 3, disposisi = '$catatan', tgl_disposisi = '$tglDitanggapi' WHERE id_sm = '$idsm'";

    if (mysqli_query($koneksi, $updateQuery)) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => mysqli_error($koneksi)]);
    }
}
?>
