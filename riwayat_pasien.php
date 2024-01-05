<?php
include('koneksi.php');
// Start the session

// Query untuk mengambil data pasien dari tabel periksa
$queryPasien = "SELECT detail_periksa.id AS nomer, id_periksa, id_obat, periksa.id AS id_periksa, obat.nama_obat AS namaobat, dokter.nama AS namadokter, periksa.catatan, periksa.tgl_periksa, periksa.biaya_periksa AS totalbiaya, daftar_poli.id_pasien, pasien.nama AS nama_pasien, pasien.alamat AS alamat_pasien, pasien.no_ktp AS ktp_pasien, pasien.no_hp AS hp_pasien, pasien.no_rm AS rm_pasien
                FROM detail_periksa
                INNER JOIN obat ON obat.id = id_obat
                INNER JOIN periksa ON periksa.id = id_periksa
                INNER JOIN daftar_poli ON periksa.id_daftar_poli = daftar_poli.id
                INNER JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id
                INNER JOIN dokter ON dokter.id = jadwal_periksa.id_dokter
                INNER JOIN pasien ON daftar_poli.id_pasien = pasien.id";

$resultPasien = $mysqli->query($queryPasien);

if (!$resultPasien) {
    // Tambahkan penanganan kesalahan
    die("Error: " . $mysqli->error);
}
?>

<!DOCTYPE html>
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
        <?php include("components/navbardokter.php"); ?>
        <?php include("components/sidebardokter.php"); ?>
        <div class="content-wrapper">
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Riwayat Pasien</h3>
                                </div>
                                <?php if ($resultPasien) { ?>
                                    <div class="card-body">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Nama Pasien</th>
                                                    <th>Alamat</th>
                                                    <th>No KTP</th>
                                                    <th>Nomor Telepon</th>
                                                    <th>Nomor RM</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php while ($rowPasien = $resultPasien->fetch_assoc()) { ?>
                                                    <tr>
                                                        <td><?php echo $rowPasien['nomer']; ?></td>
                                                        <td><?php echo $rowPasien['nama_pasien']; ?></td>
                                                        <td><?php echo $rowPasien['alamat_pasien']; ?></td>
                                                        <td><?php echo $rowPasien['ktp_pasien']; ?></td>
                                                        <td><?php echo $rowPasien['hp_pasien']; ?></td>
                                                        <td><?php echo $rowPasien['rm_pasien']; ?></td>
                                                        <td>
                                                            <button class="btn btn-info" data-toggle="modal" data-target="#detailModal<?php echo $rowPasien['ktp_pasien']; ?>">Lihat Detail</button>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else {
                                    echo "Terjadi kesalahan saat mengambil data pasien: " . $mysqli->error;
                                } ?>
                            </div>
                        </div>
                    </div>
                </div>

                <?php
                // Reset result set pointer
                mysqli_data_seek($resultPasien, 0);

                while ($rowPasien = $resultPasien->fetch_assoc()) {
                ?>
                    <!-- Modal for each row -->
                    <div class='modal fade' id='detailModal<?php echo $rowPasien['ktp_pasien']; ?>' tabindex='-1' role='dialog' aria-labelledby='detailModalLabel' aria-hidden='true'>
                        <div class='modal-dialog' role='document'>
                            <div class='modal-content'>
                                <div class='modal-header'>
                                    <h5 class='modal-title' id='detailModalLabel'>Detail Pasien</h5>
                                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                        <span aria-hidden='true'>&times;</span>
                                    </button>
                                </div>
                                <div class='modal-body'>
                                    <!-- Table to display details -->
                                    <table class='table'>
                                        <tr>
                                            <th>Nama Pasien</th>
                                            <td><?php echo $rowPasien['nama_pasien']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Tanggal Periksa</th>
                                            <td><?php echo $rowPasien['tgl_periksa']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Nama Dokter</th>
                                            <td><?php echo $rowPasien['namadokter']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Keluhan</th>
                                            <td><?php echo $rowPasien['catatan']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Obat</th>
                                            <td><?php echo $rowPasien['namaobat']; ?></td>
                                        </tr>
                                        <tr>
                                            <th>Biaya Periksa</th>
                                            <td><?php echo $rowPasien['totalbiaya']; ?></td>
                                        </tr>
                                    </table>
                                </div>
                                <div class='modal-footer'>
                                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </section>
        </div>
    </div>
</html>


  



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

