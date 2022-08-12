<!-- Dùng để đăng ký tài khoản, vai trò mặc định cho đăng ký là người dùng (role = 0) -->

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

// Define variables and initialize with empty values
$email_user = $username = $password = $confirm_password = "";
$email_err = $username_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
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
                    $email_err = "Địa chỉ mail đã tồn tại.";
                } else {
                    $email_user = trim($_POST["email"]);
                }
            } else {
                echo "Đã xảy ra lỗi! Vui lòng thử lại.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate username
    if (empty(trim($_POST["username"]))) {
        $username_err = "Vui lòng nhập tên người dùng.";
    } elseif (!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))) {
        $username_err = "Tên người dùng chỉ bao gồm chữ cái, số và dấu gạch chân.";
    } else {
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE name = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // store result
                $stmt->store_result();

                if ($stmt->num_rows == 1) {
                    $username_err = "Tên người dùng đã tồn tại.";
                } else {
                    $username = trim($_POST["username"]);
                }
            } else {
                echo "Đã xảy ra lỗi! Vui lòng thử lại.";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Validate password
    if (empty(trim($_POST["password"]))) {
        $password_err = "Vui lòng điền mật khẩu.";
    } elseif (strlen(trim($_POST["password"])) < 6) {
        $password_err = "Mật khẩu cần ít nhất 6 ký tự.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Vui lòng xác nhận mật khẩu.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "Mật khẩu không trùng khớp.";
        }
    }

    // Check input errors before inserting in database
    if (empty($email_err) && empty($username_err) && empty($password_err) && empty($confirm_password_err)) {

        // Prepare an insert statement
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("sss", $param_username, $param_email, $param_password);

            // Set parameters
            $param_username = $username;
            $param_email = $email_user;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

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

    // Close connection
    disconnectdb($connect);
}
?>

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Đăng ký</title>
</head>

<body>
    <div class="login-box">
        <h2> Đăng ký Tài khoản </h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <h6><span class="error-message"><?= $email_err ?></span></h6>
            <h6><span class="error-message"><?= $username_err ?></span></h6>
            <h6><span class="error-message"><?= $password_err ?></span></h6>
            <h6><span class="error-message"><?= $confirm_password_err ?></span></h6>
            <div class="user-box">
                <input type="text" name="email" class="
                        <?php
                        echo (!empty($email_err)) ? 'is-invalid' : '';
                        echo (!empty($email_user)) ? 'is-valid' : '';
                        ?>" value="<?php echo $email_user; ?>" placeholder="Email">
                <label>Email</label>
            </div>
            <div class="user-box">
                <input type="text" name="username" class="
                        <?php
                        echo (!empty($username_err)) ? 'is-invalid' : '';
                        echo (!empty($username)) ? 'is-valid' : '';
                        ?>" value="<?php echo $username; ?>" placeholder="Username">
                <label>Username</label>
            </div>
            <div class="user-box">
                <input type="password" name="password" class="
                        <?php
                        echo (!empty($password_err)) ? 'is-invalid' : '';
                        echo (!empty($password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $password; ?>" placeholder="Password">
                <label>Password</label>
            </div>
            <div class="user-box">
                <input type="password" name="confirm_password" class="
                        <?php
                        echo (!empty($confirm_password_err)) ? 'is-invalid' : '';
                        echo (!empty($confirm_password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $confirm_password; ?>" placeholder="Confirm password">
                <label>Confirm Password</label>
            </div>


            <button type="submit" name="register">Đăng ký</button>

        </form>
        <h5>Đã có tài khoản? <a href="login.php"> Đăng nhập ngay </a></h5>
    </div>
</body>

</html>