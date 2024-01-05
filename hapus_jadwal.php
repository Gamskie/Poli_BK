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

// Check if the schedule ID is provided
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_jadwal = $_GET['id'];

    // Get the doctor's ID
    $nama_dokter = $_SESSION['nama_dokter'];
    $queryGetDoctorID = "SELECT id FROM dokter WHERE nama = '$nama_dokter'";
    $resultGetDoctorID = $mysqli->query($queryGetDoctorID);

    if ($resultGetDoctorID) {
        $rowDoctorID = $resultGetDoctorID->fetch_assoc();
        $id_dokter = $rowDoctorID['id'];

        // Delete the schedule from the database
        $queryDeleteSchedule = "DELETE FROM jadwal_periksa WHERE id = '$id_jadwal' AND id_dokter = '$id_dokter'";
        $resultDeleteSchedule = $mysqli->query($queryDeleteSchedule);

        if ($resultDeleteSchedule) {
            echo "<script>alert('Jadwal berhasil dihapus.');</script>";
            echo "<script>window.location.href = 'jadwal_periksa.php';</script>";
            exit;
        } else {
            echo "Terjadi kesalahan saat menghapus jadwal: " . $mysqli->error;
        }
    } else {
        echo "Terjadi kesalahan saat mengambil ID dokter: " . $mysqli->error;
    }
} else {
    echo "ID jadwal tidak valid.";
}
?>