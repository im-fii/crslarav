<?php
include 'koneksi.php';
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentalCars</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/foot.css">
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
                <span class="list-chart">
                    <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                        <a href="list.php">🛒</a>
                    <?php else: ?>
                        <a href="php/login.php">🛒</a>
                    <?php endif; ?>
                </span>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <span class="user-icon"><a href="php/logout.php">Logout</a></span>
                <?php else: ?>
                    <span class="user-icon"><a href="php/login.php">Login</a></span>
                <?php endif; ?>
            </div>
        </nav>
    </header>
    <main>
        <div class="hero-section">
            <img src="images/crs.jpg" alt="Sports Cars" class="background-image">
            <div class="hero-text">
                <h1>Awesome Rental SUV Cars</h1>
                <p class="subtitle">The best car rental with quality luxury cars at affordable prices</p>
                <p class="subtitle2">For only 1 million you can rent a car <a href="#recommended-section" class="link-to-section">here</a></p>
            </div>
        </div>
        <div id="recommended-section" class="car-gallery">
            <?php
                $sql = "SELECT name, price, image, stock FROM cars";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $name = htmlspecialchars($row['name']);
                        $page = strtolower(str_replace(' ', '', $name)) . '.php';
                        echo '<div class="car-item">';
                        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) {
                            echo '<a href="' . $page . '">';
                        } else {
                            echo '<a href="php/login.php">';
                        }
                        echo '<img src="' . htmlspecialchars($row['image']) . '" alt="' . $name . '">';
                        echo '<div class="car-info">';
                        echo '<h2>' . $name . '</h2>';
                        echo '<p>IDR ' . number_format($row['price'], 0, ',', '.') . '/day</p><br>';
                        echo '<p>Stok: ' . htmlspecialchars($row['stock']) . '</p>';
                        echo '</div>';
                        echo '</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No cars available</p>';
                }

                $conn->close();
            ?>
        </div>
    </main>
    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <h2>About</h2>
                <p> Website ini menyediakan layanan sewa mobil SUV berkualitas untuk kenyamanan perjalanan Anda. Dengan berbagai pilihan SUV yang terawat, kami siap memenuhi kebutuhan perjalanan Anda, baik untuk liburan keluarga, perjalanan bisnis, atau petualangan akhir pekan.</p>
            </div>
            <div class="footer-right">
                <h2><a href="#">Contact Us</a></h2>
                <div class="social-icons">
                    <a href="https://wa.me/62895410311243" target="_blank"><img src="images/whatsapp-icon.png" alt="WhatsApp"></a>
                    <a href="https://twitter.com/mynmeisfi" target="_blank"><img src="images/xicon.png" alt="Twitter"></a>
                    <a href="https://instagram.com/wldannrsbahh" target="_blank"><img src="images/igicon.png" alt="Instagram"></a>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 | LoyoTeams Website</p>
        </div>
    </footer>
    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>
