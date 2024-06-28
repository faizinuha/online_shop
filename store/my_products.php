<?php
$title = "My Products";
require_once __DIR__ . '/layouts/main.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    $products = mysqli_query($koneksi, "SELECT products .*, categories.name AS category_name
     FROM products 
     LEFT JOIN categories ON products.category_id = categories.id 
     WHERE products.user_id = '$user_id' ORDER BY products.created_at DESC");
}

?>

<section class="section">
    <div class="section-header">
        <h1>My Products</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">My Products</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="create_product.php" class="btn btn-primary">Add Product</a>

                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Product Name</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Stock</th>
                                        <th>Action</th>
                                      </tr>
                                </thead>

                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($product = mysqli_fetch_assoc($products)) {
                                    ?>
                                        <tr>
                                            <td width="5%"><?= $i ?></td>
                                            <td><?= $product['name'] ?></td>
                                            <td><?= $product['category_name'] ?></td>
                                            <td>Rp. <?= Rp($product['price']) ?></td>
                                            <td>
                                                <?php if ($product['stock'] === 'available') : ?>
                                                    <div class="badge badge-success">Available</div>
                                                <?php elseif ($product['stock'] === 'out of stock') : ?>
                                                    <div class="badge badge-danger">Out of Stock</div>
                                                <?php endif; ?>
                                            </td>
                                            <td width="20%">
                                                <div class="row justify-content-center" style="display: flex; gap: 12px">
                                                    <a href="category.php?id=<?= $product['category_id'] ?>" class="btn btn-primary">
                                                        <i class="fas fa-fw fa-eye"></i>
                                                    </a>
                                                    <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-warning">
                                                        <i class="fas fa-fw fa-pen"></i>
                                                    </a>
                                                    <a href="destroy_product.php?id=<?= $product['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-fw fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>