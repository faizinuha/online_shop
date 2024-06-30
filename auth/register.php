<?php
$title = 'Register';
require_once __DIR__ . '/layouts/main.php';


$errors = [];

if (isset($_POST['submit'])) {

    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($firstname)) {
        $errors['firstname'] = 'Firstname harus diisi.';
    }

    if (empty($lastname)) {
        $errors['lastname'] = 'lastname harus diisi.';
    }

    if (empty($username)) {
        $errors['username'] = 'Username harus diisi.';
    } elseif (strlen($username) < 3) {
        $errors['username'] = 'Username minimal 3 karakter.';
    }

    if (empty($email)) {
        $errors['email'] = 'Email harus diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Format email tidak valid.';
    } else {
        $email = mysqli_escape_string($koneksi, $email);
        $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");
        if (mysqli_num_rows($query)) {
            $errors['email'] = 'Email sudah terdaftar.';
        }
    }

    if (empty($password)) {
        $errors['password'] = 'Password harus diisi.';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password minimal 6 karakter.';
    }

    if (empty($confirm_password)) {
        $errors['confirm_password'] = 'Konfirmasi Password harus diisi.';
    } elseif ($confirm_password !== $password) {
        $errors['confirm_password'] = 'Password dan konfirmasi password tidak cocok.';
    }


    if (empty($errors)) {
        $firstname = mysqli_escape_string($koneksi, $firstname);
        $lastname = mysqli_escape_string($koneksi, $lastname);
        $username = mysqli_escape_string($koneksi, $username);
        $email = mysqli_escape_string($koneksi, $email);
        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password, firstname, lastname) VALUES ('$username', '$email', '$hash_password', '$firstname', '$lastname')";


        if (mysqli_query($koneksi, $query)) {
            // header('Location: login.php');
                
            echo '<script>window.location.href="../store/index.php"</script>';

            $_SESSION['success'] = 'Registrasi berhasil! Silahkan login.';
            exit();
        } else {
            $_SESSION['error'] = 'Gagal melakukan registrasi. Silahkan coba lagi.';
        }
    }
}

?>


<!-- Outer Row -->
<div class="row justify-content-center mt-4">

    <div class="col-xl-6 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                            </div>
                            <form class="user" action="" method="post">

                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="text" class="form-control form-control-user <?= isset($errors['firstname']) ? 'is-invalid' : '' ?>" id="firstname" placeholder="Firstname" name="firstname">
                                        <?php if (isset($errors['firstname'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['firstname'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control form-control-user <?= isset($errors['lastname']) ? 'is-invalid' : '' ?>" id="lastname" placeholder="Lastname" name="lastname">
                                        <?php if (isset($errors['lastname'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['lastname'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control form-control-user <?= isset($errors['username']) ? 'is-invalid' : '' ?>" id="username" name="username" placeholder="Username">
                                    <?php if (isset($errors['username'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['username'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control form-control-user <?= isset($errors['email']) ? 'is-invalid' : '' ?>" id="exampleInputEmail" aria-describedby="emailHelp" name="email" placeholder="Email Address">
                                    <?php if (isset($errors['email'])) : ?>
                                        <div class="invalid-feedback">
                                            <?= $errors['email'] ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" class="form-control form-control-user <?= isset($errors['password']) ? 'is-invalid' : '' ?>" id="exampleInputPassword" placeholder="Password" name="password">
                                        <?php if (isset($errors['password'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="password" class="form-control form-control-user <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" id="confirm_password" placeholder="Repeat Password" name="confirm_password">
                                        <?php if (isset($errors['confirm_password'])) : ?>
                                            <div class="invalid-feedback">
                                                <?= $errors['confirm_password'] ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <hr>
                                <button type="submit" name="submit" class="btn btn-primary btn-user btn-block">
                                    Register
                                </button>
                            </form>
                            <hr>
                            <div class="text-center">
                                <a class="small" href="login.php">Already have an account? Login!</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</div>


<?php
require_once __DIR__ . '/layouts/footer.php';
?>