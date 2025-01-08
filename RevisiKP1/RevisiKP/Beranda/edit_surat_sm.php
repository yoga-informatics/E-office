<?php
session_start();
include 'koneksi.php';

// Check if ID is provided
if (!isset($_GET['id_sm'])) {
    header('Location: surat_masuk.php');
    exit;
}

$id_sm = $_GET['id_sm'];

// Fetch existing data
$query = "SELECT * FROM tb_sm WHERE id_sm = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param('i', $id_sm);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Update record
    $tgl_sm = $_POST['tanggal_masuk'];
    $nomor_agenda = $_POST['nomor_agenda'];
    $kode_surat = $_POST['kode_surat'];
    $nomor_surat = $_POST['nomor_surat'];
    $tgl_surat = $_POST['tgl_surat'];
    $kategori = $_POST['kategori'];
    $pengirim = $_POST['pengirim'];
    $perihal_surat = $_POST['perihal_surat'];
    $lampiran = $_POST['lampiran'];

    $updateQuery = "UPDATE tb_sm SET tgl_sm=?, nomor_agenda=?, kode_sm=?, nomor_sm=?, tgl_surat=?, kategori=?, pengirim=?, perihal_surat=?, lampiran=? WHERE id_sm=?";
    $updateStmt = $koneksi->prepare($updateQuery);
    $updateStmt->bind_param('sssssssssi', $tgl_sm, $nomor_agenda, $kode_surat, $nomor_surat, $tgl_surat, $kategori, $pengirim, $perihal_surat, $lampiran, $id_sm);
    
    if ($updateStmt->execute()) {
        header('Location: surat_masuk.php');
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
    <title>Edit Surat Masuk</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <h1>Edit Surat Masuk</h1>
    <form method="POST" action="">
        <div>
            <label for="tanggal_masuk">Tanggal Masuk Surat:</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo $data['tgl_sm']; ?>" required>
        </div>
        <div>
            <label for="nomor_agenda">Nomor Agenda:</label>
            <input type="text" id="nomor_agenda" name="nomor_agenda" value="<?php echo $data['nomor_agenda']; ?>" required>
        </div>
        <div>
            <label for="kode_surat">Kode Surat:</label>
            <input type="text" id="kode_surat" name="kode_surat" value="<?php echo $data['kode_sm']; ?>" required>
        </div>
        <div>
            <label for="nomor_surat">Nomor Surat:</label>
            <input type="text" id="nomor_surat" name="nomor_surat" value="<?php echo $data['nomor_sm']; ?>" required>
        </div>
        <div>
            <label for="tgl_surat">Tanggal Surat:</label>
            <input type="date" id="tgl_surat" name="tgl_surat" value="<?php echo $data['tgl_surat']; ?>" required>
        </div>
        <div>
            <label for="kategori">Kategori:</label>
            <select id="kategori" name="kategori" required>
                <option value="">Pilih Kategori Surat</option>
                <?php
                $query_kategori = mysqli_query($koneksi, "SELECT * FROM tb_kategori ORDER BY nama_kategori_s ASC");
                while ($kategori = mysqli_fetch_assoc($query_kategori)) {
                    $selected = ($kategori['id_kategori'] == $data['kategori']) ? 'selected' : '';
                    echo "<option value='{$kategori['id_kategori']}' $selected>{$kategori['nama_kategori_s']}</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="pengirim">Pengirim:</label>
            <input type="text" id="pengirim" name="pengirim" value="<?php echo $data['pengirim']; ?>" required>
        </div>
        <div>
            <label for="perihal_surat">Perihal:</label>
            <input type="text" id="perihal_surat" name="perihal_surat" value="<?php echo $data['perihal_surat']; ?>">
        </div>
        <button type="submit">Update</button>
    </form>
</body>
</html>
