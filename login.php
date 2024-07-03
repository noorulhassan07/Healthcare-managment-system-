<?php
include_once 'include/config.php';
session_start();

if (isset($_POST['submit'])) {
    $status = true;

    if (empty($_POST['email'])) {
        $status = false;
        $error_email = "FIELD IS EMPTY";
    } else {
        $email = $_POST['email'];
    }

    if (empty($_POST['password'])) {
        $status = false;
        $error_pass = "FIELD IS EMPTY";
    } else {
        $password = $_POST['password'];
    }

    if ($status == true) {
        $sql = "SELECT * FROM user WHERE USER_EMAIL='$email'";
        $run = mysqli_query($conn, $sql);

        if (mysqli_num_rows($run)) {
            $user = mysqli_fetch_assoc($run);

            if ($user['USER_PASS'] == md5($password)) {
                $_SESSION['user_id'] = $user['USER_ID'];
                $_SESSION['user_email'] = $email;
                header("Location: dashboard.php");
                exit();
            } else {
                $error_pass = "PASSWORD IS INCORRECT";
            }
        } else {
            $error_email = "EMAIL IS NOT REGISTERED YET";
        }
    }
}
?>

<?php include_once 'include/header.php'; ?>
<div class="container">
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 mt-5 py-3 bg-white from-wrapper">
            <div class="container shadow-lg py-3">
                <h3>Login</h3>
                <hr>
                <form action="" method="POST">
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?php echo isset($email) ? $email : ''; ?>">
                        <small class="text-danger">
                            <?php echo isset($error_email) ? $error_email : ''; ?>
                        </small>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" value="">
                        <small class="text-danger">
                            <?php echo isset($error_pass) ? $error_pass : ''; ?>
                        </small>
                    </div>
                    <div class="row">
                        <div class="col-12 col-sm-4">
                            <input type="submit" value="login" name="submit" class="btn btn-primary" />
                        </div>
                        <div class="col-12 col-sm-8 text-right">
                            <a href="register.php">Don't have an account yet?</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include_once 'include/footer.php'; ?>
