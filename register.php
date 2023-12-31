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
		<p class="tulisan_login">Silahkan Registrasi Akun</p>
 
		<form action="simpan_registrasi.php" method="post">
			<label>Nama</label>
			<input type="text" name="nama" class="form_login" placeholder="Nama .." required="required">
 
			<label>Password</label>
			<input type="password" name="password" class="form_login" placeholder="Password .." required="required">

           
         
          <label>Status Registrasi</label>
          <select class="form_login" name="status" value="pasien">
            <option value="pasien">pasien</option>
          </select>
        
 
			<input type="submit" class="tombol_login" value="REGISTRASI">
 
			<br/>
			<br/>
			<center>
				<a href="index.php">kembali</a>
			</center>
		</form>
		
	</div>
 
 
</body>
</html>