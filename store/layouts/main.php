<?php
session_start();
require_once __DIR__ . '/../../config/koneksi.php';
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

if (isset($_SESSION['success'])) {
    $success_message = $_SESSION['success'];
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']);
}

include('../function/function.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title><?= $title ?></title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
    <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="assets/modules/izitoast/css/iziToast.min.css">

    <link rel="stylesheet" href="assets/modules/datatables/datatables.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css">

    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/components.css">
    <!-- Start GA -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-94034622-3');
    </script>
    <!-- /END GA -->
</head>

<body>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
                        <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
                        <button class="btn" type="button"><i class="fas fa-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="far fa-envelope"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right">
                            <div class="dropdown-header">Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, <?= $_SESSION['username'] ?></div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-title">Logged since <?= time_elapsed_string($_SESSION['login_date']) ?></div>
                            <a href="profile.php?id=<?= $_SESSION['user_id'] ?>" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') : ?>
                                <a href="my_products.php" class="dropdown-item has-icon">
                                    <i class="fas fa-shopping-bag"></i> My Products
                                </a>
                            <?php endif; ?>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item has-icon text-danger" data-confirm="Realy?|Do you want to continue?" data-confirm-yes="window.location.href='../auth/logout.php'"><i class="fas fa-sign-out-alt"></i> Logout</a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="./index.php">Online Shop</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="./index.php">Os</a>
                    </div>
                    <ul class="sidebar-menu">
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
                        ?>
                            <li class="menu-header">Dashboard</li>
                            <li class="nav-item <?= $title == 'Dashboard' ? 'active' : '' ?>">
                                <a href="./index.php" class="nav-link"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                            </li>
                        <?php
                        endif;
                        ?>
                        <li class="menu-header">Starter</li>
                        <li class="nav-item <?= $title == 'Products' ? 'active' : '' ?>">
                            <a href="./products.php" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Products</span></a>
                        </li>
                        <li class="nav-item <?= $title == 'Categories' ? 'active' : '' ?>">
                            <a href="./categories.php" class="nav-link"><i class="fas fa-list"></i><span>Categories</span></a>
                        </li>
                        <?php
                        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
                        ?>
                            <li class="nav-item <?= $title == 'Customers' ? 'active' : '' ?>">
                                <a href="./customers.php    " class="nav-link">
                                    <i class="fas fa-users"></i>
                                    <span>Customers</span>
                                </a>
                            </li>

                            <li class="nav-item <?= $title == 'Orders' ? 'active' : '' ?>">
                                <a href="./orders.php" class="nav-link">
                                    <i class="fas fa-archive"></i>
                                    <span>Manage Orders</span>
                                </a>
                            </li>

                        <?php
                        endif;
                        ?>
                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'):  ?>
                        <li class="nav-item <?= $title == 'My Orders' ? 'active' : '' ?>">
                            <a href="./my_orders.php" class="nav-link">
                                <i class="fas fa-archive"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>

                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">

                <div class="row justify-content-end">
                    <div class="col-4 position-absolute" style="z-index: 9999;">
                        <?php if (!empty($success_message)) : ?>
                            <div class="alert alert-success alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <?= $success_message ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($error_message)) : ?>
                            <div class="alert alert-danger alert-dismissible show fade">
                                <div class="alert-body">
                                    <button class="close" data-dismiss="alert">
                                        <span>&times;</span>
                                    </button>
                                    <?= $error_message ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>