<?php
$title = 'Login';
require_once __DIR__ . '/layouts/main.php';


$errors = [];

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $errors['email'] = 'Email wajib diisi';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format Email tidak valid';
    }

    if (empty($password)) {
        $errors['password'] = 'Password wajib diisi.';
    }

    if (empty($errors)) {
        $stmt = $koneksi->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows > 0) {
            $user = mysqli_fetch_assoc($result);

            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['login_date'] = date('Y-m-d H:i:s');

                header('Location: ../store/index.php');
                exit();
            } else {
                // $_SESSION['error'] = 'Email atu password Anda salah.';
                echo("<script>alert('Email atau password Anda salah.')</script>");
                
            }
        } else {
            echo("<script>alert('Email atau password Anda salah.')</script>");
            // $_SESSION['error'] = 'Email atu password Anda salah.';
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
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                            </div>
                            <form class="user" action="" method="post">
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Enter Email Address..." autocomplete="off">
                                    <?php if (isset($errors['email'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control form-control-user <?= isset($errors['password']) ? 'is-invalid' : '' ?>" name="password" id="exampleInputPassword" placeholder="Password">
                                    <?php if (isset($errors['password'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['password'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox small">
                                        <input type="checkbox" class="custom-control-input" id="customCheck">
                                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                                    </div>
                                </div>
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="register.php">Create an Account!</a>
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