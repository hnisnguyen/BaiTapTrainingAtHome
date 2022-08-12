<!-- Dùng để nhập email để gửi form đặt lại mật khẩu -->

<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    require "isAdmin.php";
} else {
    // Unset all of the session variables
    $_SESSION = array();

    // Destroy the session.
    session_destroy();
}


// Include config file
require_once "../db/mydb.php";
$connect = connectdb();
$success = '';
$email_err = '';
$email_user = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

// Validate email address
    if (empty(trim($_POST["email"]))) {
        $email_err = "Vui lòng nhập địa chỉ mail.";
        // } elseif (!filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
    } elseif (!preg_match('/^([a-zA-Z0-9\.]+[@]+[a-zA-Z]+(\.)+[a-zA-Z]{2,3})$/', trim($_POST["email"]))) {
        $email_err = "Địa chỉ mail không hợp lệ.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_email);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    require "forgot_password_proccess.php";
                    $success = "Gửi thành công! Vui lòng kiểm tra Email.";
                } else {
                    $email_user = trim($_POST["email"]);
                    $email_err = "Địa chỉ mail không tồn tại.";
                }
            } else {
                echo "Đã xảy ra lỗi! Vui lòng thử lại.";
            }

            // Close statement
            $stmt->close();
        }
    }
    // Close connection
    disconnectdb($connect);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Quên mật khẩu</title>
</head>

<body>
<div class="login-box">
    <h2>Nhập Email</h2>

    <h6><span class="error-message"><?= $email_err ?></span></h6>
    <h6><span class="success-message"><?= $success ?></span></h6>
<!--    <h6><span class="success-message">--><?php //= $_SERVER['HTTP_HOST'] ?><!--</span></h6>-->

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="user-box">
            <input type="text" name="email" class="
                        <?php
            echo (!empty($email_err)) ? 'is-invalid' : '';
            echo (!empty($email_user)) ? 'is-valid' : '';
            ?>" value="<?php echo $email_user; ?>" placeholder="Email">
            <label>Email</label>
        </div>
        <button type="submit" name="send_mail">Gửi Email</button>

    </form>
    <h5>Chưa có tài khoản? <a href="register.php"> Đăng ký ngay </a></h5>
    <h5>Đã có tài khoản? <a href="login.php"> Đăng nhập ngay </a></h5>

</div>
<div>

</div>
</body>

</html>