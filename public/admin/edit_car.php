<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $image = $_POST['image'];

    $stmt = $conn->prepare("UPDATE cars SET name = ?, price = ?, stock = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sdisi", $name, $price, $stock, $image, $id);

    if ($stmt->execute()) {
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM cars WHERE id = $id");
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        // Handle case when no car is found with the given ID
        header('Location: dashboard.php');
        exit();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Car</title>
    <link rel="stylesheet" href="../admin/edit.css  ">
</head>
<body>
    <div class="main-content">
        <h1>Edit Car</h1>
        <form method="post" action="edit_car.php" class="edit-car-form">
            <input type="hidden" name="id" value="<?= htmlspecialchars($car['id']) ?>">
            <label for="name">Car Name:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($car['name']) ?>" required>
            <label for="price">Car Price:</label>
            <input type="number" step="0.01" id="price" name="price" value="<?= htmlspecialchars($car['price']) ?>" required>
            <label for="stock">Car Stock:</label>
            <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($car['stock']) ?>" required>
            <label for="image">Car Image URL:</label>
            <input type="text" id="image" name="image" value="<?= htmlspecialchars($car['image']) ?>" required>
            <button type="submit">Save Change Car</button>
            <?php if (isset($error)): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>

