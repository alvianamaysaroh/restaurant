<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php"); // Redirect jika bukan admin
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
</head>
<body>
    <h2>Selamat datang, Admin!</h2>
    <p>Ini adalah dashboard Admin.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
