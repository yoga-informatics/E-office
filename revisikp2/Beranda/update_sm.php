update_sm

<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_sm = $_POST['id_sm'];
    $tgl_sm = $_POST['tgl_sm'];
    $nomor_agenda = $_POST['nomor_agenda'];
    $nomor_sm = $_POST['nomor_sm'];
    $tgl_surat = $_POST['tgl_surat'];
    $kategori = $_POST['kategori'];
    $pengirim = $_POST['pengirim'];
    $perihal_surat = $_POST['perihal_surat'];
    $status = $_POST['status'];

    $query = "UPDATE tb_sm SET 
                tgl_sm = '$tgl_sm', 
                nomor_agenda = '$nomor_agenda', 
                nomor_sm = '$nomor_sm', 
                tgl_surat = '$tgl_surat', 
                kategori = '$kategori', 
                pengirim = '$pengirim', 
                perihal_surat = '$perihal_surat', 
                status = '$status' 
              WHERE id_sm = '$id_sm'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: surat_masuk.php?update=success");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>