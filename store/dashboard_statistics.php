<?php 
$products = mysqli_query($koneksi, "SELECT COUNT(*) AS products_count FROM products");
$categories = mysqli_query($koneksi, "SELECT COUNT(*) AS categories_count FROM categories");
$customers = mysqli_query($koneksi, "SELECT COUNT(*) AS customer_count FROM users WHERE role = 'customer'");

$orders = mysqli_query($koneksi, "SELECT COUNT(*) AS order_count FROM orders");

$orders_sales = mysqli_query($koneksi, "SELECT COUNT(*) AS order_sales FROM orders WHERE status = 'completed'");
$total_sales = mysqli_query($koneksi, "SELECT SUM(total_price) AS total_sales FROM orders WHERE status = 'completed'");


$customer_count = mysqli_fetch_assoc($customers)['customer_count'];
$sales_count = mysqli_fetch_assoc($orders_sales)['order_sales'];
$total_price = mysqli_fetch_assoc($total_sales)['total_sales'];



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

