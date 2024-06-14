<?php
session_start();

if (!isset($_SESSION['user_logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

include '../koneksi.php';

// Query for users
$users_sql = "SELECT id, username, role FROM users";
$users_result = $conn->query($users_sql);

// Query for cars
$cars_sql = "SELECT id, name, price, image, stock FROM cars";
$cars_result = $conn->query($cars_sql);

// Query for rentals
$rentals_sql = "SELECT id, car, name, ktp, address, phone, package, total_price FROM rentals";
$rentals_result = $conn->query($rentals_sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../admin/dashboard.css">
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <h2>Section Admin Dashboard</h2>
        </div>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="../php/logout.php">Logout</a></li>
        </ul>
    </div>
    <div class="main-content">
        <header>
            <h1>Welcome To The Admin Dashboard Section</h1>
            <p>Hello, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
        </header>
        <section>
            <h2>Users</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users_result->num_rows > 0): ?>
                        <?php while($row = $users_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['username']) ?></td>
                                <td><?= htmlspecialchars($row['role']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3">No users found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <section>
            <h2>Cars</h2>
            <button class="button-add" onclick="window.location.href='../admin/add_car.php'">Add New Car</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Stock</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($cars_result->num_rows > 0): ?>
                        <?php while($row = $cars_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td>IDR <?= number_format($row['price'], 0, ',', '.') ?></td>
                                <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>" width="50"></td>
                                <td><?= htmlspecialchars($row['stock']) ?></td>
                                <td>
                                    <button class="button-edit" onclick="window.location.href='edit_car.php?id=<?= htmlspecialchars($row['id']) ?>'">Edit</button>
                                    <button class="button-delete" onclick="window.location.href='delete_car.php?id=<?= htmlspecialchars($row['id']) ?>'">Delete</button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No cars found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
        <section>
        <section>
            <h2>Rentals</h2>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Car</th>
                        <th>Name</th>
                        <th>KTP</th>
                        <th>Address</th>
                        <th>Phone</th>
                        <th>Package</th>
                        <th>Total Price</th>
                        <th>Action</th> <!-- Tambah kolom action -->
                    </tr>
                </thead>
                <tbody>
                    <?php if ($rentals_result->num_rows > 0): ?>
                        <?php while($row = $rentals_result->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['id']) ?></td>
                                <td><?= htmlspecialchars($row['car']) ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['ktp']) ?></td>
                                <td><?= htmlspecialchars($row['address']) ?></td>
                                <td><?= htmlspecialchars($row['phone']) ?></td>
                                <td><?= htmlspecialchars($row['package']) ?></td>
                                <td>Rp. <?= number_format($row['total_price'], 0, ',', '.') ?></td>
                                <td>
                        <a class="button-delete" href="delete_rental.php?id=<?= htmlspecialchars($row['id']) ?>" onclick="return confirm('Are you sure you want to delete this rental?')"> Delete </a>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9">No rentals found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </div>
</body>
</html>

<?php
$conn->close();
?>
