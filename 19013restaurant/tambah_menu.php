<?php
require_once 'koneksi.php'; // Menghubungkan ke database

// Variabel untuk pesan notifikasi
$message = '';

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_menu = trim($_POST['nama_menu']);
    $harga = (int)$_POST['harga'];
    $deskripsi = trim($_POST['deskripsi']);

    // Validasi input
    if ($nama_menu && $harga > 0) {
        // Menghapus koma yang tidak perlu di query
        $query = "INSERT INTO tb_menu (nama_menu, harga, deskripsi) VALUES (?, ?, ?)";

        $stmt = $koneksi->prepare($query);

        if ($stmt) {
            // Sesuaikan jumlah parameter yang diikat dengan query yang benar
            $stmt->bind_param("sis", $nama_menu, $harga, $deskripsi);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                // Redirect ke halaman menu.php setelah berhasil menambahkan menu
                header("Location: menu.php");
                exit; // Pastikan tidak ada output lain setelah header
            } else {
                $message = 'Gagal menambahkan menu.';
            }
            $stmt->close();
        } else {
            $message = 'Kesalahan pada server.';
        }
    } else {
        $message = 'Nama menu dan harga harus diisi dengan benar!';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu</title>
    <!-- Link ke Bootstrap dan Font Awesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* CSS Sidebar */
        .sidebar {
            height: calc(100vh - 80px); /* Memberi jarak lebih besar di atas dan bawah */
            width: 260px; /* Sidebar lebih besar */
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

        /* Gaya Umum */
        body {
            background-color: #FFF5EE;
            font-family: 'Poppins', sans-serif;
            margin-left: 300px; /* Memberikan ruang untuk sidebar */
        }

        .container {
            margin-top: 50px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 70%;
        }

        h2 {
            font-weight: bold;
            color: #333;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #FFA500;
            border-color: #FFA500;
        }

        .btn-primary:hover {
            background-color: #FF8C00;
            border-color: #FF8C00;
        }

        .alert-info {
            background-color: #FFA500;
            color: white;
        }

        .form-control, select {
            border-radius: 5px;
            padding: 10px;
        }

        /* Menyembunyikan tabel pada halaman tambah menu */
        .table-container {
            display: none;
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
        <a href="menu.php" class="nav-link active">
            <i class="fas fa-utensils"></i> Daftar Menu
        </a>
        <a href="order.php" class="nav-link">
            <i class="fas fa-receipt"></i> Order
        </a>
        <a href="transaksi.php" class="nav-link">
            <i class="fas fa-exchange-alt"></i> Transaksi
        </a>
        <a href="logout.php" class="nav-link">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </div>

    <!-- Konten Utama -->
    <div class="container">
        <h2 class="text-center mb-4">Tambah Menu</h2>

        <?php if (!empty($message)): ?>
            <div class="alert alert-info text-center"><?= htmlspecialchars($message); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-3">
                <label for="nama_menu" class="form-label">Nama Menu</label>
                <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Contoh: Nasi Goreng" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Contoh: Nasi goreng dengan telur dan ayam"></textarea>
            </div>

            <div class="mb-3">
                <label for="harga" class="form-label">Harga</label>
                <input type="number" class="form-control" id="harga" name="harga" placeholder="Contoh: 20000" required>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary">TAMBAH MENU</button>
            </div>

            <div class="d-grid mt-2">
                <a href="menu.php" class="btn btn-secondary">Kembali ke Daftar Menu</a>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
