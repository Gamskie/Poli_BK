<?php
    include("../../koneksi.php");

    $id = $_GET['id']; //mengambil id user yang ingin diubah

    //menampilkan user berdasarkan id
    $data = mysqli_query($mysqli, "select * from obat where id = '$id'");
    $row = mysqli_fetch_assoc($data);
?>

<!-- Modal -->

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ADMIN</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<?php include ("../../components/navbar.php"); ?>
<?php include ("../../components/sidebareditobat.php"); ?>




  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
        <h1 class="m-0">Manajemen Obat</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="index.php?page=home">Home</a></li>
            <li class="breadcrumb-item active">Obat</li>
        </ol>
        </div><!-- /.col -->
    </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
    <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
            <h3 class="card-title">Data Obat</h3>

            </div>
            <!-- /.card-header -->
            

            <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
                <tbody>               
</div>
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Obat</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <table class="table table-hover text-nowrap">
                <thead>

                </thead>
            <div class="modal-body">
                <form id="editForm" method="POST" action="updateObat.php">
                    <input type="hidden" name="id" value="<?= $row['id']; ?>">
                    <div class="form-group">
                        <label for="nama_obat">Nama Obat</label>
                        <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="<?= $row['nama_obat']; ?>"required>
                    </div>
                    <div class="form-group">
                        <label for="kemasan">Kemasan</label>
                        <input type="text" class="form-control" id="kemasan" name="kemasan" value="<?= $row['kemasan']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga</label>
                        <input type="text" class="form-control" id="harga" name="harga" value="<?= $row['harga']; ?>" required>
                    </div>
                  
                    <input type="submit" name="submit" value="Update" class="btn btn-primary">
                </form>
            </div>
        </div>
    </div>
</div>
</tbody>
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