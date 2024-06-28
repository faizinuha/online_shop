<?php
$title = 'Edit Category';
require_once __DIR__ . '/layouts/main.php'; 

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}


$errors = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM categories WHERE id = '$id'");
    
    $category = mysqli_fetch_assoc($query);

    
}

if (isset($_POST['submit'])) {
    $name = 'name';

    if (empty($name)) {
        $errors[$name] = $name . ' harus diisi.';
    }

    if (empty($errors)) {
        $name = htmlentities($_POST['name']);

        mysqli_query($koneksi, "UPDATE categories SET name = '$name' WHERE id = '$id' ");

        $_SESSION['success'] = 'Update category success!';

        echo '<script>window.location.href="categories.php"</script>';
    }
}


?>


    <div class="card mb-3">
        <div class="card-header">
            <h1>Edit Category</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                <div class="row">
                    <div class="col-5 ms-5 mb-3">
                        <label for="name" class="form-label">Category Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="<?= $category['name'] ?>">
                    </div>
                </div>
                <a href="categories.php" class="btn btn-danger">Back</a>
                <button type="submit" name="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>



<?php
require_once __DIR__ . '/layouts/footer.php';
?>