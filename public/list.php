<?php
// Koneksi ke database
$servername = "localhost";
$username = "root"; // ganti dengan username MySQL Anda
$password = ""; // ganti dengan password MySQL Anda
$dbname = "rentalcars_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query untuk mengambil semua data pesanan
$sql = "SELECT * FROM rentals";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="css/rental.css">
</head>
<body>
    <div class="order-list-container">
        <button class="back-button" onclick="window.location.href='index.php'">Kembali</button>
        <h1>Daftar Pesanan</h1>
        <table class="order-table">
            <tr>
                <th>No</th>
                <th>Mobil</th>
                <th>Nama</th>
                <th>No. KTP</th>
                <th>Alamat</th>
                <th>No. Telp/HP</th>
                <th>Paket</th>
                <th>Total Harga</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                $counter = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>";
                    echo "<td>" . htmlspecialchars($row['car']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['ktp']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['address']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['packageDescription']) . "</td>";
                    echo "<td>Rp." . number_format($row['total_price'], 0, ',', '.') . "</td>";
                    echo "</tr>";
                    $counter++;
                }
            } else {
                echo "<tr><td colspan='8'>Tidak ada pesanan</td></tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
