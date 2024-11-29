<?php
session_start();
include 'koneksi.php'; // Menyambungkan ke database

// Query untuk mengambil semua data dari tabel menu
$query = "SELECT * FROM tb_menu";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Menu</title>
    <!-- Link ke Google Fonts untuk font modern -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <!-- Link ke Font Awesome untuk ikon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Tambahkan CSS Sidebar */
        .sidebar {
            height: calc(100vh - 80px);
            width: 260px;
            background-color: #fff;
            position: fixed;
            top: 30px;
            left: 40px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            padding-top: 20px;
            border-radius: 20px;
            display: flex;
            flex-direction: column;
        }

        .sidebar h2 {
            font-size: 24px;
            text-align: center;
            color: #000;
            margin-bottom: 40px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .sidebar .nav-link {
            color: #6e6e6e;
            font-size: 16px;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            transition: all 0.3s ease;
            text-decoration: none;
            margin: 8px 15px;
        }

        .sidebar .nav-link i {
            font-size: 18px;
            margin-right: 10px;
            color: #6e6e6e;
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

        /* Logout link */
        .sidebar .logout-link {
            margin-top: auto; /* Menempatkan Logout di bagian bawah */
            margin-bottom: 10px; /* Memberi jarak dari bawah */
            margin-left: 15px;
            margin-right: 15px;
            color: #f57c00; /* Warna teks oranye */
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            display: flex;
            align-items: center;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .sidebar .logout-link i {
            color: #f57c00; /* Warna ikon oranye */
            margin-right: 10px;
        }

        .sidebar .logout-link:hover {
            background-color: #ffd8b2; /* Warna latar saat hover */
            color: #000;
        }

        .main-content {
            margin-left: 300px;
            padding: 20px;
            margin-top: 30px;
        }

        /* Tambahkan CSS untuk tabel */
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF5EE; /* Ganti warna latar belakang */
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            margin: 10px auto;
            border-collapse: collapse;
            background-color: #fff;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f57c00;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }

        /* Menata harga agar lebih rapi */
        td .harga {
            font-weight: bold;
            color: #f57c00;
            font-size: 16px;
            padding: 5px 10px;
            background-color: #fff2e1;
            border-radius: 5px;
            text-align: center;
            box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1);
            display: inline-block;
            min-width: 100px;
        }

        /* Mengatur agar tombol Edit dan Hapus berjejer */
        td .action-btn {
            display: inline-block;
            margin-right: 10px; /* Memberi jarak antar tombol */
            text-align: center;
        }

        /* Menambahkan padding dan border radius untuk tombol */
        .action-btn {
            color: #f57c00;
            text-decoration: none;
            font-size: 14px;
            padding: 5px 15px; /* Memperbesar padding tombol */
            border-radius: 5px;
            background-color: #fff;
            border: 1px solid #f57c00;
            transition: background-color 0.3s ease;
        }

        /* Menambahkan efek hover untuk tombol */
        .action-btn:hover {
            background-color: #f57c00;
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Yummy Yippie</h2>
        <a href="index.php?page=beranda" class="nav-link">
            <i class="fas fa-home"></i> Beranda
        </a>
        <a href="menu.php?page=menu" class="nav-link active">
            <i class="fas fa-utensils"></i> Daftar Menu
        </a>
        <a href="order.php?page=order" class="nav-link">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php?page=transaksi" class="nav-link">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <a href="logout.php" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <h1 style="text-align: center; margin-top: 30px;">Daftar Menu Restoran</h1>
        <div style="text-align: center; margin-bottom: 20px;">
            <a href="tambah_menu.php" class="action-btn">Tambah Menu</a>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Opsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                // Perulangan untuk menampilkan data menu
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $no++ . "</td>";
                    echo "<td>" . $row['nama_menu'] . "</td>";
                    echo "<td><span class='harga'>Rp " . number_format($row['harga'], 2, ',', '.') . "</span></td>";
                    echo "<td>" . $row['deskripsi'] . "</td>";
                    echo "<td>
                              <div style='display: flex; gap: 10px;'>
                                  <a href='edit_menu.php?id=" . $row['id'] . "' class='action-btn'>Edit</a>
                                  <a href='hapus_menu.php?id=" . $row['id'] . "' class='action-btn'>Hapus</a>
                              </div>
                          </td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php
mysqli_close($koneksi); // Menutup koneksi setelah query selesai
?>
