
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
  
  
  $nama_dokter = $_SESSION['nama_dokter'];

  // Query to get the doctor's ID
  $queryGetDoctorID = "SELECT id FROM dokter WHERE nama = '$nama_dokter'";
  $resultGetDoctorID = $mysqli->query($queryGetDoctorID);

  
  if ($resultGetDoctorID) {
      $rowDoctorID = $resultGetDoctorID->fetch_assoc();
      $id_dokter = $rowDoctorID['id'];
  
      // Query to get the doctor's schedule
      $queryGetSchedule = "SELECT * FROM jadwal_periksa WHERE id_dokter = '$id_dokter'";
      $resultGetSchedule = $mysqli->query($queryGetSchedule);
      
      if ($resultGetSchedule) {
          // Rest of the code to display the schedule
          // ...
  
      } else {
          echo "Terjadi kesalahan saat mengambil jadwal dokter: " . $mysqli->error;
      }
  } else {
      echo "Terjadi kesalahan saat mengambil ID dokter: " . $mysqli->error;
  }?>
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
        <?php include("components/navbardokter.php"); ?>
        <?php include("components/sidebardokter.php"); ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Jadwal Periksa</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Hari</th>
                                                <th>Jam Mulai</th>
                                                <th>Jam Selesai</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                                <a href='add_jadwal.php' class='btn btn-sm btn-success'>Tambah</a></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            while ($rowSchedule = $resultGetSchedule->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>{$rowSchedule['id']}</td>";
                                                echo "<td>{$rowSchedule['hari']}</td>";
                                                echo "<td>{$rowSchedule['jam_mulai']}</td>";
                                                echo "<td>{$rowSchedule['jam_selesai']}</td>";
                                                echo "<td>{$rowSchedule['status']}</td>";
                                                
                                                echo "<td>
                                                 <a href='ubah_status.php?id={$rowSchedule['id']}&status=Aktif' class='btn btn-sm btn-success'>Aktif</a>
                                                <a href='ubah_status.php?id={$rowSchedule['id']}&status=Tidak Aktif' class='btn btn-sm btn-danger'>Tidak Aktif</a>
      </td>";
                                                
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

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
