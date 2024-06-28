<?php
$title = 'Orders';
require_once __DIR__ . '/layouts/main.php';
$user_id = $_SESSION['user_id'];

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

$orders = mysqli_query($koneksi, "SELECT orders.*, products.name AS product_name, users.username AS customer_name
                                FROM orders 
                                JOIN products ON orders.product_id = products.id
                                JOIN users ON orders.user_id = users.id
                                WHERE products.user_id = $user_id
                                ORDER BY orders.created_at DESC");

?>

<section class="section">
    <div class="section-header">
        <h1>Manage Orders</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Orders</div>
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
                                        <th>Customer</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
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
                                            <td><?= $order['customer_name'] ?></td>
                                            <td><?= $order['product_name'] ?></td>
                                            <td><?= $order['quantity'] ?></td>
                                            <td>Rp. <?= Rp($order['total_price']) ?></td>
                                            <td>
                                                <div class="badge <?php if ($order['status'] === 'pending') :
                                                                        echo 'badge-primary';
                                                                    elseif ($order['status'] === 'completed') :
                                                                        echo 'badge-success';
                                                                    elseif ($order['status'] === 'cancelled') :
                                                                        echo 'badge-danger';
                                                                    endif; ?>">
                                                    <?= $order['status'] ?></div>
                                            </td>
                                            <td width="20%">
                                                <div class="row justify-content-center" style="display: flex; gap: 12px">
                                                    <?php
                                                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                                    ?>
                                                        <a class="btn btn-success text-white" data-confirm="Realy?|Do you want to approved?" data-confirm-yes="window.location.href='approve_order.php?id=<?= $order['id'] ?>'">
                                                            <i class="fas fa-fw fa-check"></i>
                                                        </a>

                                                        <a class="btn btn-danger text-white" data-confirm="Realy?|Do you want to cancelled?" data-confirm-yes="window.location.href='cancel_order.php?id=<?= $order['id'] ?>'">
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
require_once __DIR__ . '/layouts/footer.php';
?>