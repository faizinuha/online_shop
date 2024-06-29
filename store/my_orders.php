<?php
$title = 'My Orders';
require_once __DIR__ . '/layouts/main.php';

$user_id = $_SESSION['user_id'];

$orders = mysqli_query($koneksi, "SELECT orders.id AS order_id,
                                    orders.created_at AS order_date,
                                    orders.status AS order_status,
                                    products.id AS product_id,
                                    products.name AS product_name,
                                    products.price AS product_price,
                                    order_details.quantity AS product_quantity,
                                    (order_details.quantity * products.price) AS total_price
                                FROM orders 
                                JOIN order_details ON orders.id = order_details.order_id
                                JOIN products ON order_details.product_id = products.id
                                WHERE orders.user_id = '$user_id'
                                ORDER BY orders.created_at DESC");


?>


<section class="section">
    <div class="section-header">
        <h1>My Orders</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">My Orders</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Order Date</th>
                                        <th>Product Name</th>
                                        <th>Product Price</th>
                                        <th>Quantity</th>
                                        <th>Status</th>
                                        <th>Total Price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($order = mysqli_fetch_assoc($orders)) {
                                    ?>
                                        <tr>
                                            <td width="5%"><?= $i ?></td>
                                            <td><?= $order['order_date'] ?></td>
                                            <td><?= $order['product_name'] ?></td>
                                            <td><?= Rp($order['product_price']) ?></td>
                                            <td><?= $order['product_quantity'] ?></td>
                                            <td>
                                                <div class="badge <?php if ($order['order_status'] === 'pending') :
                                                                        echo 'badge-primary';
                                                                    elseif ($order['order_status'] === 'completed') :
                                                                        echo 'badge-success';
                                                                    elseif ($order['order_status'] === 'cancelled') :
                                                                        echo 'badge-danger';
                                                                    endif; ?>">
                                                    <?= $order['order_status'] ?></div>
                                            </td>
                                            <td>Rp. <?= Rp($order['total_price']) ?></td>
                                            <td width="20%">
                                                <div class="row justify-content-center" style="display: flex; gap: 12px">
                                                    <?php
                                                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer') {
                                                    ?>
                                                        <a class="btn btn-warning text-white" href='edit_my-order.php?id=<?= $order['product_id'] ?>'>
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </a>

                                                        <a class="btn btn-danger text-white" data-confirm="Realy?|Do you want to cancelled?" data-confirm-yes="window.location.href='destroy_order.php?id=<?= $order['order_id']?>'">
                                                            <i class="fas fa-fw fa-times"></i>
                                                        </a>

                                                    <?php
                                                    }
                                                    ?>
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
require_once  __DIR__ . '/layouts/footer.php';
?>