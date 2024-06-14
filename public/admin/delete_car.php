<?php
include '../koneksi.php';
?>

<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM cars WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header('Location: dashboard.php');
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
