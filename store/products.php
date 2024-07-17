<?php
$title = 'Products';
require_once __DIR__ . '/layouts/main.php';

$user_id = $_SESSION['user_id'];

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$total_products = mysqli_query($koneksi, "SELECT COUNT(*) AS count FROM products");
$products_row = mysqli_fetch_assoc($total_products);
$products_count = $products_row['count'];
$total_pages = ceil($products_count / $limit);

$products = mysqli_query($koneksi, "SELECT products.*, categories.name AS category_name, 
            users.username AS user_name 
            FROM products 
            LEFT JOIN categories ON products.category_id = categories.id 
            JOIN users ON products.user_id = users.id
            ORDER BY products.created_at DESC
            LIMIT $limit OFFSET $offset");
?>



<section class="section">
    <div class="section-header">
        <h1>Products</h1>

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
        <div class="row">
            <?php
            foreach ($products as $product) :
            ?>
                <div class="col-12 col-md-4 col-lg-4">
                    <article class="article article-style-c">
                        <div class="article-header">
                            <img src="product-image/<?= $product['image'] ?>" alt="image" class="article-image img-fluid" style="object-fit: cover">
                        </div>
                        <div class="article-details">
                            <div class="article-category">
                                <div class="bullet"></div><a href="category.php?id=<?= $product['category_id'] ?>"><?= $product['category_name'] ?></a>
                                <div class="bullet"></div> <a href="">Stock : <?= $product['stock'] ?></a>
                            </div>

                            <div class="article-title">
                                <h2><a href="#" class="text-dark"><?= $product['name'] ?></a></h2>
                                <p>Rp. <?= Rp($product['price']) ?></p>
                            </div>

                            <p>By
                                <a href="profile.php?id=<?= $product['user_id'] ?>"><?= $product['user_name'] ?></a> in

                                <a href="category.php?id=<?= $product['category_id'] ?>"> <?= $product['category_name'] ?> </a>

                                <?= time_elapsed_string($product['created_at']) ?>
                            </p>

                            <p><?= $product['excerpt'] ?></p>
                            <div class="row ml-2" style="display: flex; gap: 13px">
                                <?php
                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $user_id == $product['user_id']) :
                                ?>
                                    <a class="btn btn-danger text-white" data-confirm="Realy?|Do you want to continue?" data-confirm-yes="window.location.href='destroy_product.php?id=<?= $product['id'] ?>'">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>

                                    <a href="category.php?id=<?= $product['category_id'] ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a>


                                <?php
                                endif;
                                ?>
                            </div>
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
        <div class="row d-flex justify-content-end">
            <nav aria-label="...">
                <ul class="pagination">
                    <?php if ($page > 1) : ?>
                        <li class="page-item">
                            <a class="page-link" href="products.php?page=<?= $page - 1 ?>">Previous</a>
                        </li>
                    <?php else : ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Previous</a>
                        </li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                        <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                            <a class="page-link" href="products.php?page=<?= $i ?>"><?= $i ?><?= $i === $page ? ' <span class="sr-only">(current)</span>' : '' ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages) : ?>
                        <li class="page-item">
                            <a class="page-link" href="products.php?page=<?= $page + 1 ?>">Next</a>
                        </li>
                    <?php else : ?>
                        <li class="page-item disabled">
                            <a class="page-link" href="#">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>

    </div>

</section>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>