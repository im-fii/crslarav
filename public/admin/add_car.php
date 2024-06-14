<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO cars (name, price, image, stock) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sdsi", $name, $price, $image, $stock);
    
    if ($stmt->execute()) {
        // Redirect to dashboard with success message
        header('Location: dashboard.php?success=1');
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Car</title>
    <link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>
    <div class="main-content">
        <h1>Add New Car</h1>
        <form class="add-car-form" method="post" action="add_car.php">
            <label for="name">Car Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="price">Car Price:</label>
            <input type="number" step="0.01" id="price" name="price" required>
            <label for="image">Car Image URL:</label>
            <input type="text" id="image" name="image" required>
            <label for="stock">Car Stock:</label>
            <input type="number" id="stock" name="stock" required>
            <button class="button-add" type="submit">Add Car</button>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>
