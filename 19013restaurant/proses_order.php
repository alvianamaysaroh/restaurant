<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

if (isset($_POST['order'])) {
    // Ambil data dari form
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $menu_id = $_POST['menu'];
    $jumlah = $_POST['jumlah'];
    $tanggal_pesanan = $_POST['tanggal_pesanan'];

    // Query untuk memasukkan data ke dalam tabel pesanan
    $query = "INSERT INTO tb_order (nama_pelanggan, menu_id, jumlah, tanggal_pesanan) 
              VALUES ('$nama_pelanggan', '$menu_id', '$jumlah', '$tanggal_pesanan')";

    if (mysqli_query($koneksi, $query)) {
        // Redirect ke halaman sukses
        header('Location: order_success.php'); 
        exit();
    } else {
        // Jika gagal, tampilkan error
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>
