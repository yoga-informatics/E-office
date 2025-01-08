<?php
session_start();
include 'koneksi.php';

// Ambil data surat masuk dari database
$query = "SELECT * FROM tb_sm JOIN tb_kategori ON tb_sm.kategori = tb_kategori.id_kategori ORDER BY tb_sm.id_sm DESC";
$result = $koneksi->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Masuk</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="surat_masuk.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
</head>
<body>
    <header class="header">
        <!-- Header content -->
    </header>

    <div class="page-header">
        <h1 class="page-title">Data Surat Masuk</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./" class="breadcrumb-link">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active" aria-current="page">Data Surat Masuk</li>
        </ol>
    </div>

    <div class="card-header">
        <h3 class="card-title">Data Surat Masuk</h3>
        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#myModal">
            <i class="fas fa-fw fa-plus"></i> Tambah Data
        </a>
    </div>

    <div class="table-responsive">
        <table class="table" id="dataTable">
            <thead>
                <tr class="text-center">
                    <th>No.</th>
                    <th>Tgl. Surat Masuk</th>
                    <th>No. Agenda</th>
                    <th>No. Surat Masuk</th>
                    <th>Tgl. Surat</th>
                    <th>Kategori Surat</th>
                    <th>Pengirim</th>
                    <th>Lampiran</th>
                    <th>Status Surat</th>
                    <th>Berkas</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while($row = mysqli_fetch_assoc($result)){
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
                    <td><?php echo $row['lampiran']; ?></td>
                    <td>
                        <?php if ($row['status'] == 1) { ?>
                        <span class="badge bg-primary"><i class="fas fa-spinner"></i> Proses</span>
                        <?php } elseif ($row['status'] == 2) { ?>
                        <span class="badge bg-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                        <?php } elseif ($row['status'] == 3) { ?>
                        <span class="badge bg-success"><i class="fas fa-check"></i> Selesai Disposisi</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $row['id_sm']; ?>"> Lihat File Pdf</a>
                    </td>
                    <td>
                        <a class="btn btn-info" href="#" data-bs-toggle="modal" data-bs-target="#detailSuratModal<?php echo $row['id_sm']; ?>"><i class="fas fa-eye"></i> Detail</a>
                        <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#myModaledit<?php echo $row['id_sm']; ?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
                        <button class="btn btn-danger deleteBtn" data-id="<?php echo $row['id_sm']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</button>
                    </td>
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
                        <!-- Form fields -->
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modals for each Surat Masuk -->
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
    <!-- Modal Edit Surat Masuk -->
    <div class="modal fade" id="myModaledit<?php echo $row['id_sm']; ?>" tabindex="-1" aria-labelledby="myModalEditLabel<?php echo $row['id_sm']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalEditLabel<?php echo $row['id_sm']; ?>">Edit Surat Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="proses_edit_sm.php?id_sm=<?php echo $row['id_sm']; ?>" enctype="multipart/form-data">
                        <!-- Form fields with existing data -->
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Detail Surat Masuk -->
    <div class="modal fade" id="detailSuratModal<?php echo $row['id_sm']; ?>" tabindex="-1" aria-labelledby="detailSuratModalLabel<?php echo $row['id_sm']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailSuratModalLabel<?php echo $row['id_sm']; ?>">Detail Surat Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Display details of Surat Masuk -->
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Lihat File PDF -->
    <div class="modal fade" id="fileModal<?php echo $row['id_sm']; ?>" tabindex="-1" aria-labelledby="fileModalLabel<?php echo $row['id_sm']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel<?php echo $row['id_sm']; ?>">Lihat File PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="<?php echo $row['lampiran']; ?>" style="width: 100%; height: 500px;" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.deleteBtn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.getAttribute('data-id');
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    window.location.href = `proses_hapus_sm.php?id_sm=${id}`;
                }
            });
        });
    </script>
</body>
</html>
