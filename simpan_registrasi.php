<?php
//Include file koneksi ke database
include "koneksi.php";

//menerima nilai dari kiriman form pendaftaran
$nama=$_POST["nama"];
$password=$_POST["password"]; //untuk password digunakan enskripsi md5
$status=$_POST["status"];



//Menginput data ke tabel
  $hasil=mysqli_query($mysqli, "INSERT INTO user (nama,password,status) VALUES('$nama','$password','$status')");

//Kondisi apakah berhasil atau tidak
  if ($hasil) 
  {
	echo "<script>
				alert('Anda Berhasil Registrasi !');
				document.location='index.php';
		  </script>";
  }
  else 
  {
	echo "<script>
				alert('Registrasi Anda Gagal !');
				document.location='register.php';
		  </script>";
  }

?>