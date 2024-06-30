<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    $customer = mysqli_query($koneksi, "SELECT * FROM orders WHERE user_id = '$customer_id'");

    if (mysqli_num_rows($customer) > 0) {
        $_SESSION['error'] = 'Gagal menghapus customer, karena terkait dengan order.';
        echo '<script>window.location.href="customers.php"</script>';
        exit();
    }

    $delete_customer = mysqli_query($koneksi, "DELETE FROM users WHERE id = '$customer_id'");

    if ($delete_customer) {
        $_SESSION['success'] = 'Delete Customer success!';
    } else {
        $_SESSION['error'] = 'Failed to Delete Customer. Please try again';
    }
    echo '<script>window.location.href="customers.php"</script>';
    exit();


} else {
    $_SESSION['error'] = 'Customer not found';

    echo '<script>window.location.href="customers.php"</script>';
}
