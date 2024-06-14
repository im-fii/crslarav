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

$name = $_POST['name'];
$ktp = $_POST['ktp'];
$address = $_POST['address'];
$phone = $_POST['phone'];
$car = $_POST['car'];
$package = $_POST['package'];
$packageDescription = $_POST['packageDescription'];
$total_price = 0; // Hitung total harga berdasarkan logika yang ada

if ($package === '3') {
    $total_price = 1000000 * 3;
} else if ($package === '5') {
    $total_price = 1000000 * 5;
} else if ($package === '7') {
    $total_price = 1000000 * 7;
}

$stmt = $conn->prepare("INSERT INTO rentals (name, ktp, address, phone, car, package, packageDescription, total_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $name, $ktp, $address, $phone, $car, $package, $packageDescription, $total_price);

if ($stmt->execute()) {
    $transaction_id = $stmt->insert_id;
    echo json_encode(['success' => true, 'id' => $transaction_id]);
} else {
    echo json_encode(['success' => false]);
}

$stmt->close();
$conn->close();
?>
