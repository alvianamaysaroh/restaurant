<?php
session_start();
include 'koneksi.php'; // Sambungkan ke database

// Ambil data menu untuk dropdown
$query_menu = "SELECT * FROM tb_menu";
$result_menu = mysqli_query($koneksi, $query_menu);

// Proses form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $menu_id = mysqli_real_escape_string($koneksi, $_POST['menu_id']);
    $jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);

    // Validasi data
    if (empty($menu_id)) {
        echo "Menu tidak dipilih. Silakan pilih menu dari dropdown.";
        exit;
    }

    // Ambil harga menu
    $query_harga = "SELECT harga FROM tb_menu WHERE id = $menu_id";
    $result_harga = mysqli_query($koneksi, $query_harga);
    if (mysqli_num_rows($result_harga) > 0) {
        $harga = mysqli_fetch_assoc($result_harga)['harga'];
    } else {
        echo "Menu tidak ditemukan. Silakan pilih menu yang valid.";
        exit;
    }

    // Hitung total pembayaran
    $total_pembayaran = $harga * $jumlah;

    // Simpan data transaksi
    $query_transaksi = "INSERT INTO tb_transaksi (nama_pelanggan, tanggal, total_pembayaran) 
                        VALUES ('$nama_pelanggan', '$tanggal', '$total_pembayaran')";
    mysqli_query($koneksi, $query_transaksi);
    $transaksi_id = mysqli_insert_id($koneksi);

    // Simpan detail transaksi
    $query_detail = "INSERT INTO tb_transaksi_detail (transaksi_id, menu_id, jumlah) 
                     VALUES ('$transaksi_id', '$menu_id', '$jumlah')";
    mysqli_query($koneksi, $query_detail);

    // Redirect ke halaman transaksi
    header('Location: transaksi.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f9f9f9; padding: 0; margin: 0; }
        .container { width: 60%; margin: 50px auto; background: #fff; padding: 20px; border-radius: 8px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; font-weight: bold; margin-bottom: 5px; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { background: #28a745; color: #fff; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #218838; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Tambah Transaksi</h1>
        <form method="POST" action="tambah_transaksi.php">
            <div class="form-group">
                <label for="nama_pelanggan">Nama Pelanggan</label>
                <input type="text" id="nama_pelanggan" name="nama_pelanggan" required>
            </div>
            <div class="form-group">
                <label for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" name="tanggal" required>
            </div>
            <div class="form-group">
                <label for="menu_id">Pilih Menu</label>
                <select id="menu_id" name="menu_id" required>
                    <option value="">-- Pilih Menu --</option>
                    <?php while ($menu = mysqli_fetch_assoc($result_menu)) { ?>
                        <option value="<?= $menu['id']; ?>"><?= $menu['nama_menu']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" required>
            </div>
            <button type="submit">Tambah Transaksi</button>
        </form>
    </div>
</body>
</html>
