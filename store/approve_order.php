<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="index.php";</script>';
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $order_query = mysqli_query($koneksi, "SELECT orders.*, products.user_id AS product_user_id
                                            FROM orders 
                                            JOIN products ON orders.product_id = products.id
                                            WHERE orders.id = $order_id");

    if (!$order_query || mysqli_num_rows($order_query) == 0) {
        $_SESSION['error'] = 'Invalid order.';
        echo '<script>window.location.href="orders.php";</script>';
        exit();
    }

    $order = mysqli_fetch_assoc($order_query);

    if ($order['product_user_id'] != $user_id) {
        $_SESSION['error'] = 'You do not have permission to access this page.';
        echo '<script>window.location.href="orders.php";</script>';
        exit();
    }

    $update = mysqli_query($koneksi, "UPDATE orders SET status = 'completed' WHERE id = '$order_id'");


    if ($update) {
        $_SESSION['success'] = 'Order approved successfully!';
        echo '<script>window.location.href="orders.php";</script>';
    } else {
        $_SESSION['error'] = 'Failed to approve order. Please try again.';
        echo '<script>window.location.href="orders.php";</script>';
    }
} else {
    $_SESSION['error'] = 'Invalid order.';
    echo '<script>window.location.href="orders.php";</script>';
    exit();
}
