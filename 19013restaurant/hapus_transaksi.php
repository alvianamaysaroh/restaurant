<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Hapus detail transaksi
    $delete_detail_query = "DELETE FROM tb_transaksi_detail WHERE transaksi_id = $id";
    mysqli_query($koneksi, $delete_detail_query);

    // Hapus transaksi
    $delete_query = "DELETE FROM tb_transaksi WHERE id = $id";
    if (mysqli_query($koneksi, $delete_query)) {
        header('Location: transaksi.php'); // Redirect ke halaman transaksi setelah berhasil
    } else {
        echo "Gagal menghapus transaksi: " . mysqli_error($koneksi);
    }
}
?>
