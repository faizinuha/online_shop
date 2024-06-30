<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_GET['id'])) {
    $product_id  = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$product_id'");

    $product = mysqli_fetch_array($query);

    $oldImage = $product['image'];

    $orders = mysqli_query($koneksi, "SELECT * FROM orders WHERE product_id = '$product_id'");

    if (mysqli_num_rows($orders) > 0) {
            $_SESSION['error'] = 'Gagal menghapus product ini karena terkait dengan pesanan.';
            echo '<script>window.location.href="products.php"</script>';
            exit();
    }
    
    $order_details = mysqli_query($koneksi, "SELECT * FROM order_details WHERE product_id = '$product_id'");
    
    if (mysqli_num_rows($order_details) > 0) {
        $_SESSION['error'] = 'Gagal menghapus product ini karena terkait dengan rincian pesanan.';
        echo '<script>window.location.href="products.php"</script>';
        exit();
    }
    
    $delete_product = mysqli_query($koneksi, "DELETE FROM products WHERE id = '$product_id'");
    
    if ($oldImage) {
        unlink('product-image/' . $oldImage);
    }
    if ($delete_product) {
        $_SESSION['success'] = 'Delete Product success!'; 
    } else {
        $_SESSION['error'] = 'Failed to delete product. Please try again';
    }
    
    echo '<script>window.location.href="products.php"</script>';
    exit();
} else {
    $_SESSION['error'] = 'ID Product tidak Di temukan';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}
