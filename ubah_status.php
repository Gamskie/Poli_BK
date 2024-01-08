<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id']) && isset($_GET['status'])) {
    $id_jadwal = $_GET['id'];
    $status = $_GET['status'];

    // Update status jadwal periksa
    $queryUpdateStatus = "UPDATE jadwal_periksa SET status = '$status' WHERE id = '$id_jadwal'";
    $resultUpdateStatus = $mysqli->query($queryUpdateStatus);

    if ($resultUpdateStatus) {
        header("Location: jadwal_periksa.php"); // Redirect kembali ke halaman jadwal periksa
        exit;
    } else {
        echo "Gagal mengubah status: " . $mysqli->error;
    }
} else {
    echo "Permintaan tidak valid.";
}
?>
