<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];

    $product = mysqli_query($koneksi, "SELECT * FROM products WHERE category_id = '$category_id'");

    if (mysqli_num_rows($product) > 0) {
        $_SESSION['error'] = 'Gagal menghapus Category karena terkait dengan Product.';
        echo '<script>window.location.href="categories.php"</script>';
        exit();
    }

    $delete_category = mysqli_query($koneksi, "DELETE FROM categories WHERE id = '$category_id'");

    if ($delete_category) {
        $_SESSION['success'] = 'Delete category success';
    } else {
        $_SESSION['error'] = 'Failed to delete category. Please try again';
    }
    echo '<script>window.location.href="categories.php"</script>';
    exit();
} else {
    $_SESSION['error'] = 'ID Category not found';
    echo '<script>window.location.href="categories.php"</script>';
    exit();
}
