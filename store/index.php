<?php
$title = 'Dashboard';
require_once __DIR__ . '/layouts/main.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

include ('dashboard_statistics.php');

?>



<section class="section">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-stats">
                    <div class="card-stats-title">Statistics -
                    </div>
                    <div class="card-stats-items">
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $product_count ?></div>
                            <div class="card-stats-item-label">Products</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $categories_count ?></div>
                            <div class="card-stats-item-label">Categories</div>
                        </div>
                        <div class="card-stats-item">
                            <div class="card-stats-item-count"><?= $customer_count ?></div>
                            <div class="card-stats-item-label">Customers</div>
                        </div>
                    </div>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Orders</h4>
                    </div>
                    <div class="card-body">
                        <?= $order_count ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="balance-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Balance</h4>
                    </div>
                    <div class="card-body">
                        <?= Rp($total_price) ?> IDR
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="card card-statistic-2">
                <div class="card-chart">
                    <canvas id="sales-chart" height="80"></canvas>
                </div>
                <div class="card-icon shadow-primary bg-primary">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Sales</h4>
                    </div>
                    <div class="card-body">
                        <?= $sales_count ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Budget vs Sales</h4>
                </div>
                <div class="card-body">
                    <canvas id="myChart" height="158"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>