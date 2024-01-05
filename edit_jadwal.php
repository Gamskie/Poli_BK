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

    // Check if the id parameter is set in the URL
    if (isset($_GET['id'])) {
        $id_jadwal = $_GET['id'];

        // Query to get the doctor's schedule based on ID
        $queryGetSchedule = "SELECT * FROM jadwal_periksa WHERE id = '$id_jadwal' AND id_dokter = '$id_dokter'";
        $resultGetSchedule = $mysqli->query($queryGetSchedule);

        if ($resultGetSchedule) {
            $rowSchedule = $resultGetSchedule->fetch_assoc();

            // Check if the form is submitted for updating the schedule
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $hari = $_POST['hari'];
                $jam_mulai = $_POST['jam_mulai'];
                $jam_selesai = $_POST['jam_selesai'];

                // Query to update the doctor's schedule
                $queryUpdateSchedule = "UPDATE jadwal_periksa SET hari = '$hari', jam_mulai = '$jam_mulai', jam_selesai = '$jam_selesai' WHERE id = '$id_jadwal' AND id_dokter = '$id_dokter'";
                $resultUpdateSchedule = $mysqli->query($queryUpdateSchedule);

                if ($resultUpdateSchedule) {
                    echo "<script>alert('Jadwal periksa berhasil diupdate.');</script>";
                    // Redirect to the schedule page after update
                    echo "<script>window.location.href = 'jadwal_periksa.php';</script>";
                    exit;
                } else {
                    echo "Terjadi kesalahan saat mengupdate jadwal periksa: " . $mysqli->error;
                }
            }
        } else {
            echo "Terjadi kesalahan saat mengambil data jadwal periksa: " . $mysqli->error;
            exit;
        }
    } else {
        // If id parameter is not set, redirect to the schedule page
        header("Location: jadwal_dokter.php");
        exit;
    }
} else {
    echo "Terjadi kesalahan saat mengambil ID dokter: " . $mysqli->error;
    exit;
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
                                    <h3 class="card-title">Edit Jadwal</h3>
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
</html>
                </div>
                </div>
                </div>
                </div>
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

