<?php
// Start session
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // ganti dengan username MySQL Anda
$password = ""; // ganti dengan password MySQL Anda
$dbname = "rentalcars_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password === $confirm_password) {
        // Hash the password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Redirect to the login page after successful signup
            header('Location: login.php');
            exit();
        } else {
            $signup_error = 'Error: ' . $stmt->error;
        }

        $stmt->close();
    } else {
        $signup_error = 'Passwords do not match.';
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post" action="signup.php">
                <h2>Sign Up</h2>
                <input class="form-input" type="text" name="username" placeholder="Username" required>
                <input class="form-input" type="password" name="password" placeholder="Password" required>
                <input class="form-input" type="password" name="confirm_password" placeholder="Confirm Password" required>
                <br>
                <br>
                <br>
                <button class="form-button" type="submit">Sign Up</button>
                <p>Already have an account? <a href="login.php">Log in</a></p>
            </form>
            <?php if (isset($signup_error)): ?>
                <p class="error"><?= htmlspecialchars($signup_error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
