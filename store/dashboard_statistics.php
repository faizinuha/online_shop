<?php 

$user_id = $_SESSION['user_id'];

$products = mysqli_query($koneksi, "SELECT COUNT(*) AS products_count FROM products");
$categories = mysqli_query($koneksi, "SELECT COUNT(*) AS categories_count FROM categories");
$customers = mysqli_query($koneksi, "SELECT COUNT(*) AS customer_count FROM users WHERE role = 'customer'");

$orders = mysqli_query($koneksi, "SELECT COUNT(*) AS order_count FROM orders
                            JOIN products ON orders.product_id = products.id
                            WHERE products.user_id = '$user_id'");

$orders_sales = mysqli_query($koneksi, "SELECT COUNT(*) AS order_sales FROM orders 
                            JOIN products ON orders.product_id = products.id
                            WHERE status = 'completed' AND products.user_id = '$user_id'");


$total_sales = mysqli_query($koneksi, "SELECT SUM(total_price) AS total_sales FROM orders
                            JOIN products ON orders.product_id = products.id 
                            WHERE status = 'completed' AND products.user_id = '$user_id'");



$customer_count = mysqli_fetch_assoc($customers)['customer_count'];
$sales_count = mysqli_fetch_assoc($orders_sales)['order_sales'];

$total_price = mysqli_fetch_assoc($total_sales)['total_sales'] ?? 0;

if ($products) {
    $product_count = mysqli_fetch_assoc($products)['products_count'];
} else {
    $product_count = 0;
}
if ($categories) {
    $categories_count = mysqli_fetch_assoc($categories)['categories_count'];
} else {
    $categories_count = 0;
}

if ($orders) {
    $order_count = mysqli_fetch_assoc($orders)['order_count'];
} else {
    $order_count = 0;
}

