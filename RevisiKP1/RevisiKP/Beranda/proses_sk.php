<?php
// Koneksi ke database (ganti sesuai dengan pengaturan Anda)
include 'koneksi.php';

// Ambil data dari form
$tgl_sk = $_POST['tgl_sk'];
$kode = $_POST['kode'];
$nomor_sk = $_POST['nomor_sk'];
$tanggal_keluar = $_POST['tgl_keluar'];
$penerima_sk = $_POST['penerima_sk']; // Perbaiki variabel penerima_sk (huruf kecil semua)
$perihal_sk = $_POST['perihal_sk'];

// Simpan data surat keluar ke database
$query = "INSERT INTO tb_sk (kode, nomor_sk, tgl_keluar, tgl_sk, penerima_sk, perihal_sk, status) 
              VALUES ('$kode', '$nomor_sk', '$tanggal_keluar', '$tgl_sk', '$penerima_sk', '$perihal_sk', '')";
if ($koneksi->query($query) === TRUE) {
    // Ambil ID surat yang baru saja disimpan
    $surat_id = $koneksi->insert_id;

    // Proses upload file PDF
    if (!empty($_FILES['file_pdf']['name'][0])) {
        $file_surat = $_FILES['file_pdf']['name'];
        $file_surat_tmp = $_FILES['file_pdf']['tmp_name'];

        foreach ($file_surat as $index => $nama_file) {
            $ukuran_file = $_FILES['file_pdf']['size'][$index];

            // Batasi ukuran file maksimal (50 MB)
            if ($ukuran_file <= 50000000) {
                $target_dir = "suratkeluar/";
                $target_file = $target_dir . basename($nama_file);

                if (move_uploaded_file($file_surat_tmp[$index], $target_file)) {
                    // Simpan informasi file ke database
                    $query = "INSERT INTO file_surat (surat_id, nama_file) VALUES ('$surat_id', '$nama_file')";
                    $koneksi->query($query);
                } else {
                    echo '<script language="javascript" type="text/javascript">
                      alert("Gagal mengupload file.!");</script>';
                    echo "<meta http-equiv='refresh' content='0; url=surat_keluar.php'>";
                    exit(); // Tambahkan exit untuk menghentikan script lebih lanjut
                }
            } else {
                echo '<script language="javascript" type="text/javascript">
                  alert("Ukuran file terlalu besar.!");</script>';
                echo "<meta http-equiv='refresh' content='0; url=surat_keluar.php'>";
                exit(); // Tambahkan exit untuk menghentikan script lebih lanjut
            }
        }
    }

    echo '<script language="javascript" type="text/javascript">
        alert("Data Berhasil Masuk!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=surat_keluar.php'>";
} else {
    echo "Error: " . $query . "<br>" . $koneksi->error;
}

$koneksi->close();
?>
