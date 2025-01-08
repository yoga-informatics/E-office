<?php 
session_start();
include 'koneksi.php';
// Periksa apakah session username telah diatur
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Office</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="kategori.css">
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
        
        <!-- Master Data with Dropdown -->
        <li class="dropdown">
            <a href="" class="dropbtn">Master Data</a>
            <div class="dropdown-content">
                <a href="arsip_surat_masuk.php">Arsip Surat Masuk</a>
                <a href="arsip_surat_keluar.php">Arsip Surat Keluar</a>
                <a href="kategori.php">Kategori</a>
            </div>
        </li>

        <li><a href="surat_masuk.php">Surat Masuk</a></li>
        <li><a href="surat_keluar.php">Surat Keluar</a></li>
        
        <!-- Laporan with Dropdown -->
        <li class="dropdown">
            <a href="laporan.php" class="dropbtn">Laporan</a>
            <div class="dropdown-content">
                <a href="laporan_masuk.php">Laporan Masuk</a>
                <a href="laporan_keluar.php">Laporan Keluar</a>
            </div>
        </li>
    </ul>
</nav>
        <div class="search-profile">
            <div class="admin-profile">
                <i class="fas fa-user-circle"></i>
                <span>Admin</span>
            </div>
        </div>
    </div>
    <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Data Kategori</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./index.php">Home</a></li>
              <li class="breadcrumb-item">Tabel Kategori</li>
              <li class="breadcrumb-item active" aria-current="page">Data Kategori</li>
            </ol>
          </div>

          <!-- Row -->
          <div class="row">
            <!-- DataTable with Hover -->
            <div class="col-lg-12">
              <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success">Data Kategori</h6>
                  <a class="btn btn-sm btn-success" href="#" data-bs-toggle="modal" data-bs-target="#myModal"><i class="fas fa-fw fa-plus"></i> Tambah Data</a>
                </div>
                <div class="table-responsive p-3">
                  <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                      <tr>
                        <th >No.</th>
                        <th >Nama Kategori</th>
                        <th >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no=1;

                      $data = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
                      while ($row = mysqli_fetch_assoc($data)){
                      ?>
                      <tr>
                        <td><?php echo $no++; ?>.</td>
                        <td><?php echo $row['nama_kategori_s']; ?></td>
                        <td>
                        <a class="btn btn-sm btn-warning" href="" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $row['id_kategori']; ?>"><i class="fas fa-fw fa-edit"></i> Edit</a>
                        <a class="btn btn-sm btn-danger btn-delete-icon" href="hapus_kategori.php?id=<?php echo $row['id_kategori']; ?>" onclick="return confirm('Apakah anda ingin menghapus kategori <?php echo $row['nama_kategori_s']; ?> ?');">
                            <i class="fas fa-trash"></i> Hapus
                        </a>
                        </td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--Row-->

          <!-- Modal Tambah-->
          <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="myModalLabel">Tambah Kategori</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <!-- Formulir untuk memasukkan nama kategori -->
                  <form method="POST" action="proses_kategori.php">
                    <div class="mb-3">
                      <label for="kategori" class="form-label">Nama Kategori:</label>
                      <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan Nama Kategori" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" name="simpan" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>

          <!-- Modal Edit-->
          <?php 
          $k = mysqli_query($koneksi, "SELECT * FROM tb_kategori");
          while ($rk = mysqli_fetch_assoc($k)){
          ?>
          <div class="modal fade" id="editModal<?php echo $rk['id_kategori']; ?>" tabindex="-1" aria-labelledby="editModalLabel<?php echo $rk['id_kategori']; ?>" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                  <h5 class="modal-title" id="editModalLabel<?php echo $rk['id_kategori']; ?>">Edit Kategori</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                  <!-- Formulir untuk memasukkan nama kategori -->
                  <form method="POST" action="update_kategori.php">
                    <input type="hidden" name="kategori_id" value="<?php echo $rk['id_kategori']; ?>">
                    <div class="mb-3">
                      <label for="kategori" class="form-label">Nama Kategori:</label>
                      <input type="text" class="form-control" id="kategori" name="kategori" placeholder="Masukkan Nama Kategori" value="<?php echo $rk['nama_kategori_s']; ?>" required>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                  </form>
                </div>

              </div>
            </div>
          </div>
        <?php } ?>

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Apakah Anda yakin ingin logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Batal</button>
                  <a href="keluar.php" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b>Infolhata Kodiklat TNI AD</b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->

    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  <script src="../js/scripts.js"></script>
</body>
</html>