<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_pelanggan = mysqli_real_escape_string($koneksi, $_POST['nama_pelanggan']);
    $tanggal = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $menu_id = mysqli_real_escape_string($koneksi, $_POST['menu_id']);
    $jumlah = mysqli_real_escape_string($koneksi, $_POST['jumlah']);

    if ($menu_id == "") {
        $error_message = "Menu tidak dipilih. Silakan pilih menu.";
    } else {
        $query_harga = "SELECT harga FROM tb_menu WHERE id = $menu_id";
        $result_harga = mysqli_query($koneksi, $query_harga);
        $harga = mysqli_fetch_assoc($result_harga)['harga'];

        $total_pembayaran = $harga * $jumlah;

        // Simpan transaksi utama
        $query_transaksi = "INSERT INTO tb_transaksi (nama_pelanggan, tanggal, total_pembayaran) VALUES ('$nama_pelanggan', '$tanggal', '$total_pembayaran')";
        mysqli_query($koneksi, $query_transaksi);

        $transaksi_id = mysqli_insert_id($koneksi);

        // Simpan detail transaksi
        $query_transaksi_detail = "INSERT INTO tb_transaksi_detail (transaksi_id, menu_id, jumlah) VALUES ('$transaksi_id', '$menu_id', '$jumlah')";
        mysqli_query($koneksi, $query_transaksi_detail);

        header("Location: transaksi.php");
        exit;
    }
}
?>
