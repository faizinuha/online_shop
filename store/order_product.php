<?php
$title = 'Orders';
require_once __DIR__ . '/layouts/main.php';


$user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$product_id'");
    $product = mysqli_fetch_assoc($query);


    if (!$query) {
        $_SESSION['error'] = 'Product not found.';
        echo '<script>window.location.href="products.php"</script>';
        exit();
    }
} else {
    $_SESSION['error'] = 'Invalid product.';
    echo '<script>window.location.href="products.php"</script>';
}

if (isset($_POST['submit'])) {
    $quantity = intval($_POST['quantity']);
    $total_price = $quantity * floatval($product['price']);

    if ($quantity <= 0) {
        $_SESSION['error'] = 'Invalid order.';
        echo '<script>window.location.href="order_product.php?id='. $product_id .'"</script>';
        exit();
    }

    if ($total_price > 99999999.99) {
        $_SESSION['error'] = 'Total order melebihi batas.';
        echo '<script>window.location.href="order_product.php?id='. $product_id .'"</script>';
        exit();
    }

    $query = mysqli_query($koneksi, "INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES ('$user_id', '$product_id', '$quantity', '$total_price') ");

    if ($query) {
        $order_id = mysqli_insert_id($koneksi);

        $order_detail = mysqli_query($koneksi, "INSERT INTO order_details (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity') ");

        if ($order_detail) {
            $_SESSION['success'] = 'Order placed successfully!';
            echo '<script>window.location.href="products.php"</script>';
            exit();
        } else {    
            $_SESSION['error'] = 'Failed to place order. Please try again.';
            echo '<script>window.location.href="order_product.php?id=' . $product_id . '"</script>';
            exit();
        }
    } else {
        $_SESSION['error'] = 'Failed to place order. Please try again.';
        echo '<script>window.location.href="order_product.php?id=' . $product_id . '"</script>';
        exit();
    }
}

?>


<section class="section">
    <div class="section-header">
        <h1>Order Product</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Order Product</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-sm-12 col-lg-7">
                <div class="card author-box card-primary">
                    <div class="card-body">
                        <div class="author-box-left">
                            <img alt="image" src="product-image/<?= $product['image'] ?>" class=" author-box-picture">
                            <div class="clearfix"></div>
                            <div class="badge <?= $product['stock'] === 'available' ? 'badge-success' : 'badge-danger' ?> mt-3"><?= $product['stock'] ?></div>
                        </div>
                        <div class="author-box-details">
                            <div class="author-box-name">
                                <a href="#"><?= $product['name'] ?></a>
                            </div>
                            <div class="author-box-job"><?= Rp($product['price']) ?></div>
                            <div class="author-box-description">
                                <p><?= $product['body'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-5">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3>Order</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="quantity" class="form-label">Quantity</label>
                                    <input type="number" min="1" name="quantity" id="quantity" class="form-control">

                                </div>
                            </div>
                            <a href="products.php" class="btn btn-danger">Back</a>
                            <?php if ($product['stock'] === 'available') : ?>
                                <button type="submit" name="submit" class="btn btn-primary">Order Now</button>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>