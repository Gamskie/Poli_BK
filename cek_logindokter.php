<?php
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari formulir
    $nama = $_POST['nama'];
    $password = $_POST['password'];

    // Query untuk mencari dokter berdasarkan nama dan password
    $queryCekDokter = "SELECT * FROM dokter WHERE nama = '$nama' AND password = '$password'";
    $resultCekDokter = $mysqli->query($queryCekDokter);

    if ($resultCekDokter) {
        // Cek apakah data dokter ditemukan
        if ($resultCekDokter->num_rows == 1) {
            // Dokter ditemukan, set sesi dan redirect ke halaman dokter
            session_start();
            $_SESSION['nama_dokter'] = $nama;
            header("Location: dokter.php");
            exit;
        } else {
            // Dokter tidak ditemukan, kembali ke halaman login dengan pesan gagal
            header("Location: logindokter.php?pesan=gagal");
            exit;
        }
    } else {
        // Terjadi kesalahan query
        die("Query error: " . $mysqli->error);
    }
} else {
    // Jika bukan metode POST, kembali ke halaman login
    header("Location: logindokter.php");
    exit;
}
?>
