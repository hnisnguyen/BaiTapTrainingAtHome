<!-- Dùng để đặt lại mật khẩu -->

<?php
require_once "../db/mydb.php";

    // Define variables and initialize with empty values
$email_user = $new_password = $confirm_new_password = "";
$email_err = $new_password_err = $confirm_new_password_err = "";

if(isset($_GET['code'])) {
    $code = $_GET['code'];
    $connect = connectdb();
    $verifyQuery = $connect->query("SELECT * FROM users WHERE code_reset = '$code' and update_date >= NOW() - Interval 2 minute");
    if($verifyQuery->num_rows == 0) {
        header("Location: user/index.php");
        exit();
    } else {
        $info = $verifyQuery->fetch_assoc();
        $email_user = $info['email'];
    }


    if(isset($_POST['change'])) {

        // Validate password
        if (empty(trim($_POST["new_password"]))) {
            $new_password_err = "Vui lòng điền mật khẩu mới.";
        } elseif (strlen(trim($_POST["new_password"])) < 6) {
            $new_password_err = "Mật khẩu cần ít nhất 6 ký tự.";
        } else {
            $new_password = trim($_POST["new_password"]);
        }

        // Validate confirm password
        if (empty(trim($_POST["confirm_new_password"]))) {
            $confirm_new_password_err = "Vui lòng xác nhận mật khẩu.";
        } else {
            $confirm_new_password = trim($_POST["confirm_new_password"]);
            if (empty($new_password_err) && ($new_password != $confirm_new_password)) {
                $confirm_new_password_err = "Mật khẩu không trùng khớp.";
            }
        }

        // Check input errors before inserting in database
        if (empty($new_password_err) && empty($confirm_new_password_err)) {
            $changeQuery = "UPDATE users SET password = ? WHERE email = ? and code_reset = ? and update_date >= NOW() - INTERVAL 2 minute";
            if ($stmt = $connect->prepare($changeQuery)) {
                // Bind variables to the prepared statement as parameters
                $stmt->bind_param("sss", $param_password, $param_email, $param_code);

                // Set parameters
                $param_password = password_hash($new_password, PASSWORD_DEFAULT); // Creates a password hash
                $param_email = $email_user;
                $param_code = $code;

                // Attempt to execute the prepared statement
                if ($stmt->execute()) {
                    // Redirect to login page
                    header("location: login.php");
                } else {
                    echo "Đã xảy ra lỗi! Vui lòng thử lại.";
                }

                // Close statement
                $stmt->close();
            }
        }
    }
    disconnectdb($connect);
}
else {
    header("Location: user/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Reset Password</title>
</head>

<body>
<div class="login-box">
    <h2>Đổi mật khẩu</h2>

    <h6><span class="error-message"><?= $new_password_err ?></span></h6>
    <h6><span class="error-message"><?= $confirm_new_password_err ?></span></h6>

    <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]."?code={$_GET['code']}"); ?>' method="POST" enctype="multipart/form-data">
        <div class="user-box">
            <input type="text" name="email" class="
                        <?php
            echo (!empty($email_err)) ? 'is-invalid' : '';
            echo (!empty($email_user)) ? 'is-valid' : '';
            ?>" placeholder="Email" disabled>
            <label>Email: <?php echo $email_user; ?></label>
        </div>

        <div class="user-box">
            <input type="password" name="new_password" class="
                        <?php
            echo (!empty($new_password_err)) ? 'is-invalid' : '';
            echo (!empty($new_password)) ? 'is-valid' : '';
            ?>" value="<?php echo $new_password; ?>" placeholder="New Password">
            <label>New Password</label>
        </div>

        <div class="user-box">
            <input type="password" name="confirm_new_password" class="
                        <?php
            echo (!empty($confirm_new_password_err)) ? 'is-invalid' : '';
            echo (!empty($confirm_new_password)) ? 'is-valid' : '';
            ?>" value="<?php echo $confirm_new_password; ?>" placeholder="Confirm New password">
            <label>Confirm New Password</label>
        </div>

        <button type="submit" name="change">Đổi mật khẩu</button>

    </form>
    <h5>
        Chưa có tài khoản? <a href="register.php"> Đăng ký ngay </a><br/>
    </h5>
</div>
<div>

</div>
</body>

</html>