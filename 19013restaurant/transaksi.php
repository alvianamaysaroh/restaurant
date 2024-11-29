<?php
include 'koneksi.php';

// Ambil data menu dari database untuk dropdown
$query_menu = "SELECT * FROM tb_menu";
$result_menu = mysqli_query($koneksi, $query_menu);

// Ambil data transaksi
$query_transaksi = "
    SELECT 
        t.id, t.nama_pelanggan, t.tanggal, t.total_pembayaran,
        m.nama_menu, td.jumlah
    FROM tb_transaksi t
    JOIN tb_transaksi_detail td ON t.id = td.transaksi_id
    JOIN tb_menu m ON td.menu_id = m.id
    ORDER BY t.id DESC";
$result_transaksi = mysqli_query($koneksi, $query_transaksi);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF5EE;
            margin: 0;
            padding: 0;
        }
        
        /* Sidebar */
        .sidebar {
            height: calc(100vh - 80px); /* Sidebar menutupi seluruh tinggi layar */
            width: 260px; /* Lebar sidebar */
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

        .sidebar .logout-link {
            color: #f57c00;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            margin-top: auto;
        }

        .sidebar .logout-link i {
            color: #f57c00;
            margin-right: 10px;
        }

        .sidebar .logout-link:hover {
            background-color: #ffd8b2;
            color: #000;
        }

        /* Konten Utama */
        .main-content {
            margin-left: 300px;
            padding: 20px;
            margin-top: 30px;
            text-align: center;
        }

        /* Kotak untuk form dan tabel */
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
        }
        
        h1, h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #f57c00;
        }

        .form-container, .table-container {
            margin-bottom: 30px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        input, select, button {
            width: 100%;
            padding: 14px;
            margin-top: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #f57c00;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #ff9500;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background-color: #f57c00;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        /* Menambahkan styling untuk tombol Edit dan Hapus */
        .btn-edit, .btn-hapus {
            padding: 8px 16px;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            display: inline-block;
            font-weight: bold;
            text-align: center;
            margin: 5px;
        }

        .btn-edit {
            background-color: #ff8c00;
        }

        .btn-edit:hover {
            background-color: #ff6a00;
        }

        .btn-hapus {
            background-color: #ff5722;
        }

        .btn-hapus:hover {
            background-color: #e64a19;
        }

        .table-container {
            overflow-x: auto;
        }

        /* Responsif untuk perangkat kecil */
        @media screen and (max-width: 768px) {
            .container {
                padding: 15px;
            }
            h1, h2 {
                font-size: 24px;
            }
            input, select, button {
                font-size: 14px;
                padding: 12px;
            }
            table th, table td {
                font-size: 14px;
                padding: 10px;
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
        <a href="order.php" class="nav-link">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php" class="nav-link active">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <a href="logout.php" class="nav-link logout-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Konten Utama -->
    <div class="main-content">
        <div class="container">
            <h1>Tambah Transaksi</h1>
            <div class="form-container">
                <form method="POST" action="proses_transaksi.php">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>

                    <label for="tanggal">Tanggal</label>
                    <input type="date" id="tanggal" name="tanggal" required>

                    <label for="menu_id">Menu</label>
                    <select id="menu_id" name="menu_id" required>
                        <option value="">Pilih Menu</option>
                        <?php while ($menu = mysqli_fetch_assoc($result_menu)): ?>
                            <option value="<?php echo $menu['id']; ?>">
                                <?php echo $menu['nama_menu']; ?> - Rp <?php echo number_format($menu['harga'], 2, ',', '.'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>

                    <label for="jumlah">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" required>

                    <button type="submit">Tambah Transaksi</button>
                </form>
            </div>

            <div class="table-container">
                <h2>Data Transaksi</h2>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Total Pembayaran</th>
                            <th>Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        while ($row = mysqli_fetch_assoc($result_transaksi)):
                        ?>
                        <tr>
                            <td><?php echo $no++; ?></td>
                            <td><?php echo $row['nama_pelanggan']; ?></td>
                            <td><?php echo $row['tanggal']; ?></td>
                            <td><?php echo $row['nama_menu']; ?></td>
                            <td><?php echo $row['jumlah']; ?></td>
                            <td>Rp <?php echo number_format($row['total_pembayaran'], 2, ',', '.'); ?></td>
                            <td>
                                <a href="edit_transaksi.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                                <a href="hapus_transaksi.php?id=<?php echo $row['id']; ?>" class="btn-hapus" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
