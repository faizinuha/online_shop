    <?php
    $title = 'Edit My Orders';
    require_once __DIR__ . '/layouts/main.php';
    $user_id = $_SESSION['user_id'];

    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
        $_SESSION['error'] = 'You do not have permission to access this page.';
        echo '<script>window.location.href="orders.php"</script>';
        exit();
    }

    if (isset($_GET['id'])) {
        $order_id = intval($_GET['id']);

        $orders = mysqli_query($koneksi, "SELECT * FROM orders WHERE id = '$order_id' AND user_id = '$user_id'");
        if (mysqli_num_rows($orders) > 0) {
            $order = mysqli_fetch_assoc($orders);
            $product_id = $order['product_id'];

            $products = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$product_id'");

            if (mysqli_num_rows($products) > 0) {
                $product = mysqli_fetch_assoc($products);
            } else {
                $_SESSION['error'] = 'Product not found.';
                echo '<script>window.location.href="my_orders.php"</script>';
                exit();
            }
        } else {
            $_SESSION['error'] = 'Product not found or you do not have persmission to edit this order.';
            echo '<script>window.location.href="my_orders.php"</script>';
            exit();
        }
    } else {
        $_SESSION['error'] = 'Order ID is Not found.';
        echo '<script>window.location.href="my_orders.php"</script>';
        exit();
    }

    if (isset($_POST['submit'])) {
        $quantity = intval($_POST['quantity']);
        $total_price = $quantity * floatval($product['price']);

        if ($quantity <= 0) {
            $_SESSION['error'] = 'Invalid order.';
            echo '<script>window.location.href="order_product.php?id=' . $order_id . '"</script>';
            exit();
        }

        if ($total_price > 99999999.99) {
            $_SESSION['error'] = 'Total order melebihi batas.';
            echo '<script>window.location.href="edit_my-order.php?id=' . $order_id . '"</script>';
        }

        $query = mysqli_query($koneksi, "UPDATE orders SET quantity = '$quantity', total_price = '$total_price' WHERE id = '$order_id' AND user_id = '$user_id'");

        if ($query) {

            $order_details = mysqli_query($koneksi, "UPDATE order_details SET quantity = '$quantity' WHERE order_id = '$order_id'");

            if ($order_details) {
                $_SESSION['success'] = 'Order updated successfully!';
                echo '<script>window.location.href="my_orders.php"</script>';
                exit();
            } else {
                $_SESSION['success'] = 'Failed to update order. Please try again.';
                echo '<script>window.location.href="edit_my-order.php?id=' . $order_id . '"</script>';
                exit();
            }
        } else {
            $_SESSION['error'] = 'Failed to update order. Please try again!';
            echo '<script>window.location.href="edit_my-order.php?id=' . $order_id . '"</script>';
            exit();
        }
    }
    ?>

    <section class="section">
        <div class="section-header">
            <h1>Edit My Order</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Edit My Order</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-sm-12 col-lg-7">
                    <div class="card author-box card-primary">
                        <div class="card-body">
                            <div class="author-box-left">
                                <img alt="image" src="product-image/<?= htmlspecialchars($product['image']) ?>" class="author-box-picture">
                                <div class="clearfix"></div>
                                <div class="badge <?= $product['stock'] === 'available' ? 'badge-success' : 'badge-danger' ?> mt-3"><?= htmlspecialchars($product['stock']) ?></div>
                            </div>
                            <div class="author-box-details">
                                <div class="author-box-name">
                                    <a href="#"><?= htmlspecialchars($product['name']) ?></a>
                                </div>
                                <div class="author-box-job"><?= Rp($product['price']) ?></div>
                                <div class="author-box-description">
                                    <p><?= nl2br(htmlspecialchars($product['body'])) ?></p>
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
                                        <input type="number" min="1" name="quantity" id="quantity" class="form-control" value="<?= $order['quantity'] ?>" required>
                                    </div>
                                </div>
                                <a href="my_orders.php" class="btn btn-danger">Back</a>
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