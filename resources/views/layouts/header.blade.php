<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentalCars</title>
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/ft.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="left-menu">
                <span class="menu"><a href="index.php">Home</a></span>
            </div>
            <div class="center-menu">
                <a href="#">RentalCars</a>
            </div>
            <div class="right-menu">
                <span class="call-us"><a href="list.php">🛒</a></span>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <span class="user-icon"><a href="php/logout.php">Logout</a></span>
                <?php else: ?>
                    <span class="user-icon"><a href="php/login.php">Login</a></span>
                <?php endif; ?>
            </div>
        </nav>
    </header>
