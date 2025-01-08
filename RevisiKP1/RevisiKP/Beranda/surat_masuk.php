
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

if (isset($_GET['update']) && $_GET['update'] == 'success') { ?>
    <div class="alert alert-success" role="alert">
        Data surat berhasil diperbarui!
    </div>
<?php } ?>

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
        
            <div class="admin-profile">
                <i class="fas fa-user-circle"></i>
                <span>Admin</span>
            </div>
        </div>
    </div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Surat Masuk</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active" aria-current="page">Data Surat Masuk</li>
        </ol>
    </div>
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h3 class="m-0 font-weight-bold text-primary">Data Surat Masuk</h3>
        <a class="btn btn-sm btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
    </div>
   <!-- Tabel Surat Masuk -->
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
                <th>Perihal</th>
                <th>Status Surat</th>
                <th>Catatan</th>
                <th>Tgl. Tanggapi</th> <!-- Added column header for Tgl. Tanggapi -->
                <th>Berkas</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Membuat nomor halaman data
            $no = 1;

            // Mengambil data surat masuk 
            $data = "SELECT tb_sm.*, tb_kategori.nama_kategori_s FROM tb_sm 
                     JOIN tb_kategori ON tb_sm.kategori = tb_kategori.id_kategori 
                     ORDER BY tb_sm.id_sm DESC";
            $result = mysqli_query($koneksi, $data);
            
            if (!$result) {
                die('Error: ' . mysqli_error($koneksi));
            }

            while ($row = mysqli_fetch_assoc($result)) {
                $idsurat = $row['id_sm'];
            ?>
            <tr class="text-center">
                <td><?php echo $no++; ?>.</td>
                <td><?php echo $row['tgl_sm']; ?></td>
                <td><?php echo $row['nomor_agenda']; ?></td>
                <td><?php echo $row['nomor_sm']; ?></td>
                <td><?php echo $row['tgl_surat']; ?></td>
                <td><?php echo $row['nama_kategori_s']; ?></td>
                <td><?php echo $row['pengirim']; ?></td>
                <td><?php echo $row['perihal_surat']; ?></td>
                <td>
                    <?php if ($row['status'] == 1) { ?>
                    <span class="badge badge-primary" style="color: red;"><i class="fas fa-spinner"></i> Proses</span>
                    <?php } elseif ($row['status'] == 3) { ?>
                    <span class="badge badge-success" style="color: green;"><i class="fas fa-check"></i> Selesai Disposisi
                    </span>
                    <?php } ?>
                </td>
                <!-- Menampilkan Nama Catatan -->
                <td>
                    <?php 
                    if (empty($row['disposisi'])) {
                        echo "Catatan belum ada";
                    } else {
                        echo $row['disposisi']; // Menampilkan nama Catatan dari kolom disposisi
                    }
                    ?>
                </td>
                <!-- Menampilkan Tgl. Tanggapi -->
                <td>
                    <?php 
                    // Menampilkan Tgl. Tanggapi, jika ada
                    if (empty($row['tgl_disposisi'])) {
                        echo "-"; // Jika belum ada tanggapan
                    } else {
                        echo $row['tgl_disposisi']; // Menampilkan Tgl. Tanggapi
                    }
                    ?>
                </td>
                <td>
                    <a class="btn btn-sm btn-warning" href="" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $row['id_sm']; ?>"> Lihat File Pdf</a>
                </td>
                <td>
                    <a class="btn btn-sm btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#editSuratModal" onclick="fillEditModal('<?php echo $row['id_sm']; ?>', '<?php echo $row['tgl_sm']; ?>', '<?php echo $row['nomor_agenda']; ?>', '<?php echo $row['nomor_sm']; ?>', '<?php echo $row['tgl_surat']; ?>', '<?php echo $row['kategori']; ?>', '<?php echo $row['pengirim']; ?>', '<?php echo $row['perihal_surat']; ?>', '<?php echo $row['status']; ?>')">
                        <i class="fas fa-fw fa-edit"></i> Edit
                    </a>
                    <button class="btn btn-sm btn-danger deleteBtn" data-id="<?php echo $row['id_sm']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#disposisiModal" 
    onclick="fillDisposisiModal('<?php echo $row['id_sm']; ?>', '<?php echo $row['nomor_agenda']; ?>', '<?php echo $row['nomor_sm']; ?>', '<?php echo $row['tgl_surat']; ?>', '<?php echo $row['tgl_sm']; ?>', '<?php echo $row['kategori']; ?>', '<?php echo $row['pengirim']; ?>', '<?php echo $row['perihal_surat']; ?>')">
    Disposisikan</button> 
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#arsipsmModal" 
    onclick="fillArsipsmModal('<?php echo $row['id_sm']; ?>', '<?php echo $row['nomor_agenda']; ?>', '<?php echo $row['nomor_sm']; ?>', '<?php echo $row['tgl_surat']; ?>', '<?php echo $row['tgl_sm']; ?>', '<?php echo $row['kategori']; ?>', '<?php echo $row['pengirim']; ?>', '<?php echo $row['perihal_surat']; ?>')">
    Arsipkan</button> </td>

            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>



 <!-- Modal Tambah Surat Masuk -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel">Tambah Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="proses_sm.php" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="tgl_sm" class="form-label">Tanggal Masuk Surat:</label>
                        <input type="date" class="form-control" id="tgl_sm" name="tgl_sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_agenda" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="nomor_agenda" name="nomor_agenda" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_surat" class="form-label">Tanggal Input Surat:</label>
                        <input type="date" class="form-control" id="tgl_surat" name="tgl_surat" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Surat:</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <!-- Fetch categories from the database -->
                            <?php
                            $categories = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                            while ($cat = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$cat['id_kategori']}'>{$cat['nama_kategori_s']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pengirim" class="form-label">Pengirim:</label>
                        <input type="text" class="form-control" id="pengirim" name="pengirim" required>
                    </div>
                    <div class="mb-3">
                        <label for="perihal_surat" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="perihal_surat" name="perihal_surat" required>
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
$surat = "SELECT * FROM tb_sm";
$results = mysqli_query($koneksi, $surat);
while ($rows = mysqli_fetch_assoc($results)){
    $idsm = $rows['id_sm'];
?>
<div class="modal fade" id="fileModal<?php echo $idsm; ?>" tabindex="-1" aria-labelledby="fileModalLabel<?php echo $idsm; ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="fileModalLabel<?php echo $idsm; ?>">Lihat File Pdf</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <center>
                <?php 
                $dataf = "SELECT * FROM file_surat WHERE surat_id='$idsm'";
                $result = mysqli_query($koneksi, $dataf);
                if (mysqli_num_rows($result) > 0) {
                    while ($rowf = mysqli_fetch_assoc($result)){
                        $berkas_pdf = $rowf['nama_file'];
                        $filePath = 'suratmasuk/' . $berkas_pdf; // Adjust this path if needed
                ?>
                <iframe src="<?php echo $filePath; ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe><br>
                <a href="<?php echo $filePath; ?>" class="btn btn-primary" download><i class="fas fa-file-pdf"></i> Unduh PDF</a>
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


<!-- Modal Arsip -->
<div class="modal fade" id="arsipsmModal" tabindex="-1" aria-labelledby="arsipsmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="arsipsmModalLabel">Arsip Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="simpan_arsip_sm.php" enctype="multipart/form-data">
                    <!-- Hidden Field untuk sm_id -->
                    <input type="hidden" id="sm_id_arsipsm" name="sm_id_arsipsm">
                    
                    <!-- Field dalam modal -->
                    <div class="mb-3">
                        <label for="tgl_sm" class="form-label">Tanggal Masuk Surat:</label>
                        <input type="date" class="form-control" id="tgl_sm_arsipsm" name="tgl_sm_arsipsm" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_agenda" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="nomor_agenda_arsipsm" name="nomor_agenda_arsipsm" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="nomor_surat_arsipsm" name="nomor_surat_arsipsm" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_surat" class="form-label">Tanggal Input Surat:</label>
                        <input type="date" class="form-control" id="tgl_surat_arsipsm" name="tgl_surat_arsipsm" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Surat:</label>
                        <select class="form-select" id="kategori_arsipsm" name="kategori_arsipsm">
                            <?php
                            $categories = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                            while ($cat = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$cat['id_kategori']}'>{$cat['nama_kategori_s']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pengirim" class="form-label">Pengirim:</label>
                        <input type="text" class="form-control" id="pengirim_arsipsm" name="pengirim_arsipsm" required>
                    </div>
                    <div class="mb-3">
                        <label for="perihal_surat" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="perihal_surat_arsipsm" name="perihal_surat_arsipsm" required>
                    </div>
                    <!-- Tanggal Disposisi -->
                    <div class="mb-3">
                        <label for="tgl_arsipsm" class="form-label">Tanggal Arsip:</label>
                        <input type="date" class="form-control" id="tgl_aprsism" name="tgl_arsipsm" required>
                    </div>
                    
                    <!-- Catatan -->
                    <div class="mb-3">
                    <label for="lokasi_arsipsm" class="form-label">Lokasi:</label>
                    <select class="form-control" id="lokasi_arsipsm" name="lokasi_arsipsm" required>
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
    document.getElementById('tgl_lokasi_arsipsm').value = today;
});

// Fungsi untuk mengisi data modal
function fillArsipsmModal(sm_id, nomor_agenda, nomor_sm, tgl_surat, tgl_sm, kategori, pengirim, perihal_surat) {
    document.getElementById('sm_id_arsipsm').value = sm_id;
    document.getElementById('tgl_sm_arsipsm').value = tgl_sm;
    document.getElementById('nomor_agenda_arsipsm').value = nomor_agenda;
    document.getElementById('nomor_surat_arsipsm').value = nomor_sm;
    document.getElementById('tgl_surat_arsipsm').value = tgl_surat;
    document.getElementById('kategori_arsipsm').value = kategori;
    document.getElementById('pengirim_arsipsm').value = pengirim;
    document.getElementById('perihal_surat_arsipsm').value = perihal_surat;
}
</script>


<!-- Modal Edit Surat Masuk -->
<div class="modal fade" id="editSuratModal" tabindex="-1" aria-labelledby="editSuratModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editSuratModalLabel">Edit Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editSuratForm" method="POST" action="update_sm.php" enctype="multipart/form-data">
                    <input type="hidden" id="edit_surat_id" name="id_sm">
                    <div class="mb-3">
                        <label for="edit_tgl_sm" class="form-label">Tanggal Masuk Surat:</label>
                        <input type="date" class="form-control" id="edit_tgl_sm" name="tgl_sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_agenda" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="edit_nomor_agenda" name="nomor_agenda" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_nomor_surat" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="edit_nomor_surat" name="nomor_sm" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_tgl_surat" class="form-label">Tanggal Input Surat:</label>
                        <input type="date" class="form-control" id="edit_tgl_surat" name="tgl_surat" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_kategori" class="form-label">Kategori Surat:</label>
                        <select class="form-select" id="edit_kategori" name="kategori">
                            <?php
                            $categories = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                            while ($cat = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$cat['id_kategori']}'>{$cat['nama_kategori_s']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_pengirim" class="form-label">Pengirim:</label>
                        <input type="text" class="form-control" id="edit_pengirim" name="pengirim" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_perihal_surat" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="edit_perihal_surat" name="perihal_surat" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_status" class="form-label">Status:</label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="1">Proses</option>
                            <option value="3">Selesai Disposisi</option>
                        </select>
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


    <script>
    function fillEditModal(id, tgl_sm, nomor_agenda, nomor_sm, tgl_surat, kategori, pengirim, perihal_surat, status) {
    $('#edit_surat_id').val(id);
    $('#edit_tgl_sm').val(tgl_sm);
    $('#edit_nomor_agenda').val(nomor_agenda);
    $('#edit_nomor_surat').val(nomor_sm);
    $('#edit_tgl_surat').val(tgl_surat);
    $('#edit_kategori').val(kategori);
    $('#edit_pengirim').val(pengirim);
    $('#edit_perihal_surat').val(perihal_surat);
    $('#edit_status').val(status);
}
    </script>

    

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#dataTable').DataTable();

        // Script untuk hapus surat masuk
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
                    window.location.href = 'hapus_sm.php?id_sm=' + suratId;
                }
            });
        });

        window.fillArsipModal = function(id, tgl_sm, nomor_agenda, nomor_sm, tgl_surat, kategori, pengirim, perihal_surat) {
            $('#arsip_tgl_sm').val(tgl_sm);
            $('#arsip_nomor_agenda').val(nomor_agenda);
            $('#arsip_nomor_sm').val(nomor_sm);
            $('#arsip_tgl_surat').val(tgl_surat);
            $('#arsip_kategori').val(kategori);
            $('#arsip_pengirim').val(pengirim);
            $('#arsip_perihal_surat').val(perihal_surat);
        };
    });
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


<!-- Modal Disposisi -->
<div class="modal fade" id="disposisiModal" tabindex="-1" aria-labelledby="disposisiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="disposisiModalLabel">Disposisi Surat Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="simpan_disposisi.php" enctype="multipart/form-data">
                    <!-- Hidden Field untuk sm_id -->
                    <input type="hidden" id="sm_id_disposisi" name="sm_id_disposisi">
                    
                    <!-- Field dalam modal -->
                    <div class="mb-3">
                        <label for="tgl_sm" class="form-label">Tanggal Masuk Surat:</label>
                        <input type="date" class="form-control" id="tgl_sm_disposisi" name="tgl_sm_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_agenda" class="form-label">Kode Surat:</label>
                        <input type="text" class="form-control" id="nomor_agenda_disposisi" name="nomor_agenda_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_surat" class="form-label">Nomor Surat:</label>
                        <input type="text" class="form-control" id="nomor_surat_disposisi" name="nomor_surat_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_surat" class="form-label">Tanggal Surat:</label>
                        <input type="date" class="form-control" id="tgl_surat_disposisi" name="tgl_surat_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori Surat:</label>
                        <select class="form-select" id="kategori_disposisi" name="kategori_disposisi">
                            <?php
                            $categories = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                            while ($cat = mysqli_fetch_assoc($categories)) {
                                echo "<option value='{$cat['id_kategori']}'>{$cat['nama_kategori_s']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="pengirim" class="form-label">Pengirim:</label>
                        <input type="text" class="form-control" id="pengirim_disposisi" name="pengirim_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="perihal_surat" class="form-label">Perihal Surat:</label>
                        <input type="text" class="form-control" id="perihal_surat_disposisi" name="perihal_surat_disposisi" required>
                    </div>
                    <div class="mb-3">
                        <label for="tujuan_disposisi" class="form-label">Tujuan Disposisi:</label>
                        <select class="form-control" id="tujuan_disposisi" name="tujuan_disposisi" required>
                            <option value="Pimpinan">Pimpinan</option>
                            <option value="Kasiopslahta">Kasiopslahta</option>
                            <option value="KasiSisfo">KasiSisfo</option>
                            <option value="Patuud">Patuud</option>
                        </select>
                    </div>

                    <!-- Tanggal Disposisi -->
                    <div class="mb-3">
                        <label for="tgl_disposisi" class="form-label">Tanggal Disposisi:</label>
                        <input type="date" class="form-control" id="tgl_disposisi" name="tgl_disposisi" required>
                    </div>
                    
                    <!-- Catatan -->
                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan:</label>
                        <textarea class="form-control" id="catatan" name="catatan" required></textarea>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Disposisi</button>
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
    document.getElementById('tgl_disposisi').value = today;
});

// Fungsi untuk mengisi data modal
function fillDisposisiModal(sm_id, nomor_agenda, nomor_sm, tgl_surat, tgl_sm, kategori, pengirim, perihal_surat) {
    document.getElementById('sm_id_disposisi').value = sm_id;
    document.getElementById('tgl_sm_disposisi').value = tgl_sm;
    document.getElementById('nomor_agenda_disposisi').value = nomor_agenda;
    document.getElementById('nomor_surat_disposisi').value = nomor_sm;
    document.getElementById('tgl_surat_disposisi').value = tgl_surat;
    document.getElementById('kategori_disposisi').value = kategori;
    document.getElementById('pengirim_disposisi').value = pengirim;
    document.getElementById('perihal_surat_disposisi').value = perihal_surat;
}
</script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>


</body>
</html>