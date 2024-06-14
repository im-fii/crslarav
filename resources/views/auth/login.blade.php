<?php
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

    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                if ($role === 'admin') {
                    // Redirect to admin dashboard
                    header('Location: ../admin/dashboard.php');
                } else {
                    // Redirect to the index page after successful login
                    header('Location: ../index.php');
                }
                exit();
            } else {
                $login_error = 'Login lu gabisa kocak, coba benerin lagi...';
            }
        } else {
            $login_error = 'Login lu gabisa kocak, coba benerin lagi...';
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form method="post" action="login.php">
                <h2>Login</h2>
                <input class="form-input" type="text" name="username" placeholder="Username" required>
                <input class="form-input" type="password" name="password" placeholder="Password" required>
                <br>
                <button class="form-button" type="submit">Log In</button>
                <p>Gak Punya Akun?, Buat Dlu yee <a href="signup.php">Sign up</a></p>
            </form>
            <?php if (isset($login_error)): ?>
                <p class="error"><?= htmlspecialchars($login_error) ?></p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
