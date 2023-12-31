
<?php
include 'koneksi.php';

if (!isset($_SESSION)) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    

    // Periksa apakah pasien sudah terdaftar berdasarkan no KTP
    $queryCheckPasien = "SELECT * FROM pasien WHERE no_ktp = '$no_ktp'";
    $resultCheckPasien = $mysqli->query($queryCheckPasien);

    if (!$resultCheckPasien) {
        die("Query error: " . $mysqli->error);
    }

    if ($resultCheckPasien->num_rows > 0) {
        // Pasien sudah terdaftar, tampilkan pesan error
        $error = "Pasien dengan nomor KTP tersebut sudah terdaftar.";
    } else {
        // Pasien belum terdaftar, lakukan pendaftaran
        // Dapatkan tahun dan bulan saat ini
        $tahun_sekarang = date('Y');
        $bulan_sekarang = date('m');

        // Dapatkan nomor urut pasien untuk bulan ini
        $queryGetNomorUrut = "SELECT COUNT(*) as jumlah_pasien FROM pasien WHERE MONTH(NOW()) = '$bulan_sekarang'";
        $resultGetNomorUrut = $mysqli->query($queryGetNomorUrut);


        if ($resultGetNomorUrut) {
            $rowNomorUrut = $resultGetNomorUrut->fetch_assoc();
            $nomor_urut = $rowNomorUrut['jumlah_pasien'] + 1;
        
            // Format nomor rekam medis: tahun bulan - nomor urut
            $nomor_rm = $tahun_sekarang . str_pad($bulan_sekarang, 2, '0', STR_PAD_LEFT) . '-' . $nomor_urut;
        
            // Simpan data pasien ke dalam database
            $queryInsertPasien = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$nomor_rm')";
            $resultInsertPasien = $mysqli->query($queryInsertPasien);
        
            if ($resultInsertPasien) {
                $pesan = "Pendaftaran berhasil. Nomor Rekam Medis: $nomor_rm";
            } else {
                $error = "Terjadi kesalahan saat mendaftarkan pasien: " . $mysqli->error;
            }
        } else {
            $error = "Terjadi kesalahan saat mengambil nomor urut.";
        }

        $pesan = "Pendaftaran berhasil. Nomor Rekam Medis: $nomor_rm";
    }
}
?>

<?php 
include 'koneksi.php';

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
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include ("components/navbarpasien.php"); ?>
<?php include ("components/sidebarpasien.php"); ?>




  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

<head>
	<title>Registrassi</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
 
 
	<?php 
	if(isset($_GET['pesan'])){
		if($_GET['pesan']=="gagal"){
			echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
		}
	}
	?>
 
	<div class="kotak_login">
		<p class="tulisan_login">Silahkan Registrasi Akun Untuk Mendapatkan No RM</p>
 
		<form action="profilpasien.php" method="post">
			<label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama .." required="required">
 
			<label>Alamat</label>
			<input type="alamat" name="alamat" class="form_login" placeholder="Password .." required="required">

            <label>Nomor KTP</label>
			<input type="no_ktp" name="no_ktp" class="form_login" placeholder="No KTP .." required="required">

            <label>Nomor HP</label>
			<input type="no_hp" name="no_hp" class="form_login" placeholder="No HP .." required="required">
 
			<input type="submit" class="tombol_login" value="REGISTRASI">
 
			<br/>
			<br/>
			<center>
			</center>
		</form>


		
	</div>
 
 
</body>
<div id="popup" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2></h2>
        <center><strong><p><?php echo isset($pesan) ? $pesan : ''; ?></p></strong><center>
    </div>
</div>
<div id="popupGagal" class="popup">
    <div class="popup-content">
        <span class="close" onclick="closePopupGagal()">&times;</span>
        <center><h2></h2>
        <p><?php echo isset($error) ? $error : ''; ?></p><center>
    </div>
</div>
<script>
    function showPopup() {
        document.getElementById('popup').style.display = 'block';
    }

    function closePopup() {
        document.getElementById('popup').style.display = 'none';
    }

    // Tampilkan pop-up jika variabel $nomor_rm terdefinisi
    <?php echo isset($nomor_rm) ? 'showPopup();' : ''; ?>
</script>
<script>
    function showPopupGagal() {
        document.getElementById('popupGagal').style.display = 'block';
    }

    function closePopupGagal() {
        document.getElementById('popupGagal').style.display = 'none';
    }

    // Tampilkan pop-up gagal jika variabel $error terdefinisi
    <?php echo isset($error) ? 'showPopupGagal();' : ''; ?>
</script>



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


