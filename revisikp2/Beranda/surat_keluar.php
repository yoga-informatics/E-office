

<?php 
session_start();
include 'koneksi.php';
if ($_SESSION['akses'] !== 'Admin') {
    echo '<script language="javascript" type="text/javascript">
    alert("Anda Tidak Berhak Mengakses Halaman Ini!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}

// Enable error reporting for debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Office</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="surat_masuk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <span>Admin</span>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Surat Keluar</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar</li>
        </ol>
    </div>
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h3 class="m-0 font-weight-bold text-primary">Data Surat Keluar</h3>
        <a class="btn btn-sm btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
    </div>
    <!-- Tabel Surat Masuk -->
    <div class="table-responsive p-3">
        <table class="table align-items-center table-flush" id="dataTable">
            <thead class="thead-light">
                <tr class="text-center">
                    <th>No.</th>
                    <th>Tgl. Keluar Surat</th>
                    <th>Kode</th>
                    <th>No. Surat Keluar</th>
                    <th>Tgl. Input Keluar</th>
                    <th>Penerima</th>
                    <th>Perihal</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
                // Membuat nomor halaman data
                $no = 1;

                // Mengambil data surat keluar tanpa kategori
                $data = "SELECT * FROM tb_sk ORDER BY id_sk DESC";
                $result = mysqli_query($koneksi, $data);

                if (!$result) {
                    die('Error: ' . mysqli_error($koneksi));
                }

                while ($row = mysqli_fetch_assoc($result)) {
                    $idsurat = $row['id_sk'];
                ?>
                <tr class="text-center">
                    <td><?php echo $no++; ?>.</td>
                    <td><?php echo $row['tgl_sk']; ?></td>
                    <td><?php echo $row['kode']; ?></td>
                    <td><?php echo $row['nomor_sk']; ?></td>
                    <td><?php echo $row['tgl_keluar']; ?></td>
                    <td><?php echo $row['penerima_sk']; ?></td>
                    <td><?php echo $row['perihal_sk']; ?></td>
                    <td>
                    <a class="btn btn-sm btn-warning" href="" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $row['id_sk']; ?>"> Lihat File Pdf</a>
                    </td>
                    <td>
                    <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#editModal" onclick="fillEditModal('<?php echo $row['id_sk']; ?>', '<?php echo $row['tgl_sk']; ?>', '<?php echo $row['nomor_agenda']; ?>', '<?php echo $row['kode']; ?>', '<?php echo $row['nomor_sk']; ?>', '<?php echo $row['tgl_keluar']; ?>', '<?php echo $row['penerima_sk']; ?>', '<?php echo $row['perihal_sk']; ?>')">
                        <i class="fas fa-fw fa-edit"></i> Edit
                    </a>
                        <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $row['id_sk']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#arsipskModal" 
    onclick="fillArsipskModal('<?php echo $row['id_sk']; ?>', '<?php echo $row['kode']; ?>', '<?php echo $row['nomor_sk']; ?>', '<?php echo $row['tgl_keluar']; ?>', '<?php echo $row['tgl_sk']; ?>', '<?php echo $row['penerima_sk']; ?>', '<?php echo $row['perihal_sk']; ?>')">
    Arsipkan</button> </td>    
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

 <!-- Modal Tambah Surat Keluar -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Surat Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proses_sk.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tgl_sk" class="form-label">Tanggal Keluar Surat:</label>
                        <input type="date" class="form-control" id="tgl_sk" name="tgl_sk" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="kode" name="kode" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sk" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="nomor_sk" name="nomor_sk" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_keluar" class="form-label">Tanggal Input Surat:</label>
                        <input type="date" class="form-control" id="tgl_keluar" name="tgl_keluar" required>
                    </div>
                    <div class="mb-3">
                        <label for="penerima_sk" class="form-label">Penerima:</label>
                        <input type="text" class="form-control" id="penerima_sk" name="penerima_sk" required>
                    </div>
                    <div class="mb-3">
                        <label for="perihal_sk" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="perihal_sk" name="perihal_sk" required>
                    </div>
                    <!-- Ubah Input File Upload -->
                    <div class="mb-3">
                        <label for="upload-berkas" class="form-label">Upload Berkas PDF:</label>
                        <small class="form-text">Ukuran file PDF (50 MB)</small>
                        <input type="file" class="form-control" id="upload-berkas" name="file_pdf[]" multiple required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal File Pdf -->
<?php 
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
                // Fetch the PDF file linked with the surat
                $dataf = "SELECT * FROM file_surat WHERE surat_id='$idsk'";
                $result = mysqli_query($koneksi, $dataf);
                if (mysqli_num_rows($result) > 0) {
                    while ($rowf = mysqli_fetch_assoc($result)){
                        $berkas_pdf = $rowf['nama_file'];
                        $filePath = 'suratkeluar/' . $berkas_pdf; // Adjust this path if needed
                ?>
                <!-- Displaying PDF in an iframe -->
                <iframe src="<?php echo $filePath; ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe><br>
                <!-- Download link for the PDF -->
                <a href="<?php echo $filePath; ?>" class="btn btn-primary" download> <i class="fas fa-file-pdf"></i> Unduh PDF</a>
                <?php
                    }
                } else {
                    echo "<p>Tidak ada file yang tersedia.</p>";
                }
                ?>
                </center>
            </div>
        </div>
    </div>
</div>
<?php } ?>




<!-- Modal Arsip Keluar-->
<div class="modal fade" id="arsipskModal" tabindex="-1" aria-labelledby="arsipskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="arsipskModalLabel">Arsip Surat Keluar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="simpan_arsip_sk.php" enctype="multipart/form-data">
                    <!-- Hidden Field untuk sk_id -->
                    <input type="hidden" id="sk_id_arsipsk" name="sk_id_arsipsk">
                    
                    <!-- Field dalam modal -->
                    <div class="mb-3">
                        <label for="tgl_sk" class="form-label">Tanggal Keluar Surat:</label>
                        <input type="date" class="form-control" id="tgl_sk_arsipsk" name="tgl_sk_arsipsk" required>
                    </div>
                    <div class="mb-3">
                        <label for="kode" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="kode_arsipsk" name="kode_arsipsk" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_sk" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="nomor_sk_arsipsk" name="nomor_sk_arsipsk" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_keluar" class="form-label">Tanggal Input Surat:</label>
                        <input type="date" class="form-control" id="tgl_keluar_arsipsk" name="tgl_surat_arsipsk" required>
                    </div>
                    <div class="mb-3">
                        <label for="penerima" class="form-label">Penerima:</label>
                        <input type="text" class="form-control" id="penerima_arsipsk" name="penerima_arsipsk" required>
                    </div>
                    <div class="mb-3">
                        <label for="perihal_sk" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="perihal_sk_arsipsk" name="perihal_sk_arsipsk" required>
                    </div>
                    <!-- Tanggal arsip -->
                    <div class="mb-3">
                        <label for="tgl_arsipsk" class="form-label">Tanggal Arsip:</label>
                        <input type="date" class="form-control" id="tgl_aprsisk" name="tgl_arsipsk" required>
                    </div>
                    
                    <!-- lokasi -->
                    <div class="mb-3">
                    <label for="lokasi_arsipsk" class="form-label">Lokasi:</label>
                    <select class="form-control" id="lokasi_arsipsk" name="lokasi_arsipsk" required>
                        <option value="" disabled selected>Pilih Lokasi</option>
                        <option value="map1">Map 1</option>
                        <option value="map2">Map 2</option>
                        <option value="map3">Map 3</option>
                    </select>
                     </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Arsip</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Otomatis mengisi tanggal sekarang untuk Tanggal Disposisi
document.addEventListener('DOMContentLoaded', function() {
    var today = new Date().toISOString().split('T')[0]; // Format: YYYY-MM-DD
    document.getElementById('tgl_lokasi_arsipsk').value = today;
});

// Fungsi untuk mengisi data modal
function fillArsipskModal(sk_id, kode, nomor_sk, tgl_keluar, tgl_sk, penerima, perihal_sk) {
    document.getElementById('sk_id_arsipsk').value = sk_id;
    document.getElementById('tgl_sk_arsipsk').value = tgl_sk;
    document.getElementById('kode_arsipsk').value = kode;
    document.getElementById('nomor_sk_arsipsk').value = nomor_sk;
    document.getElementById('tgl_keluar_arsipsk').value = tgl_keluar;
    document.getElementById('penerima_arsipsk').value = penerima;
    document.getElementById('perihal_sk_arsipsk').value = perihal_sk;
}
</script>

 <!-- Modal Edit Surat Keluar -->
 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="update_sk.php" enctype="multipart/form-data">
                        <input type="hidden" id="edit_id_sk" name="id_sk">
                        <div class="mb-3">
                            <label for="edit_tgl_sk" class="form-label">Tanggal Keluar Surat:</label>
                            <input type="date" class="form-control" id="edit_tgl_sk" name="tgl_sk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_kode" class="form-label">Kode Surat:</label>
                            <input type="text" class="form-control" id="edit_kode" name="kode" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_nomor_sk" class="form-label">Nomor Surat:</label>
                            <input type="text" class="form-control" id="edit_nomor_sk" name="nomor_sk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_tgl_keluar" class="form-label">Tanggal Input Surat:</label>
                            <input type="date" class="form-control" id="edit_tgl_keluar" name="tgl_keluar" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_penerima_sk" class="form-label">Penerima:</label>
                            <input type="text" class="form-control" id="edit_penerima_sk" name="penerima_sk" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_perihal_sk" class="form-label">Perihal Surat:</label>
                            <input type="text" class="form-control" id="edit_perihal_sk" name="perihal_sk" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- Script untuk mengisi data di modal Arsip -->
    <script>
    // Script untuk mengisi data di modal Arsip
    // Script untuk mengisi data di modal Arsip
    function fillArsipModal(id, tgl_sk, nomor_agenda, nomor_sk, tgl_keluar, penerima_sk, perihal_sk) {
    $('#arsip_sk_id').val(id);
    $('#arsip_tgl_sk').val(tgl_sk);
    $('#arsip_nomor_agenda').val(nomor_agenda);
    $('#arsip_nomor_sk').val(nomor_sk);
    $('#arsip_tgl_keluar').val(tgl_keluar);
    $('#arsip_penerima_sk').val(penerima_sk);
    $('#arsip_perihal_sk').val(perihal_sk);
}
</script>


    <!-- Script untuk mengisi data di modal Arsip -->
    <script>
    // Script untuk mengisi data di modal Arsip
    // Script untuk mengisi data di modal Arsip
    function fillArsipModal(id, tgl_sk, nomor_agenda, nomor_sk, tgl_keluar, penerima_sk, perihal_sk) {
    $('#arsip_sk_id').val(id);
    $('#arsip_tgl_sk').val(tgl_sk);
    $('#arsip_nomor_agenda').val(nomor_agenda);
    $('#arsip_nomor_sk').val(nomor_sk);
    $('#arsip_tgl_keluar').val(tgl_keluar);
    $('#arsip_penerima_sk').val(penerima_sk);
    $('#arsip_perihal_sk').val(perihal_sk);
    }
    
    </script>
   <!-- JavaScript untuk isi data ke form edit -->
   <script>
    function editSuratKeluar(id_sk, tgl_sk, nomor_agenda, kode, nomor_sk, tgl_keluar, penerima_sk, perihal_sk) {
        document.getElementById('edit_id_sk').value = id_sk;
        document.getElementById('edit_tgl_sk').value = tgl_sk;
        document.getElementById('edit_nomor_agenda').value = nomor_agenda;
        document.getElementById('edit_kode').value = kode;
        document.getElementById('edit_nomor_sk').value = nomor_sk;
        document.getElementById('edit_tgl_keluar').value = tgl_keluar;
        document.getElementById('edit_penerima_sk').value = penerima_sk;
        document.getElementById('edit_perihal_sk').value = perihal_sk;
    }
    function fillEditModal(id_sk, tgl_sk, nomor_agenda, kode, nomor_sk, tgl_keluar, penerima_sk, perihal_sk) {
    $('#edit_id_sk').val(id_sk);
    $('#edit_tgl_sk').val(tgl_sk);
    $('#edit_nomor_agenda').val(nomor_agenda);
    $('#edit_kode').val(kode);
    $('#edit_nomor_sk').val(nomor_sk);
    $('#edit_tgl_keluar').val(tgl_keluar);
    $('#edit_penerima_sk').val(penerima_sk);
    $('#edit_perihal_sk').val(perihal_sk);
}
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    
    <!-- Script untuk hapus surat keluar -->
    <script>
        $('.deleteBtn').click(function(e) {
            e.preventDefault();
            var suratId = $(this).data('id');
            swal({
                title: "Apakah Anda yakin?",
                text: "Data ini akan dihapus secara permanen!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    window.location.href = 'hapus_sk.php?id_sk=' + suratId;
                }
            });
        });
    </script>
</body>
</html>