<?php
include 'koneksi.php';
?>

<?php
session_start();

$id = $_GET['id'];
$car_sql = "SELECT * FROM cars WHERE id = $id";
$car_result = $conn->query($car_sql);
$car = $car_result->fetch_assoc();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/car-details.css">
</head>
<body>
    <?php include 'php/header.php'; ?>

    <main>
        <div class="car-details">
            <div class="car-image">
                <img src="<?= htmlspecialchars($car['image']) ?>" alt="<?= htmlspecialchars($car['name']) ?>">
            </div>
            <div class="car-info">
                <h1><?= htmlspecialchars($car['name']) ?></h1>
                <p class="price"><?= htmlspecialchars($car['price']) ?></p>
                <p class="status">
                    Status mobil: <?= $car['status'] == "available" ? "Tersedia" : "Tidak Tersedia"; ?>
                </p>
                <br>
                <?php if ($car['status'] == "available") : ?>
                    <a href="check_login.php?redirect=rental.php?car=<?= urlencode($car['name']) ?>" class="rent-btn">Rental sekarang juga !</a>
                <?php else : ?>
                    <button class="rent-btn" disabled>Mobil Tidak Tersedia</button>
                <?php endif; ?>
                <p class="description"><?= htmlspecialchars($car['description']) ?></p>
            </div>
        </div>
    </main>
</body>
</html>
