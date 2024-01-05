
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
  if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['simpanPeriksa'])) {
    $hasil_pemeriksaan = $_POST['hasil_pemeriksaan'];
    $id_daftar_poli = $_POST['id_daftar_poli'];
    $tgl_periksa = $_POST['tgl_periksa'];
    $total_biaya_obat = $_POST['total_biaya'];
    $total_biaya_periksa = $_POST['total_biaya_periksa'];
    $obat_terpilih = isset($_POST['obat']) ? $_POST['obat'] : [];

    // Insert data ke tabel periksa
    $queryInsertPeriksa = "INSERT INTO periksa (id_daftar_poli, tgl_periksa, catatan, biaya_periksa) 
    VALUES ('$id_daftar_poli', '$tgl_periksa', '$hasil_pemeriksaan', '$total_biaya_obat')";
$resultInsertPeriksa = $mysqli->query($queryInsertPeriksa);

if ($resultInsertPeriksa) {
// Get the ID of the newly inserted periksa record
$id_periksa = $mysqli->insert_id;

// Loop through each selected obat and insert into 'detail_periksa'
foreach ($obat_terpilih as $id_obat) {
$queryInsertDetailPeriksa = "INSERT INTO detail_periksa (id_periksa, id_obat) 
                VALUES ('$id_periksa', '$id_obat')";
$resultInsertDetailPeriksa = $mysqli->query($queryInsertDetailPeriksa);

if (!$resultInsertDetailPeriksa) {
echo "Gagal menyimpan detail periksa: " . $mysqli->error;
exit;
}
}

// Display success message or redirect as needed
echo "<script>alert('Pemeriksaan dan detail obat berhasil disimpan.');</script>";
} else {
echo "Gagal menyimpan ke tabel periksa: " . $mysqli->error;
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
        <?php include("components/navbardokter.php"); ?>
        <?php include("components/sidebardokter.php"); ?>
        <div class="content-wrapper">
        <?php
            // Query untuk mengambil data daftar_poli dan mengurutkannya berdasarkan no_antrian
            $queryDaftarAntrian = "SELECT daftar_poli.id AS id_daftar_poli, no_antrian, pasien.nama AS nama_pasien, jadwal_periksa.hari, jadwal_periksa.jam_mulai, jadwal_periksa.jam_selesai, poli.nama_poli, dokter.nama AS nama_dokter, daftar_poli.keluhan
                                FROM daftar_poli
                                INNER JOIN pasien ON daftar_poli.id_pasien = pasien.id
                                INNER JOIN jadwal_periksa ON daftar_poli.id_jadwal = jadwal_periksa.id
                                INNER JOIN dokter ON jadwal_periksa.id_dokter = dokter.id
                                INNER JOIN poli ON dokter.id_poli = poli.id
                                ORDER BY no_antrian";

            $resultDaftarAntrian = $mysqli->query($queryDaftarAntrian);

            if ($resultDaftarAntrian) {
            ?>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Periksa Pasien</h3>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        
                                        <thead>
                                            <tr>
                                                <th>No Antrian</th>
                                                <th>Nama Pasien</th>
                                                <th>No ID</th>
                                                <th>Jadwal</th>
                                                <th>Action</th>
                                                
                                            </tr>
                                            <tbody>
                                            <div class="modal-body">
                            <?php
                            while ($row = $resultDaftarAntrian->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['no_antrian'] . "</td>";
                                echo "<td>" . $row['nama_pasien'] . "</td>";
                                echo "<td>" . $row['id_daftar_poli'] . "</td>";
                                echo "<td>" . $row['hari'] . ", " . $row['jam_mulai'] . " - " . $row['jam_selesai'] . ", " .
                                    $row['nama_poli'] . " - Dr. " . $row['nama_dokter'] . "</td>";
                                echo "<td><button class='btn btn-primary' data-toggle='modal' data-target='#periksaModal{$row['no_antrian']}'>Periksa</button></td>";
                                echo "</tr>";

                                // Modal
                                echo "<div class='modal fade' id='periksaModal{$row['no_antrian']}' tabindex='-1' role='dialog' aria-labelledby='periksaModalLabel' aria-hidden='true'>";
                                echo "<div class='modal-dialog' role='document'>";
                                echo "<div class='modal-content'>";
                                echo "<div class='modal-header'>";
                                echo "<h5 class='modal-title' id='periksaModalLabel'>Periksa Pasien</h5>";
                                echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
                                echo "<span aria-hidden='true'>&times;</span>";
                                echo "</button>";
                                echo "</div>";
                                echo "<div class='modal-body'>";
                                // Tampilkan data dan form periksa di sini
                                echo "<p>Nama Pasien: {$row['nama_pasien']}</p>";
                                echo "<p>Keluhan: {$row['keluhan']}</p>";
                                echo "<p>id_daftar_poli: {$row['id_daftar_poli']}</p>";
                                // Tambahkan form untuk hasil pemeriksaan, obat, dan total biaya
                                echo "<form action='periksa_pasien.php' method='POST'>";
                                echo "<input type='hidden' name='no_antrian' value='{$row['no_antrian']}'>";
                                echo "<input type='hidden' name='tgl_periksa' value='" . date('Y-m-d h:i:s') . "'>";
                                echo "<input type='hidden' name='id_daftar_poli' value='{$row['id_daftar_poli']}'>";
                                echo "<div class='form-group'>";
                                echo "<label for='hasil_pemeriksaan'>Hasil Pemeriksaan:</label>";
                                echo "<textarea class='form-control' name='hasil_pemeriksaan' rows='3' required></textarea>";
                                echo "</div>";

                                // Bagian 1: List obat yang ada
                                $queryObat = "SELECT * FROM obat";
                                $resultObat = $mysqli->query($queryObat);

                                echo "<div class='form-group'>";
                                echo "<label for='list_obat'>List Obat:</label>";
                                echo "<select class='form-control' name='list_obat' size='5'>";

                                while ($rowObat = $resultObat->fetch_assoc()) {
                                    echo "<option value='{$rowObat['id']}' data-harga='{$rowObat['harga']}'>{$rowObat['nama_obat']}</option>";
                                }

                                echo "</select>";
                                echo "</div>";

                                // Bagian 2: Tombol pilih dibawah list obat
                                echo "<button type='button' class='btn btn-primary' id='pilihObatBtn'>Pilih Obat</button>";

                                // Bagian 3: Obat yang dipilih
                                echo "<div class='form-group mt-3'>";
                                echo "<label for='obat'>Obat yang Dipilih:</label>";
                                echo "<select multiple class='form-control' name='obat[]' id='obatPilihan'>";
                                echo "</select>";
                                echo "</div>";

                                // Bagian 4: Tombol hapus dibawah obat dipilih
                                echo "<button type='button' class='btn btn-primary' id='hapusObatBtn'>Hapus Obat</button>";

                                // Tambahkan input untuk total biaya]
                                
                                echo "<div class='form-group'>";
                                echo "<label for='total_biaya'>Total Biaya:</label>";
                                echo "<label for='total_biaya'>*Total harga sudah termasuk biaya periksa Rp.100.000</label>";
                                echo "<input type='text' class='form-control' name='total_biaya' readonly>";
                                echo "</div>";

                                // Tambahkan input tersembunyi untuk total biaya periksa
                                echo "<input type='hidden' name='total_biaya_periksa' id='total_biaya_periksa' value=''>";
                                echo "<button type='submit' class='btn btn-primary' name='simpanPeriksa'>Simpan</button>";
                                echo "</form>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                                echo "</div>";
                            }
                            ?>
                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php

} else {
    echo "Terjadi kesalahan saat mengambil data daftar antrian poliklinik: " . $mysqli->error;
}
?>
            </section>
            <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <script>
                // Tambahkan script untuk menghitung total biaya
                $(document).ready(function() {
                    $('select[name="obat[]"]').change(function() {
                        var totalBiaya = 100000;
                        $('select[name="obat[]"] option:selected').each(function() {
                            totalBiaya += parseFloat($(this).data('harga'));
                        });
                        $('input[name="total_biaya"]').val(totalBiaya);

                        // Perbarui total_biaya_periksa
                        var totalBiayaPeriksa = totalBiaya + parseFloat($('#total_biaya_periksa').val());
                        $('#total_biaya_periksa').val(totalBiayaPeriksa);
                    });

                    // Bagian 2: Tombol pilih dibawah list obat
                    $('#pilihObatBtn').click(function() {
                        var selectedObat = $('select[name="list_obat"] option:selected');

                        // Pindahkan obat yang dipilih ke bagian 3
                        selectedObat.clone().appendTo('#obatPilihan');
                    });

                    // Bagian 3: Menghitung total biaya obat yang dipilih
                    $('#obatPilihan').change(function() {
                        var totalBiaya = 100000;
                        $('#obatPilihan option').each(function() {
                            totalBiaya += parseFloat($(this).data('harga'));
                        });
                        $('input[name="total_biaya"]').val(totalBiaya);
                    });

                    // Bagian 4: Tombol hapus di bawah "obat yang dipilih"
                    $('#hapusObatBtn').click(function() {
                        var selectedObat = $('#obatPilihan option:selected');

                        // Hapus obat yang dipilih
                        selectedObat.remove().empty();

                        // Hitung kembali total biaya setelah menghapus
                        var totalBiaya = 100000;
                        $('#obatPilihan option').each(function() {
                            totalBiaya += parseFloat($(this).data('harga'));
                        });
                        $('input[name="total_biaya"]').val(totalBiaya);
                    });

                });
            </script>
    
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
