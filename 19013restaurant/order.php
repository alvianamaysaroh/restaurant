<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'kasir')) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Order</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Gaya umum */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF5EE;
            box-sizing: border-box;
        }

        * {
            box-sizing: border-box;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 30px;
            left: 40px;
            width: 260px;
            height: calc(100vh - 60px); /* Mengurangi margin agar lebih ke bawah */
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            font-size: 24px;
            text-align: center;
            color: #000;
            font-weight: bold;
            margin-bottom: 40px;
        }

        .sidebar .nav-link {
            font-size: 16px;
            color: #6e6e6e;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            margin: 8px 15px;
            display: flex;
            align-items: center;
            transition: 0.3s;
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 10px;
        }

        .sidebar .nav-link.active {
            background-color: #f57c00;
            color: white;
            font-weight: bold;
        }

        .sidebar .nav-link.active i {
            color: white;
        }

        .sidebar .nav-link:hover {
            background-color: #ffd8b2;
            color: #000;
        }

        /* Tombol logout lebih ke bawah tapi tidak terlalu jauh */
        .sidebar .logout-link {
            margin-top: auto;
            margin-bottom: 20px; /* Memberikan sedikit jarak sebelum logout */
            margin-left: 15px;
            margin-right: 15px;
            color: #f57c00;
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
        }

        .sidebar .logout-link i {
            color: #f57c00;
            margin-right: 10px;
        }

        .sidebar .logout-link:hover {
            background-color: #ffd8b2;
            color: #000;
        }

        /* Main content */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            margin-top: 30px;
        }

        /* Untuk menata halaman agar "Halaman Order" ada di tengah */
        .main-content h1 {
            font-size: 32px;
            color: #333;
            text-align: center; /* Teks berada di tengah */
            margin-bottom: 20px;
        }

        /* Responsif untuk form */
        .main-content form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
        }

        /* Responsif input fields */
        .main-content input[type="text"], 
        .main-content input[type="number"], 
        .main-content input[type="date"], 
        .main-content select {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 2px solid #FF6600;
            border-radius: 8px;
            box-sizing: border-box; /* Pastikan box sizing diset */
        }

        .main-content label {
            font-size: 18px;
            color: #FF6600;
            display: block;
            margin-bottom: 10px;
        }

        .main-content button {
            background-color: #FF6600;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 18px;
            width: 100%;
        }

        .main-content button:hover {
            background-color: #FF4500;
        }

        /* Menambahkan responsif untuk tampilan kecil */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                border-radius: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 10px;
            }

            .sidebar .nav-link {
                font-size: 14px;
                padding: 10px 15px;
            }

            .main-content form {
                max-width: 100%;
            }

            .sidebar .logout-link {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Yummy Yippie</h2>
        <a href="index.php" class="nav-link">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="menu.php" class="nav-link">
            <i class="fas fa-utensils"></i> Daftar Menu
        </a>
        <a href="order.php" class="nav-link active">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php" class="nav-link">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <a href="logout.php" class="logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Main content -->
    <div class="main-content">
        <h1>Halaman Order</h1>
        <form method="POST" action="proses_order.php">
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" required>

            <label for="menu">Pilih Menu:</label>
            <select name="menu" id="menu" required>
                <?php
                $query = "SELECT * FROM tb_menu";
                $result = mysqli_query($koneksi, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='" . $row['id_menu'] . "'>" . $row['nama_menu'] . "</option>";
                    }
                } else {
                    echo "<option value=''>Menu tidak tersedia</option>";
                }
                ?>
            </select>

            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" id="jumlah" min="1" required>

            <label for="tanggal_pesanan">Tanggal Pesanan:</label>
            <input type="date" name="tanggal_pesanan" id="tanggal_pesanan" required>

            <button type="submit" name="order">Pesan</button>
        </form>
    </div>
</body>
</html>
