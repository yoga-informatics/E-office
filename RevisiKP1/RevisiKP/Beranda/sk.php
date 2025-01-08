<?php 
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>E-Office</title>
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="surat_keluar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
    <header class="header">
        <div class="logo">
            <img src="../image/logo.png" alt="Logo" class="logo-img"/>
            <div class="logo-text">
                <h1 class="logo-title">E-OFFICE</h1>
                <p class="logo-subtitle">KODIKLAT TNI AD</p>
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
            <i class="fas fa-search search-icon"></i>
            <div class="admin-profile">
                <i class="fas fa-user-circle profile-icon"></i>
                <span class="profile-name">Admin</span>
            </div>
        </div>
    </header>
    <div class="page-header">
        <h1 class="page-title">Data Surat Keluar</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="./" class="breadcrumb-link">Home</a></li>
            <li class="breadcrumb-item">Tables</li>
            <li class="breadcrumb-item active" aria-current="page">Data Surat Keluar</li>
        </ol>
    </div>
    <div class="card-header">
        <h3 class="card-title">Data Surat Keluar</h3>
        <a class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
    </div>
    <!-- Tabel Surat Keluar -->
    <div class="table-responsive">
        <table class="table" id="dataTable">
            <thead>
                <tr class="text-center">
                    <th>No.</th>
                    <th>No. Agenda</th>
                    <th>Kode</th>
                    <th>No. Surat Keluar</th>
                    <th>Tgl. Keluar</th>
                    <th>Tgl. Surat</th>
                    <th>Penerima</th>
                    <th>Perihal</th>
                    <th>Lampiran</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Membuat nomor halaman data
                $no = 1;

                // Mengambil data surat keluar 
                $data = "SELECT * FROM tb_sk ORDER BY tb_sk.id_sk DESC";
                $result = mysqli_query($koneksi, $data);
                while($row = mysqli_fetch_assoc($result)){
                    $idsurat = $row['id_sk'];
                ?>
                <tr class="text-center">
                    <td><?php echo $no++; ?>.</td>
                    <td><?php echo $row['nomor_agenda']; ?></td>
                    <td><?php echo $row['kode']; ?></td>
                    <td><?php echo $row['nomor_sk']; ?></td>
                    <td><?php echo $row['tgl_keluar']; ?></td>
                    <td><?php echo $row['tgl_sk']; ?></td>
                    <td><?php echo $row['penerima_sk']; ?></td>
                    <td><?php echo $row['perihal_sk']; ?></td>
                    <td><?php echo $row['lampiran_sk']; ?></td>
                    <td>
                        <?php if ($row['status'] == 1) { ?>
                        <span class="badge bg-primary"><i class="fas fa-spinner"></i> Proses</span>
                        <?php } elseif ($row['status'] == 2) { ?>
                        <span class="badge bg-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                        <?php } elseif ($row['status'] == 3) { ?>
                        <span class="badge bg-success"><i class="fas fa-check"></i> Selesai</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#fileModal<?php echo $row['id_sk']; ?>"> Lihat File Pdf</a>
                    </td>
                    <td>
                        <a class="btn btn-info" href="#" data-bs-toggle="modal" data-bs-target="#detailSuratModal<?php echo $row['id_sk']; ?>"><i class="fas fa-eye"></i> Detail</a>
                        <a class="btn btn-warning" href="#" data-bs-toggle="modal" data-bs-target="#myModaledit<?php echo $row['id_sk']; ?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
                        <button class="btn btn-danger deleteBtn" data-id="<?php echo $row['id_sk']; ?>"><i class="fas fa-fw fa-trash"></i> Hapus</button>
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
                            <label for="nomor_agenda" class="form-label">Nomor Agenda:</label>
                            <input type="text" class="form-control" id="nomor_agenda" name="nomor_agenda" required>
                        </div>
                        <div class="mb-3">
                            <label for="kode" class="form-label">Kode Surat:</label>
                            <input type="text" class="form-control" id="kode" name="kode" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_surat" class="form-label">Nomor Surat:</label>
                            <input type="text" class="form-control" id="nomor_surat" name="nomor_surat" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_keluar" class="form-label">Tanggal Keluar:</label>
                            <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_surat" class="form-label">Tanggal Surat:</label>
                            <input type="date" class="form-control" id="tanggal_surat" name="tanggal_surat" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerima" class="form-label">Penerima:</label>
                            <input type="text" class="form-control" id="penerima" name="penerima" required>
                        </div>
                        <div class="mb-3">
                            <label for="perihal" class="form-label">Perihal Surat:</label>
                            <input type="text" class="form-control" id="perihal" name="perihal" required>
                        </div>
                        <div class="mb-3">
                            <label for="lampiran" class="form-label">Lampiran:</label>
                            <input type="text" class="form-control" id="lampiran" name="lampiran" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status:</label>
                            <select class="form-select" id="status" name="status">
                                <option value="1">Proses</option>
                                <option value="2">Diajukan</option>
                                <option value="3">Selesai</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Surat Keluar -->
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sk ORDER BY id_sk DESC");
    while($row = mysqli_fetch_assoc($result)){
    ?>
    <div class="modal fade" id="myModaledit<?php echo $row['id_sk']; ?>" tabindex="-1" aria-labelledby="myModalEditLabel<?php echo $row['id_sk']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalEditLabel<?php echo $row['id_sk']; ?>">Edit Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="proses_sk_edit.php" enctype="multipart/form-data">
                        <input type="hidden" name="id_sk" value="<?php echo $row['id_sk']; ?>">
                        <div class="mb-3">
                            <label for="nomor_agenda_edit" class="form-label">Nomor Agenda:</label>
                            <input type="text" class="form-control" id="nomor_agenda_edit" name="nomor_agenda" value="<?php echo $row['nomor_agenda']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="kode_edit" class="form-label">Kode Surat:</label>
                            <input type="text" class="form-control" id="kode_edit" name="kode" value="<?php echo $row['kode']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="nomor_surat_edit" class="form-label">Nomor Surat:</label>
                            <input type="text" class="form-control" id="nomor_surat_edit" name="nomor_surat" value="<?php echo $row['nomor_sk']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_keluar_edit" class="form-label">Tanggal Keluar:</label>
                            <input type="date" class="form-control" id="tanggal_keluar_edit" name="tanggal_keluar" value="<?php echo $row['tgl_keluar']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_surat_edit" class="form-label">Tanggal Surat:</label>
                            <input type="date" class="form-control" id="tanggal_surat_edit" name="tanggal_surat" value="<?php echo $row['tgl_sk']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="penerima_edit" class="form-label">Penerima:</label>
                            <input type="text" class="form-control" id="penerima_edit" name="penerima" value="<?php echo $row['penerima_sk']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="perihal_edit" class="form-label">Perihal Surat:</label>
                            <input type="text" class="form-control" id="perihal_edit" name="perihal" value="<?php echo $row['perihal_sk']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="lampiran_edit" class="form-label">Lampiran:</label>
                            <input type="text" class="form-control" id="lampiran_edit" name="lampiran" value="<?php echo $row['lampiran_sk']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status_edit" class="form-label">Status:</label>
                            <select class="form-select" id="status_edit" name="status">
                                <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>>Proses</option>
                                <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>>Diajukan</option>
                                <option value="3" <?php if ($row['status'] == 3) echo 'selected'; ?>>Selesai</option>
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Modal Detail Surat Keluar -->
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sk ORDER BY id_sk DESC");
    while($row = mysqli_fetch_assoc($result)){
    ?>
    <div class="modal fade" id="detailSuratModal<?php echo $row['id_sk']; ?>" tabindex="-1" aria-labelledby="detailSuratLabel<?php echo $row['id_sk']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailSuratLabel<?php echo $row['id_sk']; ?>">Detail Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nomor Agenda:</strong> <?php echo $row['nomor_agenda']; ?></p>
                    <p><strong>Kode Surat:</strong> <?php echo $row['kode']; ?></p>
                    <p><strong>Nomor Surat:</strong> <?php echo $row['nomor_sk']; ?></p>
                    <p><strong>Tanggal Keluar:</strong> <?php echo $row['tgl_keluar']; ?></p>
                    <p><strong>Tanggal Surat:</strong> <?php echo $row['tgl_sk']; ?></p>
                    <p><strong>Penerima:</strong> <?php echo $row['penerima_sk']; ?></p>
                    <p><strong>Perihal Surat:</strong> <?php echo $row['perihal_sk']; ?></p>
                    <p><strong>Lampiran:</strong> <?php echo $row['lampiran_sk']; ?></p>
                    <p><strong>Status:</strong> 
                        <?php if ($row['status'] == 1) { ?>
                        <span class="badge bg-primary"><i class="fas fa-spinner"></i> Proses</span>
                        <?php } elseif ($row['status'] == 2) { ?>
                        <span class="badge bg-warning"><i class="fas fa-paper-plane"></i> Diajukan</span>
                        <?php } elseif ($row['status'] == 3) { ?>
                        <span class="badge bg-success"><i class="fas fa-check"></i> Selesai</span>
                        <?php } ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <!-- Modal Lihat File PDF -->
    <?php
    $result = mysqli_query($koneksi, "SELECT * FROM tb_sk ORDER BY id_sk DESC");
    while($row = mysqli_fetch_assoc($result)){
    ?>
    <div class="modal fade" id="fileModal<?php echo $row['id_sk']; ?>" tabindex="-1" aria-labelledby="fileModalLabel<?php echo $row['id_sk']; ?>" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fileModalLabel<?php echo $row['id_sk']; ?>">Lihat File PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe src="path/to/pdf/<?php echo $row['lampiran_sk']; ?>" width="100%" height="500px"></iframe>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>

</div>


<!-- Include Bootstrap JS and other necessary scripts -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
</body>
</html>
