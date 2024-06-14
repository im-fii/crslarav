<?php
// Pastikan ID rental disediakan
if (!isset($_GET['id'])) {
    // Jika tidak disediakan, kembalikan ke halaman dashboard
    header('Location: dashboard.php');
    exit();
}

// Sambungkan ke database
include '../koneksi.php';

// Tangkap ID rental yang akan dihapus
$id = $_GET['id'];

// Perintah SQL untuk menghapus rental berdasarkan ID
$delete_sql = "DELETE FROM rentals WHERE id = $id";

// Jalankan perintah penghapusan
if ($conn->query($delete_sql) === TRUE) {
    // Jika penghapusan berhasil, kembali ke halaman dashboard
    header('Location: dashboard.php');
} else {
    // Jika terjadi kesalahan, tampilkan pesan kesalahan
    echo "Error deleting record: " . $conn->error;
}

// Tutup koneksi database
$conn->close();
?>
