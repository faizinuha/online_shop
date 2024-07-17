<?php 
session_start();
require_once __DIR__ . '../../config/koneksi.php';

$redirect_page = $_SESSION['role'] == 'admin' ? 'orders.php' : 'my_orders.php';

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    mysqli_begin_transaction($koneksi);

    try {
        // Hapus dari tabel 'orders' berdasarkan 'order_id'
        $query1 = mysqli_query($koneksi, "DELETE FROM orders WHERE id = '$order_id'");

        if (!$query1) {
            throw new Exception('Gagal menghapus pesanan.');
        }

        // Jika ada referensi ke 'order_details', hapus juga di sini jika diperlukan
        // jika ada order_details tambahkan jika ada
        // Contoh: mysqli_query($koneksi, "DELETE FROM order_details WHERE order_id = '$order_id'");

        mysqli_commit($koneksi);

        $_SESSION['success'] = 'Order berhasil dihapus.';
        echo "<script>window.location.href='$redirect_page'</script>";
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        $_SESSION['error'] = $e->getMessage();
        echo "<script>window.location.href='$redirect_page'</script>";
    }
} else {
    $_SESSION['error'] = 'Order tidak ditemukan.';
    echo "<script>window.location.href='$redirect_page'</script>";
}
?>
