<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $category = mysqli_query($koneksi, "DELETE FROM categories WHERE id = '$id'");

    $_SESSION['success'] = 'Delete category success';

    echo '<script>window.location.href="categories.php"</script>';
}
