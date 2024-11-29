<?php
// Bisa memulai sesi untuk kontrol akses pengguna
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Restoran</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            width: 260px;
            background-color: #fdf1e8;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 20px;
            display: flex;
            flex-direction: column;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
        }
        .sidebar h2 {
            font-size: 24px;
            color: #000;
            text-align: center;
            margin-bottom: 40px;
        }
        .sidebar .nav-link {
            padding: 12px 20px;
            text-decoration: none;
            color: #6e6e6e;
            font-size: 16px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 8px 15px;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link.active {
            background-color: #f57c00;
            color: white;
        }
        .main-content {
            margin-left: 300px;
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Yummy Yippie</h2>
        <a href="index.php" class="nav-link">Beranda</a>
        <a href="menu.php" class="nav-link active">Menu</a>
        <a href="order.php" class="nav-link">Order</a>
        <a href="transaksi.php" class="nav-link">Transaksi</a>
        <a href="laporan.php" class="nav-link">Laporan</a>
        <a href="logout.php" class="nav-link">Logout</a>
    </div>
