<?php
session_start();
include('koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir Restoran</title>
    <!-- Link ke Google Fonts untuk font modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <!-- Link ke Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Gaya Umum */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF5EE; /* Latar belakang terang */
        }

        /* Sidebar */
        .sidebar {
            height: calc(100vh - 80px); /* Memberi jarak lebih besar di atas dan bawah */
            width: 260px; /* Sidebar lebih besar */
            background-color: #fff; /* Warna beige lembut */
            position: fixed;
            top: 30px; /* Jarak lebih besar dari atas */
            left: 40px; /* Geser sedikit ke kanan */
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            border-radius: 20px; /* Sidebar tidak terlalu melengkung */
            overflow: hidden; /* Agar konten tidak keluar dari batas melengkung */
            display: flex;
            flex-direction: column; /* Mengatur sidebar dengan flexbox */
        }

        .sidebar h2 {
            font-size: 24px;
            text-align: center;
            color: #000; /* Hitam untuk "Yummy Yippie" */
            margin-bottom: 40px; /* Jarak lebih jauh ke item berikutnya */
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: #6e6e6e; /* Abu-abu muda untuk font */
            font-size: 16px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            margin: 8px 15px; /* Sedikit lebih banyak spasi antar item */
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 10px;
            color: #6e6e6e; /* Abu-abu muda untuk ikon */
        }

        .sidebar .nav-link.active {
            background-color: #f57c00; /* Warna oranye terang untuk menu aktif */
            color: white;
            font-weight: bold;
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        .sidebar .nav-link:hover {
            background-color: #ffd8b2; /* Krem terang saat hover */
            color: #000;
        }

        /* Logout Link (dipindahkan ke bawah) */
        .sidebar .logout-link {
            color: #f57c00; /* Oranye untuk logout */
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: auto; /* Pindahkan logout ke bagian bawah */
        }

        .sidebar .logout-link i {
            color: #f57c00; /* Oranye untuk ikon logout */
            margin-right: 10px;
        }

        .sidebar .logout-link:hover {
            background-color: #ffd8b2; /* Krem terang saat hover */
            color: #000;
        }

        /* Konten Utama */
        .main-content {
            margin-left: 300px; /* Memberi ruang untuk sidebar */
            padding: 20px;
            margin-top: 30px; /* Memberi ruang di atas konten */
            text-align: center; /* Teks di tengah */
        }

        .main-content h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 18px;
            color: #666;
        }

        /* Kotak di bawah tulisan 'Selamat Datang' yang lebih kecil */
        .content-box {
            margin-top: 0px;
            padding: 30px; /* Kurangi padding agar lebih kecil */
            border: 2px solid #ddd; /* Border abu-abu terang */
            border-radius: 20px; /* Kurangi sudut lengkung */
            background-color: #fff; /* Warna latar kotak */
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            width: 80%; /* Membuat kotak lebih kecil, sesuaikan dengan konten */
            margin-left: auto;
            margin-right: auto;
        }

        .content-box p {
            font-size: 16px;
            color: #555;
        }

        /* Kotak kecil kiri dan kanan */
        .side-box {
            display: inline-block;
            width: 30%; /* Lebar kotak kecil */
            padding: 20px;
            margin-top: 30px;
            margin: 40px;
            border: 2px solid #ddd;
            border-radius: 20px;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .side-box p {
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Yummy Yippie</h2>
        <a href="index.php" class="nav-link active">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="menu.php" class="nav-link">
            <i class="fas fa-utensils"></i> Daftar Menu
        </a>
        <a href="order.php" class="nav-link">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php" class="nav-link">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <!-- Tombol Logout dipindahkan ke bawah -->
        <a href="logout.php" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="content-box">
            <h1>Selamat Datang di Yummy Yippie yang gemas</h1>
            <p>Yay, akhirnya kamu di sini! 🌟Kami siap membantu kamu mengelola restoran dengan lebih seru dan efisien. Yuk, mulai petualangan kuliner kamu bersama Yummy Yippie!</p>
        </div>

        <!-- Kotak Kecil Kiri dan Kanan -->
        <div class="side-box">
            <h3></h3>
            <p>Admin super! 🚀 Pastikan restoran berjalan lancar dan semua pesanan terkontrol dengan sempurna. 🍔</p>
        </div>

        <div class="side-box">
            <h3></h3>
            <p>Siapkan diri untuk membuat restoran ini semakin berkilau! 🌟 Semua laporan, menu, dan transaksi ada di tanganmu!</p>
        </div>
    </div>
</body>
</html>
