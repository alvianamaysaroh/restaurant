<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Ambil data transaksi berdasarkan ID
    $query = "SELECT t.id, t.nama_pelanggan, t.tanggal, td.menu_id, td.jumlah
              FROM tb_transaksi t
              JOIN tb_transaksi_detail td ON t.id = td.transaksi_id
              WHERE t.id = $id";
    $result = mysqli_query($koneksi, $query);
    $transaksi = mysqli_fetch_assoc($result);

    // Ambil data menu untuk dropdown
    $query_menu = "SELECT * FROM tb_menu";
    $result_menu = mysqli_query($koneksi, $query_menu);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $tanggal = $_POST['tanggal'];
    $menu_id = $_POST['menu_id'];
    $jumlah = $_POST['jumlah'];

    // Update transaksi
    $update_query = "UPDATE tb_transaksi t
                     JOIN tb_transaksi_detail td ON t.id = td.transaksi_id
                     SET t.nama_pelanggan = '$nama_pelanggan', t.tanggal = '$tanggal', td.menu_id = $menu_id, td.jumlah = $jumlah
                     WHERE t.id = $id";

    if (mysqli_query($koneksi, $update_query)) {
        header('Location: transaksi.php'); // Redirect ke halaman transaksi setelah berhasil
    } else {
        echo "Gagal memperbarui transaksi: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Gaya Umum */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #FFF5EE;
        }

        /* Sidebar */
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
            overflow: hidden;
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
        }

        .sidebar .nav-link.active {
            background-color: #f57c00;
            color: white;
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

        .main-content h1 {
            font-size: 32px;
            color: #333;
            margin-bottom: 20px;
        }

        .main-content p {
            font-size: 18px;
            color: #666;
        }

        .container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
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
            <h1>Edit Transaksi</h1>
            <form method="POST" action="">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" value="<?php echo $transaksi['nama_pelanggan']; ?>" required>
                
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" value="<?php echo $transaksi['tanggal']; ?>" required>
                
                <label for="menu_id">Menu</label>
                <select id="menu_id" name="menu_id" required>
                    <?php while ($menu = mysqli_fetch_assoc($result_menu)): ?>
                        <option value="<?php echo $menu['id']; ?>" <?php if ($menu['id'] == $transaksi['menu_id']) echo 'selected'; ?>>
                            <?php echo $menu['nama_menu']; ?> - Rp <?php echo number_format($menu['harga'], 2, ',', '.'); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label for="jumlah">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" value="<?php echo $transaksi['jumlah']; ?>" required>
                
                <button type="submit">Update Transaksi</button>
            </form>
        </div>
    </div>
</body>
</html>
