<?php
session_start();
include 'koneksi.php';

// Check if ID is provided
if (!isset($_GET['id_sk'])) {
    header('Location: surat_keluar.php');
    exit;
}

$id_sk = $_GET['id_sk'];

// Fetch existing data
$query = "SELECT * FROM tb_sk WHERE id_sk = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_sk);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update record
    $tgl_sk = $_POST['tgl_sk'];
    $nomor_agenda = $_POST['nomor_agenda'];
    $kode = $_POST['kode_sk']; // Perbaikan pada variabel ini
    $nomor_sk = $_POST['nomor_sk'];
    $tgl_keluar = $_POST['tgl_keluar'];
    $penerima_sk = $_POST['penerima_sk'];
    $perihal_sk = $_POST['perihal_sk'];
    $lampiran_sk = ''; // Jika tidak ada nilai yang diambil dari form, Anda bisa mengatur default seperti ini

    $updateQuery = "UPDATE tb_sk SET tgl_sk=?, nomor_agenda=?, kode=?, nomor_sk=?, tgl_keluar=?, penerima_sk=?, perihal_sk=?, lampiran_sk=? WHERE id_sk=?";
    $updateStmt = $koneksi->prepare($updateQuery);
    $updateStmt->bind_param('ssssssssi', $tgl_sk, $nomor_agenda, $kode, $nomor_sk, $tgl_keluar, $penerima_sk, $perihal_sk, $lampiran_sk, $id_sk);

    if ($updateStmt->execute()) {
        header('Location: surat_keluar.php');
        exit;
    } else {
        echo "Error updating record.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Surat keluar</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Edit Surat Keluar</h1>
    <form method="POST" action="">
        <div>
            <label for="tgl_sk">Tanggal Keluar Surat:</label>
            <input type="date" id="tgl_sk" name="tgl_sk" value="<?php echo $data['tgl_sk']; ?>" required>
        </div>
        <div>
            <label for="nomor_agenda">Nomor Agenda:</label>
            <input type="text" id="nomor_agenda" name="nomor_agenda" value="<?php echo $data['nomor_agenda']; ?>" required>
        </div>
        <div>
            <label for="kode_sk">Kode Surat:</label>
            <input type="text" id="kode_sk" name="kode_sk" value="<?php echo $data['kode']; ?>" required>
        </div>
        <div>
            <label for="nomor_sk">Nomor Surat:</label>
            <input type="text" id="nomor_sk" name="nomor_sk" value="<?php echo $data['nomor_sk']; ?>" required>
        </div>
        <div>
            <label for="tgl_keluar">Tanggal Surat:</label>
            <input type="date" id="tgl_keluar" name="tgl_keluar" value="<?php echo $data['tgl_keluar']; ?>" required>
        </div>
        <div>
            <label for="penerima_sk">Penerima Surat:</label>
            <input type="text" id="penerima_sk" name="penerima_sk" value="<?php echo $data['penerima_sk']; ?>" required>
        </div>
        <div>
            <label for="perihal_sk">Perihal:</label>
            <input type="text" id="perihal_sk" name="perihal_sk" value="<?php echo $data['perihal_sk']; ?>">
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
