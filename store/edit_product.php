<?php
$title = 'Edit Product';
require_once __DIR__ . '/layouts/main.php';

$user_id = $_SESSION['user_id'];

if (isset($_SESSION['role']) && $_SESSION['role'] !== 'admin') {
    $_SESSION['error'] = 'You do not have permission to access this page.';
    echo '<script>window.location.href="products.php"</script>';
    exit();
}

$categories = mysqli_query($koneksi, "SELECT * FROM categories");


if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    $query  = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$id'");
    $product = mysqli_fetch_assoc($query);

    if ($user_id != $product['user_id']) {
        $_SESSION['error'] = 'You do not have permission to access this page.';
        echo '<script>window.location.href="products.php"</script>';
        exit();
    }
    
    if (!$product) {
        $_SESSION['error'] = 'Product not found.';
        echo '<script>window.location.href="products.php"</script>';
    }

    
    $oldImage = $product['image'];
}


if (isset($_POST['submit'])) {
    $input = ['name', 'price', 'stock', 'body'];

    $ext = ['jpg', 'jpeg', 'png'];

    $errors = [];

    foreach ($input as $value) {
        if (empty($_POST[$value])) {
            $errors[$value] = $value . ' harus diisi.';
        }
    }

    if ($_POST['price'] <= 0) {
        $errors['price'] = 'Invalid Price Product.';

    }

    if (!is_numeric($_POST['price'])) {
        $errors['price'] = 'Prices must be numbers.';
    }

    if (!$oldImage) {
        $errors['image'] = 'Image harus diisi.';
    }


    if (empty($errors)) {
        $name = htmlentities($_POST['name']);
        $price = htmlentities($_POST['price']);
        $stock = htmlentities($_POST['stock']);
        $body = htmlentities($_POST['body']);
        $category_id = htmlentities($_POST['category_id']);



        $excerpt = createExcerpt($_POST['body'], 100);

        $image = $product['image'];

        if (!empty($_FILES['image']['name'])) {

            $image = time() . $_FILES['image']['name'];

            $path = $_FILES['image']['tmp_name'];

            $explode = explode('.', $image);

            $ext = strtolower(end($explode));

            if (in_array($ext, ['jpg', 'png', 'jpeg'])) {

                unlink('product-image/' . $oldImage);
                move_uploaded_file($path, 'product-image/' . $image);

            } else {
                $errors['image'] = 'Invalid file Extension.';
            }
        }

        if (empty($errors)) {
            $updated_at = date('Y-m-d H:i:s');

            $query = mysqli_query($koneksi, "UPDATE products SET name = '$name', price = '$price', stock = '$stock', body = '$body', category_id = '$category_id', excerpt = '$excerpt', image = '$image', updated_at = '$updated_at' WHERE id = '$id'");

            $_SESSION['success'] = 'Update Product success!';
            echo '<script>window.location.href="products.php"</script>';

        }
    }
}

?>



<div class="card mb-3">
    <div class="card-header">
        <h1>Edit Product</h1>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-5 ms-5 mb-3">

                    <label for="name" class="form-label">Product Name</label>
                    <input type="text" name="name" id="name" class="form-control <?= isset($errors['name']) ? 'is-invalid' : '' ?>" value="<?= $product['name'] ?>">

                    <div class="invalid-feedback">
                        <?= $errors['name'] ?>
                    </div>
                </div>
                <div class="col-5 ms-5 mb-3">
                    <label for="price" class="form-label">Product Price</label>
                <input type="number" name="price" id="price" class="form-control <?= isset($errors['price']) ? 'is-invalid' : '' ?>" value="<?= $product['price'] ?>">

                    <div class="invalid-feedback">
                        <?= $errors['price'] ?>
                    </div>
                </div>
                <div class="col-5 ms-5">
                    <label for="stock" class="form-label">Product Stock</label>
                    <select name="stock" id="stock" class="form-control <?= isset($errors['stock']) ? 'is-invalid' : '' ?>">
                        <option value="available" selected>Available</option>
                        <option value="out of stock">Out Of Stock</option>
                    </select>

                </div>
                <div class="col-5">
                    <label for="body" class="form-label">Description Product</label>
                    <textarea name="body" id="body" rows="3" class="form-control <?= isset($errors['body']) ? 'is-invalid' : '' ?>"><?= $product['body'] ?></textarea>

                    <div class="invalid-feedback">
                        <?= $errors['body'] ?>
                    </div>
                </div>


                <div class="col-5 mt-3">
                    <label for="image" class="form-label">Post Image</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text" for="image">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= isset($errors['image']) ? 'is-invalid' : '' ?>" id="image" name="image" onchange="document.getElementById('img-preview').src = window.URL.createObjectURL(this.files[0])">
                            <label class="custom-file-label" for="image">Choose file</label>
                        </div>

                        <div class="invalid-feedback">
                            <?= $errors['image'] ?>
                        </div>
                    </div>


                    <label class="form-label">Image Preview</label>
                    <div class="col-12">
                        <div class="card">
                            <img class="card-img-top img-fluid" style="height: 300px; object-fit: cover" id="img-preview" src="product-image/<?= $product['image'] ?>">
                        </div>
                    </div>
                </div>
                <div class="col-5 mt-3">
                    <label>Categories</label>
                    <select class="form-control <?= isset($errors['category_id']) ? 'is-invalid' : '' ?>" name="category_id">
                        <?php
                        foreach ($categories as $category) :
                        ?>
                            <option value="<?= $category['id'] ?>" <?= $product['category_id'] === $category['id'] ? 'selected' : '' ?>> <?= $category['name'] ?> </option>
                        <?php
                        endforeach;
                        ?>
                    </select>

                    <div class="invalid-feedback">
                        <?= $errors['category_id'] ?>
                    </div>
                </div>

                <div class="col-6 mt-4 ms-5">
                    <a href="products.php" class="btn btn-danger">Back</a>
                    <button type="submit" name="submit" class="btn btn-primary w-25">Edit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>