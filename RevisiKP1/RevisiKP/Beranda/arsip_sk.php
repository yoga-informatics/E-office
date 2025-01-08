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
    header('Location: login.php'); 
    exit();
}


$query = "SELECT 
            tb_sk.id_sk, 
            tb_sk.tgl_sk, 
            tb_sk.kode, 
            tb_sk.nomor_sk, 
            tb_sk.tgl_keluar, 
            tb_sk.penerima_sk, 
            tb_sk.perihal_sk, 
            tb_arsipsk.tgl_arsipsk, 
            tb_arsipsk.lokasi_arsipsk
          FROM tb_sk
          LEFT JOIN tb_arsipsk ON tb_sk.id_sk = tb_arsipsk.sk_id
          WHERE tb_arsipsk.lokasi_arsipsk IS NOT NULL
          ORDER BY tb_sk.tgl_keluar DESC";

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
    <title>E-Office - Periksa Surat Keluar</title>
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
        <h1 class="h3 mb-0 text-gray-800">Data Surat Keluar</h1>
    </div>
    
    <!-- Search Bar -->
    <div class="container mb-4">
        <input class="form-control" id="searchInput" type="text" placeholder="Cari Surat Keluar...">
    </div>
    
    <!-- Table Section -->
    <div class="table-responsive p-3">
        <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>No.</th>
                    <th>Tgl. Surat Keluar</th>
                    <th>Kode Surat</th>
                    <th>No. Surat Keluar</th>
                    <th>Tgl. Input Surat</th>
                    <th>Penerima Surat</th>
                    <th>Berkas</th>
                    <th>Perihal Surat</th>
                    <th>Tanggal Arsipsk</th>
                    <th>Lokasi Arsipsk</th>
                </tr>
            </thead>
            <tbody id="dataTableBody">
                <?php
                $no = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $idsk = htmlspecialchars($row['id_sk']);
                    $berkas_pdf = '';
                    
                    
                    $dataf = "SELECT nama_file FROM file_surat WHERE surat_id='$idsk'";
                    $resultFile = mysqli_query($koneksi, $dataf);
                    if ($resultFile && mysqli_num_rows($resultFile) > 0) {
                        $rowf = mysqli_fetch_assoc($resultFile);
                        $berkas_pdf = $rowf['nama_file'];
                    }
                    
                    $filePath = 'suratkeluar/' . $berkas_pdf;
                    
                    echo "<tr class='text-center'>";
                    echo "<td>" . htmlspecialchars($no++) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tgl_keluar']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kode']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['nomor_sk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tgl_sk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['penerima_sk']) . "</td>";
                    echo "<td><a href='#' data-bs-toggle='modal' data-bs-target='#fileModal$idsk' class='btn btn-info'><i class='fas fa-file-pdf'></i> Lihat Berkas</a></td>";
                    echo "<td>" . htmlspecialchars($row['perihal_sk']) . "</td>";
                    
                    // Menampilkan Tanggal Arsipsk dan Lokasi Arsipsk
                    $tgl_arsipsk = isset($row['tgl_arsipsk']) ? htmlspecialchars($row['tgl_arsipsk']) : '-';
                    $lokasi_arsipsk = isset($row['lokasi_arsipsk']) ? htmlspecialchars($row['lokasi_arsipsk']) : '-';
                    echo "<td>" . $tgl_arsipsk . "</td>";  // Tanggal Arsipsk
                    echo "<td>" . $lokasi_arsipsk . "</td>";  // Lokasi Arsipsk        
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal untuk menampilkan PDF -->
    <?php 
    // Loop untuk setiap modal yang akan menampilkan PDF
    $surat = "SELECT * FROM tb_sk";
    $results = mysqli_query($koneksi, $surat);
    while ($rows = mysqli_fetch_assoc($results)){
        $idsk = $rows['id_sk'];
    ?>
    <div class="modal fade" id="fileModal<?php echo $idsk; ?>" tabindex="-1" aria-labelledby="fileModalLabel<?php echo $idsk; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel<?php echo $idsk; ?>">Lihat File Pdf</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <center>
                    <?php 
                    // Mengambil data file PDF berdasarkan surat_id
                    $dataf = "SELECT * FROM file_surat WHERE surat_id='$idsk'";
                    $result = mysqli_query($koneksi, $dataf);
                    if (mysqli_num_rows($result) > 0) {
                        while ($rowf = mysqli_fetch_assoc($result)){
                            $berkas_pdf = $rowf['nama_file'];
                            $filePath = 'suratkeluar/' . $berkas_pdf; // Path menuju file PDF
                    ?>
                    <!-- Menampilkan file PDF menggunakan iframe -->
                    <iframe src="<?php echo $filePath; ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe><br />
                    <?php 
                        }
                    }
                    ?>
                    </center>
                </div>
            </div>
        </div>
    </div>
    <?php 
    }
    ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        // Pencarian
        $(document).ready(function(){
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

