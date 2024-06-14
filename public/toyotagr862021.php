<?php
include 'koneksi.php';
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

    <?php
    $carName = "Toyota GR86 2021";
    $stmt = $conn->prepare("SELECT price, image, stock FROM cars WHERE name = ?");
    $stmt->bind_param("s", $carName);
    $carDescription = "Mobil ini dibekali dengan mesin 8 silinder V8 berkapasitas 3.9 Liter, twin-turbocharger, serta transmisi otomatis Dual-Clutch 7 percepatan.<br><br>Mesin ini bisa menghasilkan tenaga mencapai 711 hp. Mobil ini bisa melesat dari 0 – 100 km/jam dalam 2.9 detik.";
    $stmt->execute();
    $stmt->bind_result($price, $image, $stock);
    $stmt->fetch();
    $stmt->close();

    $formattedPrice = "IDR " . number_format($price, 0, ',', '.');
    ?>

    <main>
        <div class="car-details">
            <div class="car-image">
                <img src="images\gt68.png" alt="HR-V">
            </div>
            <div class="car-info">
                <h1><?php echo htmlspecialchars($carName); ?></h1>
                <p class="price"><?php echo $formattedPrice; ?></p>
                <p class="stock">
                    Stok mobil: <?php echo $stock; ?>
                </p>
                <br>
                <?php if ($stock > 0) : ?>
                    <a href="check_login.php?redirect=rental.php?car=<?php echo urlencode($carName); ?>" class="rent-btn">Rental sekarang juga!</a>
                <?php else : ?>
                    <button class="rent-btn" disabled>Mobil Tidak Tersedia</button>
                <?php endif; ?>
                <p class="description"><?php echo $carDescription; ?></p>
            </div>
        </div>
    </main>
</body>
</html>
<?php $conn->close(); ?>
