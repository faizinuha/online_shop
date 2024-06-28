<?php
$title = 'Category';
require_once __DIR__ . '/layouts/main.php';


$user_id = $_SESSION['user_id'];

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$category_id = $_GET['id'];
$category = mysqli_query($koneksi, "SELECT name FROM categories WHERE id = '$category_id'");
$category_name = mysqli_fetch_assoc($category)['name'];

$products = mysqli_query($koneksi, "SELECT products.*,
            users.username AS user_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id 
            JOIN users ON products.user_id = users.id
            ORDER BY products.created_at DESC
            LIMIT $limit OFFSET $offset");
?>


<section class="section">
    <div class="section-header">
        <h1>Products Category in <?= $category_name ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="products.php">Products</a></div>
        </div>
    </div>

    <div class="section-body">
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
        ?>
            <a href="create_product.php" class="btn btn-primary mb-3">Add Product</a>
        <?php

        endif;
        ?>
        <?php
        if (mysqli_num_rows($products) > 0) {
        ?>
            <div class="row">
                <?php
                foreach ($products as $product) :
                ?>
                    <div class="col-12 col-md-4 col-lg-4">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <img src="product-image/<?= $product['image'] ?>" alt="" class="article-image img-fluid" style="object-fit: cover">
                            </div>
                            <div class="article-details">
                                <div class="article-category">
                                    <div class="bullet"></div>
                                    <a href="category.php?id=<?= $product['category_id'] ?>">
                                        <?= $category_name ?>
                                    </a>
                                    <div class="bullet"></div> <a href="">Stock : <?= $product['stock'] ?></a>
                                </div>

                                <div class="article-title">
                                    <h2><a href="#" class="text-dark"><?= $product['name'] ?></a></h2>
                                    <p>Rp. <?= Rp($product['price']) ?></p>
                                </div>
                                <p>By 
                                    <a href="profile.php?id=<?= $user_id ?>"><?= $product['user_name'] ?></a> in
                                    <a href="category.php?id=<?= $product['category_id'] ?>"> <?= $category_name ?></a>
                                    <?= time_elapsed_string($product['created_at']) ?>
                                </p>

                                <p><?= $product['excerpt'] ?></p>
                                <?php
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
                                ?>
                                    <div class="row" style="display: flex; gap: 13px">
                                        <a href="destroy_product.php?id=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Are You sure?')"><i class="fas fa-trash"></i></a>
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                        <a href="" class="btn btn-primary "><i class="fas fa-eye"></i></a>
                                    </div>
                                <?php
                                endif;
                                ?>
                                <?php
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer' && $product['stock'] === 'available') :
                                ?>
                                    <div class="row ml-1" style="display: flex; gap: 13px">
                                        <a href="order_product.php?id=<?= $product['id'] ?>" class="btn btn-primary ">
                                            <i class="fas fa-shopping-cart"></i> Order
                                        </a>
                                    </div>
                                <?php
                                endif;
                                ?>
                            </div>

                        </article>
                    </div>
                <?php
                endforeach;
                ?>
            </div>
        <?php
        } else {
        ?>
            <div class="row mt-5 text-center justify-content-center">
                <h2>No Products Found</h2>
            </div>
        <?php
        }
        ?>
    </div>

</section>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>