
  <?php
  include 'koneksi.php';
  
  // Start the session
  if (!isset($_SESSION)) {
      session_start();
  }
  
  // Cek apakah dokter sudah login
  if (!isset($_SESSION['nama_dokter'])) {
      header("Location: logindokter.php");
      exit;
  }
  
  // Ambil nama dokter dari sesi
  $nama_dokter = $_SESSION['nama_dokter'];
  
  // Query untuk mendapatkan data dokter
  $queryGetDokter = "SELECT * FROM dokter WHERE nama = '$nama_dokter'";
  $resultGetDokter = $mysqli->query($queryGetDokter);
  
  if ($resultGetDokter) {
      $rowDokter = $resultGetDokter->fetch_assoc();
  
      // Proses form edit identitas dokter jika POST request
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id_dokter = $_POST['id'];
          $nama_dokter = $_POST['nama'];
          $alamat = $_POST['alamat'];
          $no_hp = $_POST['no_hp'];
          $id_poli = $_POST['id_poli'];
          $nip = $_POST['nip'];
          $password = $_POST['password'];
  
          // Query untuk update identitas dokter
          $queryUpdateDokter = "UPDATE dokter SET nama = '$nama_dokter', alamat = '$alamat', no_hp = '$no_hp', id_poli = '$id_poli', nip = '$nip', password = '$password' WHERE id = '$id_dokter'";

          $resultUpdateDokter = $mysqli->query($queryUpdateDokter);
  
          if ($resultUpdateDokter) {
              echo "<script>alert('Identitas dokter berhasil diupdate.');</script>";
              // Refresh halaman untuk menampilkan perubahan
              echo "<script>window.location.href = 'dokter.php';</script>";
              exit;
          } else {
              echo "Terjadi kesalahan saat mengupdate identitas dokter: " . $mysqli->error;
          }
      }
  } else {
      echo "Terjadi kesalahan saat mengambil data dokter: " . $mysqli->error;
  }
  ?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Starter</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>


  <!-- Content Wrapper. Contains page content -->
  <body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include ("components/navbardokter.php"); ?>
<?php include ("components/sidebardokter.php"); ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Identitas Dokter</h3>
                                </div>
                                <form role="form" method="POST">
                                

                                    <div class="card-body">

                                    <div class="form-group">
                                  <label for="id">ID Dokter</label>
                                    <input type="text" class="form-control" id="id" name="id" value="<?php echo $rowDokter['id']; ?>" readonly>
                                      </div>
                                      
                                        <div class="form-group">
                                            <label for="nama">Nama Dokter</label>
                                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $rowDokter['nama']; ?>" >
                                        </div>
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $rowDokter['alamat']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="no_hp">Nomor HP</label>
                                            <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $rowDokter['no_hp']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="id_poli">ID Poli</label>
                                            <input type="text" class="form-control" id="id_poli" name="id_poli" value="<?php echo $rowDokter['id_poli']; ?>"readonly>
                                        </div>
                                        <div class="form-group">
                                            <label for="nip">NIP</label>
                                            <input type="text" class="form-control" id="nip" name="nip" value="<?php echo $rowDokter['nip']; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" value="<?php echo $rowDokter['password']; ?>">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update Identitas</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

</div>
</body>

</html>


  </div>



  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
