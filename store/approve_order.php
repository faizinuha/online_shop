<?php
session_start();
require_once __DIR__ . '/../config/koneksi.php';

$user_id = $_SESSION['user_id'];

if (!isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>alert("You do not have permission to access this page."); window.location.href="index.php";</script>';
    exit();
}

if (isset($_GET['id'])) {
    $order_id = $_GET['id'];

    $order_query = mysqli_query($koneksi, "SELECT orders.*, products.user_id AS product_user_id
                                            FROM orders 
                                            JOIN products ON orders.product_id = products.id
                                            WHERE orders.id = $order_id");

    if (!$order_query || mysqli_num_rows($order_query) == 0) {
        echo '<script>alert("Invalid Order!"); window.location.href="orders.php";</script>';
        exit();
    }

    $order = mysqli_fetch_assoc($order_query);

    if ($order['product_user_id'] != $user_id) {
        echo '<script>alert("You do not have permission to access this page."); window.location.href="orders.php";</script>';
        exit();
    }

    $update = mysqli_query($koneksi, "UPDATE orders SET status = 'completed' WHERE id = '$order_id'");


    if ($update) {
        echo '<script>alert("Order approved successfully!"); window.location.href="orders.php";</script>';
    } else {
        echo '<script>alert("Failed to approve order. Please try again."); window.location.href="orders.php";</script>';
    }
} else {
    echo '<script>alert("Invalid order."); window.location.href="orders.php";</script>';
    exit();
}
