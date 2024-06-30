<?php
$title = 'Create Category';
require_once __DIR__ . '/layouts/main.php';

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

$old = [];
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' || isset($_POST['submit'])) {
    $name = $_POST['name'];

    if (strlen($name) < 3) {
        $errors['name'] = 'Name minimal 3 karakter';
    }

    if (empty($name)) {
        $errors['name'] = 'Name harus diisi.';
    }

    if (!empty($errors)) {
        $_SESSION['old'] = $_POST;
        $_SESSION['errors'] = $errors;
        echo '<script>window.location.href="create_category.php"</script>';
        exit();
    }

    if (empty($errors)) {
        $name = htmlentities($_POST['name']);

        mysqli_query($koneksi, "INSERT INTO categories (name) VALUE ('$name')");

        $_SESSION['successs'] = 'Create category success!';
        echo '<script>window.location.href="categories.php"</script>';
        exit();
    }
}

if (isset($_SESSION['old'])) {
    $old = $_SESSION['old'];
    unset($_SESSION['old']);
}

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
?>


<div class="card mb-3">
    <div class="card-header">
        <h1>Upload</h1>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="row">
                <div class="col-5 ms-5 mb-3">
                    <label for="name" class="form-label">Category Name</label>
                    <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= isset($old['name']) ? $old['name'] : '' ?>">

                    <div class="invalid-feedback">
                        <?= $errors['name'] ?>
                    </div>
                </div>
            </div>
            <a href="categories.php" class="btn btn-danger">Back</a>
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</div>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>