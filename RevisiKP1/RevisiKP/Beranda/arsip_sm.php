<?php
session_start();
// Include database connection
include 'koneksi.php';
if ($_SESSION['akses'] !== 'Admin') {
    echo '<script language="javascript" type="text/javascript">
    alert("Anda Tidak Berhak Mengakses Halaman Ini!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}

// Check if the user is authorized
if (!isset($_SESSION['akses']) || $_SESSION['akses'] !== 'Admin') {
    header('Location: login.php'); // Redirect to login page if not authorized
    exit();
}

// Fetch data from the database using prepared statements
$query = "SELECT 
            tb_sm.id_sm, 
            tb_sm.tgl_surat, 
            tb_sm.nomor_agenda, 
            tb_sm.nomor_sm, 
            tb_sm.tgl_sm, 
            tb_kategori.nama_kategori_s, 
            tb_sm.pengirim, 
            tb_sm.lampiran,
            tb_arsipsm.tgl_arsipsm,  -- Changed to tgl_arsipsm
            tb_arsipsm.lokasi_arsipsm  -- Changed to lokasi_arsipsm
          FROM tb_sm
          JOIN tb_kategori ON tb_sm.kategori = tb_kategori.id_kategori
          LEFT JOIN tb_arsipsm ON tb_sm.id_sm = tb_arsipsm.sm_id  -- Changed to tb_arsipsm
          WHERE tb_arsipsm.lokasi_arsipsm IS NOT NULL  -- Added condition to show only letters with arsipsm info
          ORDER BY tb_sm.tgl_sm DESC";

$stmt = mysqli_prepare($koneksi, $query);
if (!$stmt) {
    die('Query preparation failed: ' . mysqli_error($koneksi));
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E-Office - Periksa Surat Masuk</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .action-buttons button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo" />
            <div class="logo-text">
                <h1>E-OFFICE</h1>
                <p>KODIKLAT TNI AD</p>
            </div>
        </div>
        <nav>
            <ul>
                <li><a href="index.php">Dashboard</a></li>
                <li class="dropdown">
                    <a href="" class="dropbtn">Master Data</a>
                    <div class="dropdown-content">
                        <a href="arsip_sm.php">Arsip Surat Masuk</a>
                        <a href="arsip_sk.php">Arsip Surat Keluar</a>
                        <a href="kategori.php">Kategori Surat</a>
                    </div>
                </li>
                <li><a href="surat_masuk.php">Surat Masuk</a></li>
                <li><a href="surat_keluar.php">Surat Keluar</a></li>
                <li><a href="pengguna.php">Pengguna</a></li>
                <li class="dropdown">
                    <a href="" class="dropbtn">Laporan</a>
                    <div class="dropdown-content">
                        <a href="laporan_masuk.php">Laporan Masuk</a>
                        <a href="laporan_keluar.php">Laporan Keluar</a>
                    </div>
                </li>
                <li><a href="login.php">Keluar</a></li>
            </ul>
        </nav>
        <div class="search-profile">
            <div class="admin-profile">
                <i class="fas fa-user-circle"></i>
                <span><?php echo htmlspecialchars($_SESSION['nama']); ?></span>
            </div>
        </div>
    </div>
    
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Surat Masuk</h1>
    </div>

    <!-- Form Pencarian -->
    <div class="mb-3">
        <label for="searchInput" class="form-label">Cari Surat Masuk</label>
        <input type="text" id="searchInput" class="form-control" placeholder="Cari berdasarkan nomor surat, pengirim, atau kategori">
    </div>
    
    <!-- Table Section -->
    <div class="table-responsive p-3">
        <table class="table align-items-center table-flush" id="dataTable">
        <thead class="thead-light">
        <tr class="text-center">
            <th>No.</th>
            <th>Tgl. Surat Masuk</th>
            <th>Kode Surat</th>
            <th>No. Surat Masuk</th>
            <th>Tgl. Input Surat</th>
            <th>Kategori Surat</th>
            <th>Pengirim</th>
            <th>Berkas</th>
            <th>Tanggal Arsipsm</th> <!-- Changed to Tanggal Arsipsm -->
            <th>Lokasi Arsipsm</th> <!-- Changed to Lokasi Arsipsm -->
        </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($result)) {
                $idsm = htmlspecialchars($row['id_sm']);
                $berkas_pdf = '';
                
                // Fetch file path
                $dataf = "SELECT nama_file FROM file_surat WHERE surat_id='$idsm'";
                $resultFile = mysqli_query($koneksi, $dataf);
                if ($resultFile && mysqli_num_rows($resultFile) > 0) {
                    $rowf = mysqli_fetch_assoc($resultFile);
                    $berkas_pdf = $rowf['nama_file'];
                }
                
                $filePath = 'suratmasuk/' . $berkas_pdf;
                
                echo "<tr class='text-center'>";
                echo "<td>" . htmlspecialchars($no++) . "</td>";
                echo "<td>" . htmlspecialchars($row['tgl_sm']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nomor_agenda']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nomor_sm']) . "</td>";
                echo "<td>" . htmlspecialchars($row['tgl_surat']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nama_kategori_s']) . "</td>";
                echo "<td>" . htmlspecialchars($row['pengirim']) . "</td>";
                echo "<td><a href='#' data-bs-toggle='modal' data-bs-target='#fileModal$idsm' class='btn btn-info'><i class='fas fa-file-pdf'></i> Lihat Berkas</a></td>";

                // Menampilkan Tanggal Arsipsm dan Lokasi Arsipsm
                $tgl_arsipsm = isset($row['tgl_arsipsm']) ? htmlspecialchars($row['tgl_arsipsm']) : '-';
                $lokasi_arsipsm = isset($row['lokasi_arsipsm']) ? htmlspecialchars($row['lokasi_arsipsm']) : '-';
                echo "<td>" . $tgl_arsipsm . "</td>";  // Tanggal Arsipsm
                echo "<td>" . $lokasi_arsipsm . "</td>";  // Lokasi Arsipsm        
                echo "</tr>";
            }
            ?>
        </tbody>
        </table>
    </div>
    
    <!-- Modals for PDF Files -->
    <?php
        mysqli_data_seek($result, 0); // Reset result pointer
        while ($row = mysqli_fetch_assoc($result)) {
            $idsm = htmlspecialchars($row['id_sm']);
            
            // Fetch file path
            $dataf = "SELECT nama_file FROM file_surat WHERE surat_id='$idsm'";
            $resultFile = mysqli_query($koneksi, $dataf);
            $filePath = '';
            if ($resultFile && mysqli_num_rows($resultFile) > 0) {
                $rowf = mysqli_fetch_assoc($resultFile);
                $filePath = 'suratmasuk/' . $rowf['nama_file'];
            }
    ?>
    <div class="modal fade" id="fileModal<?php echo $idsm; ?>" tabindex="-1" aria-labelledby="fileModalLabel<?php echo $idsm; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel<?php echo $idsm; ?>">Lihat File Pdf nya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($filePath)) { ?>
                        <embed src="<?php echo $filePath; ?>" width="100%" height="500px" type="application/pdf">
                    <?php } else { ?>
                        <p>No file found.</p>
                    <?php } ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Footer -->
    <footer>
        <p>&copy; 2024 E-Office. All Rights Reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#dataTable tbody tr").filter(function() {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });
        });
    </script>
</body>
</html>
