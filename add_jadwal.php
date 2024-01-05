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

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and insert into the database
    $hari = $_POST['hari'];
    $jam_mulai = $_POST['jam_mulai'] . ':' . $_POST['menit_mulai'] . ':' . $_POST['detik_mulai'];
    $jam_selesai = $_POST['jam_selesai'] . ':' . $_POST['menit_selesai'] . ':' . $_POST['detik_selesai'];

    // Get the doctor's ID
    $nama_dokter = $_SESSION['nama_dokter'];
    $queryGetDoctorID = "SELECT id FROM dokter WHERE nama = '$nama_dokter'";
    $resultGetDoctorID = $mysqli->query($queryGetDoctorID);

    if ($resultGetDoctorID) {
        $rowDoctorID = $resultGetDoctorID->fetch_assoc();
        $id_dokter = $rowDoctorID['id'];

        // Insert the schedule into the database
        $queryInsertSchedule = "INSERT INTO jadwal_periksa (id_dokter, hari, jam_mulai, jam_selesai) VALUES ('$id_dokter', '$hari', '$jam_mulai', '$jam_selesai')";
        $resultInsertSchedule = $mysqli->query($queryInsertSchedule);

        if ($resultInsertSchedule) {
            echo "<script>alert('Jadwal berhasil ditambahkan.');</script>";
            echo "<script>window.location.href = 'jadwal_periksa.php';</script>";
            exit;
        } else {
            echo "Terjadi kesalahan saat menambahkan jadwal: " . $mysqli->error;
        }
    } else {
        echo "Terjadi kesalahan saat mengambil ID dokter: " . $mysqli->error;
    }
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
                                    <h3 class="card-title">Tambah Jadwal</h3>
</div>

<form method="post" action="">
<div class="card-body">
<label for="hari">Hari :</label>
                <select name="hari" required>
                    <?php
                    // Mendapatkan nilai-nilai enum dari database
                    $result = $mysqli->query("SHOW COLUMNS FROM jadwal_periksa LIKE 'hari'");
                    $enum_str = $result->fetch_assoc()['Type'];
                    preg_match('/enum\((.*)\)$/', $enum_str, $matches);
                    $enum_values = explode(',', $matches[1]);

                    // Menampilkan nilai-nilai enum dalam dropdown
                    foreach ($enum_values as $value) {
                        $trimmed_value = trim($value, "'");
                        echo "<option value='$trimmed_value'>$trimmed_value</option>";
                    }
                    ?>
                    </select>
            </div>
                    <div class="form-group">
                        <label for="jam_mulai">Jam Mulai:</label>
                        <input type="time" name="jam_mulai" required>
                    </div>
                    <div class="form-group">
                        <label for="jam_selesai">Jam Selesai:</label>
                        <input type="time" name="jam_selesai" required>
                    </div>
        
                    <input type="hidden" name="id_dokter" value="<?php echo $id_dokter; ?>">
        
                    <div class="form-group">
                        <button type="submit" name="simpan">Simpan Jadwal</button>
                    </div>
                </form>

</body>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
                </div>
    
    <!-- Add your JS scripts here -->
</body>

</html>

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
