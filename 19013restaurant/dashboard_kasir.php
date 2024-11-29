<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'kasir') {
    header("Location: login.php"); // Redirect jika bukan kasir
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
</head>
<body>
    <h2>Selamat datang, Kasir!</h2>
    <p>Ini adalah dashboard Kasir.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
