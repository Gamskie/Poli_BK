<?php 
// mengaktifkan session pada php
session_start();
 
// menghubungkan php dengan koneksi database
include 'koneksi.php';
 
// menangkap data yang dikirim dari form login
$nama = $_POST['nama'];
$password = $_POST['password'];
 
 
// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($mysqli,"select * from user where nama='$nama' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);
 
// cek apakah username dan password di temukan pada database
if($cek > 0){
 
	$data = mysqli_fetch_assoc($login);
 
	// cek jika user login sebagai admin
	if($data['status']=="admin"){
 
		// buat session login dan username
		$_SESSION['nama'] = $nama;
		$_SESSION['status'] = "admin";
		// alihkan ke halaman dashboard admin
		header("location:admin.php");
 
	// cek jika user login sebagai pegawai
	}else if($data['status']=="dokter"){
		// buat session login dan username
		$_SESSION['nama'] = $nama;
		$_SESSION['status'] = "dokter";
		// alihkan ke halaman dashboard pegawai
		header("location:dokter.php");
 
	// cek jika user login sebagai pengurus
	}else if($data['status']=="pasien"){
		// buat session login dan username
		$_SESSION['nama'] = $nama;
		$_SESSION['status'] = "pasien";
		// alihkan ke halaman dashboard pengurus
		header("location:pasien.php");
 
	}else{
 
		// alihkan ke halaman login kembali
		header("location:index.php?pesan=gagal");
	}	
}else{
	header("location:index.php?pesan=gagal");
}
 
?>


