<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Mengecek apakah ada id menu yang ingin diubah
if (isset($_GET['id'])) {
    $id_menu = $_GET['id'];

    // Query untuk mendapatkan data menu berdasarkan id
    $query = "SELECT * FROM tb_menu WHERE id = '$id_menu' LIMIT 1";
    $result = mysqli_query($koneksi, $query);

    // Jika data menu ditemukan
    if (mysqli_num_rows($result) > 0) {
        $menu = mysqli_fetch_assoc($result);
    } else {
        echo "Menu tidak ditemukan!";
        exit();
    }
} else {
    echo "ID menu tidak ada!";
    exit();
}

// Proses update menu
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $harga = $_POST['harga'];
    $deskripsi = $_POST['deskripsi'];

    // Query untuk update data menu
    $update_query = "UPDATE tb_menu SET nama_menu = '$nama_menu', harga = '$harga', deskripsi = '$deskripsi' WHERE id = '$id_menu'";
    $update_result = mysqli_query($koneksi, $update_query);

    if ($update_result) {
        header("Location: menu.php"); // Redirect ke halaman menu setelah berhasil update
        exit();
    } else {
        echo "Gagal mengupdate menu!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #FFF5EE;
            margin: 0;
            padding: 0;
        }
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
        .main-content {
            margin-left: 300px;
            padding: 20px;
            margin-top: 30px;
        }
        .container {
            width: 60%;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            padding: 10px 20px;
            background-color: #f57c00;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #e76c00;
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
    <a href="menu.php?page=menu" class="nav-link">
        <i class="fas fa-utensils"></i> Daftar Menu
    </a>
    <a href="order.php?page=order" class="nav-link">
        <i class="fas fa-receipt"></i> Order
    </a>
    <a href="transaksi.php?page=transaksi" class="nav-link">
        <i class="fas fa-exchange-alt"></i> Transaksi
    </a>
    <a href="logout.php" class="nav-link">
        <i class="fas fa-sign-out-alt"></i> Logout
    </a>
</div>

<!-- Konten Utama -->
<div class="main-content">
    <div class="container">
        <h2>Edit Menu</h2>
        <form method="POST" action="">
            <label for="nama_menu">Nama Menu</label>
            <input type="text" name="nama_menu" value="<?= $menu['nama_menu']; ?>" required>

            <label for="harga">Harga</label>
            <input type="number" name="harga" value="<?= $menu['harga']; ?>" required>

            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" rows="5" required><?= $menu['deskripsi']; ?></textarea>

            <button type="submit">Update Menu</button>
        </form>
    </div>
</div>

</body>
</html>

<?php
mysqli_close($koneksi); // Menutup koneksi setelah selesai
?>
