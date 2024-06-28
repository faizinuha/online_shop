<?php
$title = 'Categories';
require_once __DIR__ . '/layouts/main.php';


$categories = mysqli_query($koneksi, "SELECT c.*, COUNT(p.id) as total_product 
                        FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id");

?>

<section class="section">
    <div class="section-header">
        <h1>Categories</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Categories</div>
        </div>
    </div>

    <div class="section-body">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php
                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') :
                    ?>
                        <div class="card-header">
                            <a href="create_category.php" class="btn btn-primary">Add Category</a>
                        </div>
                    <?php
                    endif;
                    ?>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th>Category Name</th>
                                        <th>Total Product</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    while ($category = mysqli_fetch_assoc($categories)) {
                                    ?>
                                        <tr>
                                            <td width="5%"><?= $i ?></td>
                                            <td><?= $category['name'] ?></td>
                                            <td>
                                                <div class="badge badge-success"><?= $category['total_product'] ?></div>
                                            </td>
                                            <td width="20%">
                                                <div class="row justify-content-center" style="display: flex; gap: 12px">
                                                    <a href="category.php?id=<?= $category['id'] ?>" class="btn btn-primary">
                                                        <i class="fas fa-fw fa-eye"></i>
                                                    </a>
                                                    <?php
                                                    if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
                                                    ?>
                                                        <a href="edit_category.php?id=<?= $category['id'] ?>" class="btn btn-warning">
                                                            <i class="fas fa-fw fa-pen"></i>
                                                        </a>
                                                        <a href="destroy_category.php?id=<?= $category['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">
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