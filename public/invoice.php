<?php
session_start();
// Koneksi ke database
$servername = "localhost";
$username = "root"; // ganti dengan username MySQL Anda
$password = ""; // ganti dengan password MySQL Anda
$dbname = "rentalcars_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    die("ID transaksi tidak ditemukan.");
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM rentals WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$transaction = $result->fetch_assoc();

if (!$transaction) {
    die("Transaksi tidak ditemukan.");
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="css/popup.css">
</head>
<body>
    <div class="invoice-container">
        <h1>Invoice</h1>
        <p>Terima kasih atas pemesanan Anda. Berikut adalah detail transaksi Anda:</p>
        <table class="invoice-table">
            <tr>
                <th>Mobil</th>
                <td><?= htmlspecialchars($transaction['car']) ?></td>
            </tr>
            <tr>
                <th>Nama</th>
                <td><?= htmlspecialchars($transaction['name']) ?></td>
            </tr>
            <tr>
                <th>No. KTP</th>
                <td><?= htmlspecialchars($transaction['ktp']) ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?= htmlspecialchars($transaction['address']) ?></td>
            </tr>
            <tr>
                <th>No. Telp/HP</th>
                <td><?= htmlspecialchars($transaction['phone']) ?></td>
            </tr>
            <tr>
                <th>Paket</th>
                <td><?= htmlspecialchars($transaction['packageDescription']) ?></td>
            </tr>
            <tr>
                <th>Total Harga</th>
                <td>Rp.<?= number_format($transaction['total_price'], 0, ',', '.') ?></td>
            </tr>
        </table>
    </div>
    <script>
        function viewOrders() {
            window.location.href = 'list.php';
        }
    </script>
</body>
</html>
