<?php
$title = 'Customers';
require_once __DIR__ . '/layouts/main.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

$role = 'customer';
$users = mysqli_query($koneksi, "SELECT * FROM users WHERE role = '$role'");

?>

<section class="section">
    <div class="section-header">
        <h1>Customers</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Categories</div>
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
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($user = mysqli_fetch_assoc($users)) {
                                    ?>
                                        <tr>
                                            <td width="5%"><?= $i ?></td>
                                            <td>
                                                <?= $user['username'] ?>
                                            </td>
                                            <td>
                                                <?= $user['email'] ?>
                                            </td>
                                            <td>
                                                <?= $user['address'] ?>
                                            </td>
                                            <td width="20%">
                                                <div class="row justify-content-center" style="display: flex; gap: 14px">
                                                <a href="profile.php?id=<?= $user['id'] ?>" class="btn btn-primary">
                                                    <i class="fas fa-fw fa-eye"></i>
                                                </a>
                                                <?php
                                                if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                                ?>
                                                    <a href="edit_customer.php?id=<?= $user['id'] ?>" class="btn btn-warning">
                                                        <i class="fas fa-fw fa-pen"></i>
                                                    </a>
                                                    <a href="destroy_customer.php?id=<?= $user['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-fw fa-trash"></i>
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