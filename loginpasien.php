<!DOCTYPE html>
<html>
<head>
	<title>Login Dokter</title>
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
		<p class="tulisan_login">Silahkan login</p>
 
		<form action="cek_login.php" method="post">
			<label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama .." required="required">
 
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Password .." required="required">

      <div class="mb-3" >
          <small><a href="register.php" class="text-dark"><b><u>Belum Punya Akun ? Klik untuk Buat Akun!</u></b></a></small>
        </div>
 
			<input type="submit" class="tombol_login" value="LOGIN">
 
			<br/>
			<br/>
			<center>
				<a href="index.php">kembali</a>
			</center>
		</form>
		
	</div>
 
 
</body>
</html>