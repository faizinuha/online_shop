<!-- reset_password.php -->
<?php
$title = 'Reset Password';
require_once __DIR__ . '/layouts/main.php';

$errors = [];
$success = '';

// Memeriksa apakah email disertakan dalam URL dan mengamankannya menggunakan htmlspecialchars
$email = isset($_GET['email']) ? htmlspecialchars($_GET['email']) : '';

if (isset($_POST['submit'])) {
    // Mengambil nilai email, password, dan confirm_password dari form
    $email = isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm_password = isset($_POST['confirm_password']) ? $_POST['confirm_password'] : '';

    // Validasi email
    if (empty($email)) {
        $errors['email'] = 'Email wajib diisi';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid';
    }

    // Validasi password
    if (empty($password)) {
        $errors['password'] = 'Password wajib diisi';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password minimal harus 6 karakter';
    }

    // Validasi konfirmasi password
    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Konfirmasi password tidak cocok';
    }

    // Jika tidak ada kesalahan, lakukan update password dalam database
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $koneksi->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->bind_param("ss", $hashed_password, $email);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = 'Password Anda berhasil direset. Silakan login dengan password baru Anda.';
        } else {
            $errors['password_reset'] = 'Gagal mereset password. Silakan coba lagi.';
        }

        $stmt->close();
    }
}
?>

<section class="section">
    <div class="row justify-content-center mt-4">
        <div class="col-xl-6 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Reset Your Password</h1>
                                </div>
                                <?php if (!empty($errors)) : ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php foreach ($errors as $error) : ?>
                                            <?= $error ?><br>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($success)) : ?>
                                    <div class="alert alert-success" role="alert">
                                        <?= $success ?>
                                    </div>
                                <?php else: ?>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user <?= isset($errors['email']) ? 'is-invalid' : '' ?>" name="email" id="exampleInputEmail" placeholder="Enter Email Address" value="<?= htmlspecialchars($email) ?>">
                                            <?php if (isset($errors['email'])) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $errors['email'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="exampleInputPassword" placeholder="Enter New Password">
                                            <?php if (isset($errors['password'])) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $errors['password'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" name="confirm_password" id="exampleConfirmPassword" placeholder="Confirm New Password">
                                            <?php if (isset($errors['confirm_password'])) : ?>
                                                <div class="invalid-feedback">
                                                    <?= $errors['confirm_password'] ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
                                    </form>
                                <?php endif; ?>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="register.php">Create an Account!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="login.php">Already have an account? Login!</a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="../index.php">Back to Home!</a>
                                </div>
                            </div>
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
