<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_GET['id'])) {
    $id  = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$id'");

    $product = mysqli_fetch_array($query);

    $oldImage = $product['image'];

    if ($oldImage) {
        unlink('product-image/' . $oldImage);
    }

    mysqli_query($koneksi, "DELETE FROM products WHERE id = '$id'");

    $_SESSION['success'] = 'Delete Product success!';
    echo '<script>window.location.href="products.php"</script>';
}
