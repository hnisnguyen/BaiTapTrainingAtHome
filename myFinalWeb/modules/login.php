<!-- Giao diện login, Dùng để đăng nhập -->

<?php
// Initialize the session
session_start();

// Kiểm tra xem có tồn tại cookie chưa
// Nếu có thì set session bằng cookie
if (isset($_COOKIE['USER_NAME'])) {
    $_SESSION["loggedin"] = true;
    $_SESSION['username'] = $_COOKIE['USER_NAME'];
    $_SESSION['role'] = $_COOKIE['ROLE'];
}

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    require "isAdmin.php";
}

// Include config file
require_once "../db/mydb.php";
$connect = connectdb();

// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Check if username is empty
    if (empty(trim($_POST["username"]))) {
        $username_err = "Vui lòng nhập tên người dùng.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Check if password is empty
    if (empty(trim($_POST["password"]))) {
        $password_err = "Vui lòng điền mật khẩu.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validate credentials
    if (empty($username_err) && empty($password_err)) {
        // Prepare a select statement
        $sql = "SELECT id, name, password, role FROM users WHERE name = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);

            // Set parameters
            $param_username = $username;

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($id, $username, $hashed_password, $role);
                    if ($stmt->fetch()) {
                        if (password_verify($password, $hashed_password)) {

                            // Nếu tick Remember me thì set COOKIE 1 tháng
                            if ($_POST["remember_me"] == '1' || $_POST["remember_me"] == 'on') {
                                $hour = time() + 3600 * 24 * 30;
                                setcookie('USER_NAME', $username, $hour);
                                setcookie('PASSWORD', $hashed_password, $hour);
                                setcookie('ROLE', $role, $hour);
                            }

                            // Password is correct, so start a new session
                            session_start();

                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            $_SESSION["role"] = $role;

                            require "isAdmin.php";
                        } else {
                            // Password is not valid, display a generic error message
                            $login_err = "Sai mật khẩu.";
                        }
                    }
                } else {
                    // Username doesn't exist, display a generic error message
                    $login_err = "Tên đăng nhập không tồn tại.";
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

<!-- HTML -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/login.css">
    <title>Đăng nhập</title>
</head>

<body>
    <div class="login-box">
        <h2>Đăng nhập Tài khoản</h2>

        <!-- Hiển thị lỗi khi đăng nhập (nếu có) -->
        <?php
        if (!empty($login_err)) {
            echo "<h6><span class='error-message'>" . $login_err . "</span></h6>";
        }
        ?>
        <h6><span class="error-message"><?= $username_err ?></span></h6>
        <h6><span class="error-message"><?= $password_err ?></span></h6>

        <!-- Form -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">

            <!-- Nhập Tên người dùng (username) -->
            <div class="user-box">
                <input type="text" name="username" class="
                        <?php
                        echo (!empty($username_err)) ? 'is-invalid' : '';
                        echo (!empty($username)) ? 'is-valid' : '';
                        ?>" value="<?php echo $username; ?>" placeholder="Username">
                <label>Username</label>
            </div>

            <!-- Nhập mật khẩu (password) -->
            <div class="user-box">
                <input type="password" name="password" class="
                        <?php
                        echo (!empty($password_err)) ? 'is-invalid' : '';
                        echo (!empty($password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $password; ?>" placeholder="Password">
                <label>Password</label>
            </div>

            <!-- Nút Remember me -->
            <div class="user-checkbox">
                <label><input type="checkbox" name="remember_me"><span>Remember me</span></label>
            </div>

            <button type="submit" name="Login">Đăng nhập</button>

        </form>
        <h5>
            Chưa có tài khoản? <a href="register.php"> Đăng ký ngay </a><br /> Hay
            <a href="forgot_password.php"> Quên mật khẩu? </a>
        </h5>
    </div>
    <div>

    </div>
</body>

</html>