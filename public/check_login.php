<?php
session_start();

// Simulasikan status login (ini harus diubah dengan pemeriksaan login yang sebenarnya)
$is_logged_in = isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === true;

if (!$is_logged_in) {
    $redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.html';
    header("Location: php/login.php?redirect=" . urlencode($redirect_url));
    exit();
}

// Jika sudah login, arahkan ke halaman yang diminta
$redirect_url = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.html';
header("Location: " . $redirect_url);
exit();
?>
