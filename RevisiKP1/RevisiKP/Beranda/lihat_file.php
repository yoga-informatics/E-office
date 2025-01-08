<?php
// Koneksi ke database
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM file_surat WHERE surat_id = $id";
    $result = $koneksi->query($query);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat File</title>
</head>
<body>
    <h1>File Surat Masuk</h1>
    <ul>
        <?php while($row = $result->fetch_assoc()): ?>
        <li><a href="suratmasuk/<?php echo $row['nama_file']; ?>" target="_blank"><?php echo $row['nama_file']; ?></a></li>
        <?php endwhile; ?>
    </ul>

    <a href="surat_masuk.php">Kembali</a>

    <?php $koneksi->close(); ?>
</body>
</html>
