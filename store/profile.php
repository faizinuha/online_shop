<?php
$title = 'Profile';
require_once __DIR__ . '/layouts/main.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = '$id'");
    $user = mysqli_fetch_assoc($query);

    if (!$user) {
        echo "User not found!";
        exit;
    }
}

$errors = [];

if (isset($_POST['submit'])) {
    $input = ['firstname', 'lastname', 'email', 'phone', 'address', 'bio'];

    foreach ($input as $value) {
        if (empty($_POST[$value])) {
            $errors[$value] = 'Please fill the ' . $value;
        }
    }

    if (empty($errors)) {
        $firstname = mysqli_real_escape_string($koneksi, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($koneksi, $_POST['lastname']);
        $email = mysqli_real_escape_string($koneksi, $_POST['email']);
        $phone = mysqli_real_escape_string($koneksi, $_POST['phone']);
        $address = mysqli_real_escape_string($koneksi, $_POST['address']);
        $bio = mysqli_real_escape_string($koneksi, $_POST['bio']);

        $query = "UPDATE users SET 
                firstname = '$firstname',
                lastname = '$lastname',
                email = '$email',
                phone = '$phone',
                address = '$address',
                bio = '$bio'
            WHERE id = '$id'";

        if (mysqli_query($koneksi, $query)) {
            $_SESSION['success'] = 'Profile updated successfully!';
            echo '<script>window.location.href="profile.php?id=' . $id . '"</script>';
            exit();
        } else {
            $_SESSION['errors'] = 'Failed to update profile.';
        }
    }
}
?>

<section class="section">
    <div class="section-header">
        <h1>Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item">Profile</div>
        </div>
    </div>
    <div class="section-body">
        <h2 class="section-title">Hi, <?= htmlspecialchars($user['username']) ?>!</h2>
        <?php if ($user['username'] === $_SESSION['username']) : ?>
        <p class="section-lead">
            Change information about yourself on this page.
        </p>
        <?php endif; ?>

        <div class="row mt-sm-4">
            <div class="col-12 col-md-12 col-lg-5">
                <div class="card profile-widget">
                    <div class="profile-widget-header">
                        <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle profile-widget-picture">
                        <div class="profile-widget-items">
                            <div class="profile-widget-item">
                                <div class="profile-widget-item-label">Products</div>
                                <div class="profile-widget-item-value">187</div>
                            </div>
                        </div>
                    </div>
                    <div class="profile-widget-description">
                        <div class="profile-widget-name"><?= $user['firstname'] ?> <?= $user['lastname'] ?> 
                            <div class="text-muted d-inline font-weight-normal">
                                <div class="slash"></div> <?= htmlspecialchars($user['role']) ?>
                            </div>
                        </div>
                        <?= $user['bio'] ?>
                    </div>
                </div>
                
            </div>
            <div class="col-12 col-md-12 col-lg-7">
                <div class="card">
                    <form method="post" action="" class="needs-validation" novalidate="" >
                        <div class="card-header">
                            <h4><?= $user['username'] !== $_SESSION['username'] ? 'User Profile' : 'Edit Profile' ?></h4>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= htmlspecialchars($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label>First Name</label>
                                    <input type="text" name="firstname" class="form-control" value="<?= $user['firstname'] ?>" required="" <?= $_SESSION['username'] !== $user['username'] ? 'disabled' : '' ?> >

                                    <div class="invalid-feedback">
                                        Please fill in the first name
                                    </div>
                                </div>
                                <div class="form-group col-md-6 col-12">
                                    <label>Last Name</label>
                                    <input type="text" name="lastname" class="form-control" value="<?= $user['lastname'] ?>" required="" <?= $user['username'] !== $_SESSION['username'] ? 'disabled' : '' ?>>
                                    <div class="invalid-feedback">
                                        Please fill in the last name
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-7 col-12">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required="" <?= $user['username'] !== $_SESSION['username'] ? 'disabled' : '' ?> >
                                    <div class="invalid-feedback">
                                        Please fill in the email
                                    </div>
                                </div>
                                <div class="form-group col-md-5 col-12">
                                    <label>Phone</label>
                                    <input type="tel" name="phone" class="form-control" value="<?= $user['phone'] ?>" required="" <?= $user['username'] !== $_SESSION['username'] ? 'disabled' : '' ?>>
                                    <div class="invalid-feedback">
                                        Please fill in the phone
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="<?= $user['address'] ?>" required="" <?= $user['username'] !== $_SESSION['username'] ? 'disabled' : '' ?>>
                                    <div class="invalid-feedback">
                                        Please fill in the address
                                    </div>
                                </div>
                            </div>
                            <?php if ($user['username'] === $_SESSION['username']) : ?>
                            <div class="row">
                                <div class="form-group col-12">
                                    <label>Bio</label>
                                    <textarea class="form-control summernote-simple" name="bio" required=""><?= $user['bio'] ?></textarea>
                                    <div class="invalid-feedback">
                                        Please fill in the bio
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/layouts/footer.php';
?>
