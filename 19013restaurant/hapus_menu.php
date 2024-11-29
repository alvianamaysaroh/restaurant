<?php
require "koneksi.php"; // Pastikan file koneksi.php dimasukkan di sini

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query = "DELETE FROM tb_menu WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: menu.php"); // Jika berhasil, redirect ke menu.php
    } else {
        echo "Error: " . mysqli_error($koneksi); // Menampilkan pesan error jika gagal
    }
} else {
    header("Location: menu.php"); // Jika id tidak ada, redirect ke menu.php
}
?>
