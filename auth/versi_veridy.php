<!-- forgot_password.php -->
<?php
$title = 'Forgot Password';
require_once __DIR__ . '/layouts/main.php';

$errors = [];
$success = '';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);

    if (empty($email)) {
        $errors['email'] = 'Email wajib diisi';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format Email tidak valid';
    }

    if (empty($errors)) {
        // Cek apakah email ada dalam database
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email ditemukan, proses reset password
            $user = $result->fetch_assoc();

            // Generate password reset code/link (opsional)
            // Di sini bisa digunakan untuk mengirimkan email berisi link reset password ke pengguna

            // Contoh pengiriman email (gunakan SMTP untuk produksi)
            $reset_link = "http://yourdomain.com/reset_password.php?email=$email";
            $to = $email;
            $subject = 'Reset Password';
            $message = "Silakan klik link ini untuk mereset password Anda: $reset_link";
            $headers = 'From: admin@yourdomain.com' . "\r\n" .
                'Reply-To: admin@yourdomain.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            $mail_sent = mail($to, $subject, $message, $headers);

            if ($mail_sent) {
                $success = 'Email reset password telah dikirim. Silakan periksa kotak masuk atau spam folder Anda.';
            } else {
                $errors['email'] = 'Gagal mengirim email reset password. Silakan coba lagi.';
            }
        } else {
            $errors['email'] = 'Email tidak ditemukan dalam database.';
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
                                    <h1 class="h4 text-gray-900 mb-4">Forgot Your Password?</h1>
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
                                <?php endif; ?>
                                <form class="user" action="" method="post">
                                    <div class="form-group">
                                        <input type="email" class="form-control form-control-user <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Enter Email Address..." autocomplete="off">
                                        <?php if (isset($errors['email'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['email'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Reset Password</button>
                                </form>
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
