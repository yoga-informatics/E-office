<?php
// Koneksi ke database
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM tb_sm WHERE id_sm = $id";
    $result = $koneksi->query($query);
    $data = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Surat Masuk</title>
</head>
<body>
    <h1>Detail Surat Masuk</h1>
    <p><strong>Nomor Agenda:</strong> <?php echo $data['nomor_agenda']; ?></p>
    <p><strong>Kode Surat:</strong> <?php echo $data['kode_sm']; ?></p>
    <p><strong>Nomor Surat:</strong> <?php echo $data['nomor_sm']; ?></p>
    <p><strong>Tanggal Surat:</strong> <?php echo $data['tgl_surat']; ?></p>
    <p><strong>Pengirim Surat:</strong> <?php echo $data['pengirim']; ?></p>
    <p><strong>Perihal Surat:</strong> <?php echo $data['perihal_surat']; ?></p>
    <p><strong>Lampiran:</strong> <?php echo $data['lampiran']; ?></p>
    <p><strong>Tindakan:</strong> <?php echo $data['tindakan']; ?></p>

    <a href="surat_masuk.php">Kembali</a>
</body>
</html>
