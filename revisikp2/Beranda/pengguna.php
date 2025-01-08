<?php
session_start();
include 'koneksi.php';
if ($_SESSION['akses'] !== 'Admin') {
    echo '<script language="javascript" type="text/javascript">
    alert("Anda Tidak Berhak Mengakses Halaman Ini!");</script>';
    echo "<meta http-equiv='refresh' content='0; url=index.php'>";
    exit;
}
// Menghubungkan ke database

// Proses saat form di-submit untuk menambah pengguna baru
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Hashing password sebelum disimpan
    $nama_lengkap = $_POST['nama_lengkap'];
    $jabatan = $_POST['jabatan'];
    $izin_akses = $_POST['izin_akses'];
    
    // Proses unggah file foto
    $foto = $_FILES['foto']['name'];
    $target_dir = "../image/";
    $target_file = $target_dir . basename($foto);

    // Validasi apakah file yang diunggah adalah gambar
    $check = getimagesize($_FILES['foto']['tmp_name']);
    if ($check !== false) {
        // Memindahkan file yang diunggah ke direktori target
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $target_file)) {
            // Menyimpan data ke dalam database
            $sql = "INSERT INTO tb_pengguna (username, password, nama_lengkap, jabatan, izin_akses, foto)
                    VALUES ('$username', '$password', '$nama_lengkap', '$jabatan', '$izin_akses', '$foto')";

            if ($koneksi->query($sql) === TRUE) {
                echo "<script>alert('Data berhasil ditambahkan!');</script>";
            } else {
                echo "<script>alert('Error: " . $sql . "<br>" . $koneksi->error . "');</script>";
            }
        } else {
            echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file Anda.');</script>";
        }
    } else {
        echo "<script>alert('File bukan gambar yang valid.');</script>";
    }
}
// Mengambil data pengguna dari database dengan pencarian
$search = isset($_GET['search']) ? $_GET['search'] : '';

if (!empty($search)) {
    $sql = "SELECT * FROM tb_pengguna WHERE username LIKE '%$search%' OR nama_lengkap LIKE '%$search%' OR jabatan LIKE '%$search%'";
} else {
    $sql = "SELECT * FROM tb_pengguna";
}

$result = $koneksi->query($sql);
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Office</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="d.css">
    <link rel="stylesheet" href="../css/d.css">
    <link rel="stylesheet" href="../css/pengguna.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css">
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
    <div class="content">
        <h2>Data Pengguna</h2>
        <!-- Tombol untuk membuka modal -->
         <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</button>
        
        <!-- Form pencarian -->
        <form method="GET" action="pengguna.php" class="row">
            <div class="col-md-6">
                <input type="text" name="search" placeholder="Search" class="form-control mb-3" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </form>


        <!-- Modal untuk tambah pengguna baru -->
        <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna Baru</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="password">Password:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="nama_lengkap">Nama Lengkap:</label>
                                <input type="text" name="nama_lengkap" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="jabatan">Jabatan:</label>
                                <input type="text" name="jabatan" class="form-control" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="izin_akses">Hak Akses:</label>
                                <select name="izin_akses" class="form-select" required>
                                    <option value="Admin">Admin</option>
                                    <option value="Pimpinan">Pimpinan</option>
                                    <option value="Kasiopslahta">Kasiopslahta</option>
                                    <option value="KasiSisfo">KasiSisfo</option>
                                    <option value="Patuud">Patuud</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="foto">Upload Foto:</label>
                                <input type="file" class="form-control" id="foto" name="foto">
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table" id="dataTable">
                <thead>
                <tr>
                    <th style="background-color: green;">No.</th>
                    <th style="background-color: green;">Username</th>
                    <th style="background-color: green;">Nama Lengkap</th>
                    <th style="background-color: green;">Jabatan</th>
                    <th style="background-color: green;">Hak Akses</th>
                    <th style="background-color: green;">Foto</th>
                    <th style="background-color: green;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            $fotoPath = (!empty($row['foto'])) ? '../image/' . $row['foto'] : '../image/default.png';
                            
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['nama_lengkap'] . "</td>";
                            echo "<td>" . $row['jabatan'] . "</td>";
                            echo "<td>" . $row['izin_akses'] . "</td>";
                            echo "<td><img src='" . $fotoPath . "' alt='Foto' style='width: 50px; height: auto;'></td>";
                            echo "<td>
                                    <a class='btn btn-info' href='#' data-bs-toggle='modal' data-bs-target='#editForm" . $row['id_pg'] . "'><i class='fas fa-fw fa-edit'></i> Edit</a>
                                    <a class='btn btn-warning' href='#' data-bs-toggle='modal' data-bs-target='#passwordForm" . $row['id_pg'] . "'><i class='fas fa-fw fa-lock'></i> Edit Password</a>
                                    <button class='btn btn-danger deleteBtn' data-id='" . $row['id_pg'] . "'><i class='fas fa-fw fa-trash'></i> Hapus</button>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='7'>Data tidak tersedia</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Modal untuk Edit Pengguna -->
        <?php
        $result->data_seek(0); // Reset pointer hasil untuk digunakan kembali pada modals
        while ($row = $result->fetch_assoc()) {
        ?>
        <div class="modal fade" id="editForm<?php echo $row['id_pg']; ?>" tabindex="-1" aria-labelledby="editFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editFormLabel">Edit Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="update_pengguna.php" method="POST">
                            <input type="hidden" name="id_pg" value="<?php echo $row['id_pg']; ?>">
                            <div class="mb-3">
                                <label for="username">Username:</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $row['username']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="nama_lengkap">Nama Lengkap:</label>
                                <input type="text" name="nama_lengkap" class="form-control" value="<?php echo $row['nama_lengkap']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="jabatan">Jabatan:</label>
                                <input type="text" name="jabatan" class="form-control" value="<?php echo $row['jabatan']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="izin_akses">Hak Akses:</label>
                                <select name="izin_akses" class="form-select" required>
                                    <option value="Admin" <?php echo ($row['izin_akses'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                                    <option value="Pemimpin" <?php echo ($row['izin_akses'] == 'Pemimpin') ? 'selected' : ''; ?>>Pemimpin</option>
                                    <option value="Petugas" <?php echo ($row['izin_akses'] == 'Petugas') ? 'selected' : ''; ?>>Petugas</option>
                                    <option value="Kasiopslahta" <?php echo ($row['izin_akses'] == 'Kasiopslahta') ? 'selected' : ''; ?>>Kasiopslahta</option>
                                    <option value="KasiSisfo" <?php echo ($row['izin_akses'] == 'KasiSisfo') ? 'selected' : ''; ?>>KasiSisfo</option>
                                    <option value="Patuud" <?php echo ($row['izin_akses'] == 'Patuud') ? 'selected' : ''; ?>>Patuud</option>



                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>

        <!-- Modal untuk Edit Password -->
        <?php
        $result->data_seek(0); // Reset pointer hasil untuk digunakan kembali pada modals
        while ($row = $result->fetch_assoc()) {
        ?>
        <div class="modal fade" id="passwordForm<?php echo $row['id_pg']; ?>" tabindex="-1" aria-labelledby="passwordFormLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="passwordFormLabel">Edit Password</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="update_pass.php" method="POST">
                            <input type="hidden" name="id_pg" value="<?php echo $row['id_pg']; ?>">
                            <div class="mb-3">
                                <label for="password">Password Baru:</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.deleteBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (confirm('Apakah Anda yakin ingin menghapus pengguna ini?')) {
                    window.location.href = 'hapus_pengguna.php?id_pg=' + this.getAttribute('data-id');
                }
            });
        });
    </script>
</body>
</html>