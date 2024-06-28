<?php
$title = 'Edit Customer';
require_once __DIR__ . '/layouts/main.php';

$errors = [];

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
    $customer = mysqli_fetch_assoc($query);
}

if (isset($_POST['submit'])) {
    $input = ['username', 'email', 'address', 'role'];

    $errors = [];

    foreach ($input as $value) {
        if (empty($_POST[$value])) {
            $errors[$value] = $value . ' harus diisi.';
        }
    }

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $role = $_POST['role'];

    if (empty($username)) {
        $errors['username'] = 'Username harus diisi.';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username minimal 3 karakter.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email harus diisi.';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    } else {
        $email = mysqli_escape_string($koneksi, $email);
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email' AND id != '$id'");
        if (mysqli_num_rows($query)) {
            $errors['email'] = 'Email sudah terdaftar.';
        }
    }

    if (empty($address)) {
        $errors['address'] = 'Alamat Harus diisi.';
    }

    if (empty($errors)) {
        $username = mysqli_escape_string($koneksi, $username);
        $email = mysqli_escape_string($koneksi, $email);
        $address = mysqli_escape_string($koneksi, $address);
        $role = mysqli_escape_string($koneksi, $role);


        $query = "UPDATE users SET username = '$username', email = '$email', address = '$address', role = '$role' WHERE id = '$id'";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = 'Update Customer success!';
            echo '<script>window.location.href="customers.php"</script>';
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update Customer.';
        }
    }
}
?>

<div class="card mb-3">
    <div class="card-header">
        <h1>Edit Customer</h1>
    </div>
    <div class="card-body">
        <form action="" method="POST">
            <div class="row">
                <div class="col-5 ms-5 mb-3">
                    <label for="username" class="form-label">Customer Username</label>
                    <input type="text" name="username" id="username" class="form-control" value="<?= htmlspecialchars($customer['username']) ?>">
                </div>
                <div class="col-5 ms-5 mb-3">
                    <label for="email" class="form-label">Customer Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($customer['email']) ?>">
                </div>
                
                <div class="col-5 ms-5 mb-3">
                    <label for="address" class="form-label">Customer Address</label>
                    <textarea name="address" class="form-control" id="address"><?= $customer['address'] ?></textarea>
                </div>

                <div class="col-5 ms-5">
                    <label for="role" class="form-label">Customer Role</label>
                    <select name="role" id="role" class="form-control">
                        <option value="customer" <?= $customer['role'] == 'customer' ? 'selected' : '' ?> >Customer</option>
                        <option value="admin" <?= $customer['role'] == 'admin' ? 'selected' : '' ?> >Admin</option>
                    </select>
                </div>

            </div>
            <a href="customers.php" class="btn btn-danger">Back</a>
            <button type="submit" name="submit" class="btn btn-primary">Edit</button>
        </form>
    </div>
</div>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>
