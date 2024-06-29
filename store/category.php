<?php
$title = 'Category';
require_once __DIR__ . '/layouts/main.php';

$user_id = $_SESSION['user_id'];

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

if (isset($_GET['id'])) {
    $category_id = intval($_GET['id']);
} else {
    $_SESSION['error'] = 'Category ID is missing.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

$category_query = mysqli_query($koneksi, "SELECT name FROM categories WHERE id = '$category_id'");
if (mysqli_num_rows($category_query) == 0) {
    $_SESSION['error'] = 'Category not found.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}
$category_name = mysqli_fetch_assoc($category_query)['name'];

$total_products_query = mysqli_query($koneksi, "SELECT COUNT(*) AS count FROM products WHERE category_id = '$category_id'");
$products_row = mysqli_fetch_assoc($total_products_query);
$products_count = $products_row['count'];
$total_pages = ceil($products_count / $limit);

$products_query = mysqli_query($koneksi, "SELECT products.*, users.username AS user_name 
                                          FROM products 
                                          JOIN users ON products.user_id = users.id
                                          WHERE products.category_id = '$category_id'
                                          ORDER BY products.created_at DESC
                                          LIMIT $limit OFFSET $offset");
?>


<section class="section">
    <div class="section-header">
        <h1>Products in Category: <?= htmlspecialchars($category_name) ?></h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="products.php">Products</a></div>
            <div class="breadcrumb-item"><?= htmlspecialchars($category_name) ?></div>
        </div>
    </div>

    <div class="section-body">
        <?php
        if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
        ?>
            <a href="create_product.php" class="btn btn-primary mb-3">Add Product</a>
        <?php endif; ?>

        <?php if (mysqli_num_rows($products_query) > 0) : ?>
            <div class="row">
                <?php while ($product = mysqli_fetch_assoc($products_query)) : ?>
                    <div class="col-12 col-md-4 col-lg-4">
                        <article class="article article-style-c">
                            <div class="article-header">
                                <img src="product-image/<?= htmlspecialchars($product['image']) ?>" alt="" class="article-image img-fluid" style="object-fit: cover">
                            </div>
                            <div class="article-details">
                                <div class="article-category">
                                    <div class="bullet"></div>
                                    <a href="category.php?id=<?= $product['category_id'] ?>">
                                        <?= htmlspecialchars($category_name) ?>
                                    </a>
                                    <div class="bullet"></div> <a href="">Stock: <?= htmlspecialchars($product['stock']) ?></a>
                                </div>

                                <div class="article-title">
                                    <h2><a href="#" class="text-dark"><?= htmlspecialchars($product['name']) ?></a></h2>
                                    <p>Rp. <?= Rp($product['price']) ?></p>
                                </div>
                                <p>By 
                                    <a href="profile.php?id=<?= $product['user_id'] ?>"><?= htmlspecialchars($product['user_name']) ?></a> in
                                    <a href="category.php?id=<?= $product['category_id'] ?>"> <?= htmlspecialchars($category_name) ?></a>
                                    <?= time_elapsed_string($product['created_at']) ?>
                                </p>

                                <p><?= htmlspecialchars($product['excerpt']) ?></p>
                                <div class="row ml-2" style="display: flex; gap: 13px">
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin' && $user_id == $product['user_id']) : ?>
                                        <a href="destroy_product.php?id=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Are You sure?')"><i class="fas fa-trash"></i></a>
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning"><i class="fas fa-pen"></i></a>
                                        <a href="" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                    <?php endif; ?>
                                </div>
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer' && $product['stock'] === 'available') : ?>
                                    <div class="row ml-1" style="display: flex; gap: 13px">
                                        <a href="order_product.php?id=<?= $product['id'] ?>" class="btn btn-primary ">
                                            <i class="fas fa-shopping-cart"></i> Order
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </article>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else : ?>
            <div class="row mt-5 text-center justify-content-center">
                <h2>No Products Found</h2>
            </div>
        <?php endif; ?>
    </div>

    <div class="row d-flex justify-content-end">
        <nav aria-label="...">
            <ul class="pagination">
                <?php if ($page > 1) : ?>
                    <li class="page-item">
                        <a class="page-link" href="category.php?id=<?= $category_id ?>&page=<?= $page - 1 ?>">Previous</a>
                    </li>
                <?php else : ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Previous</a>
                    </li>
                <?php endif; ?>
                <?php for ($i = 1; $i <= $total_pages; $i++) : ?>
                    <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                        <a class="page-link" href="category.php?id=<?= $category_id ?>&page=<?= $i ?>"><?= $i ?><?= $i === $page ? ' <span class="sr-only">(current)</span>' : '' ?></a>
                    </li>
                <?php endfor; ?>
                <?php if ($page < $total_pages) : ?>
                    <li class="page-item">
                        <a class="page-link" href="category.php?id=<?= $category_id ?>&page=<?= $page + 1 ?>">Next</a>
                    </li>
                <?php else : ?>
                    <li class="page-item disabled">
                        <a class="page-link" href="#">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</section>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
