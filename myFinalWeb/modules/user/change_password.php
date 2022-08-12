<!-- Dùng để người dùng thay đổi mật khẩu -->

<?php
include "../../db/myFunction.php";
?>
<?php
session_start();
// Check if the user is logged in, otherwise redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Include config file
require_once "../../db/mydb.php";
$connect = connectdb();

// Define variables and initialize with empty values
$current_password = $new_password = $confirm_password = "";
$current_password_err = $new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Validate current password
    if (empty(trim($_POST["current_password"]))) {
        $current_password_err = "Vui lòng nhập mật khẩu cũ.";
    } else {
        $current_password = trim($_POST["current_password"]);

        $sql = "SELECT password FROM users WHERE id = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $_SESSION['id'];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($current_password, $hashed_password)) {

                            // Store data in session variables
                            $_SESSION["id"] = $param_id;
                        } else {
                            // Password is not valid, display a generic error message
                            $current_password_err = "Mật khẩu hiện tại của bạn không đúng.";
                        }
                    }
                } else {
                    $current_password_err = "Sai mật khẩu.";
                }
            } else {
                echo "Đã xảy ra lỗi! Vui lòng thử lại.";
            }
        }
    }

    // Validate new password
    if (empty(trim($_POST["new_password"]))) {
        $new_password_err = "Vui lòng nhập mật khẩu mới.";
    } elseif (strlen(trim($_POST["new_password"])) < 6) {
        $new_password_err = "Mật khẩu cần ít nhất 6 ký tự.";
    } else {
        $new_password = trim($_POST["new_password"]);

        $sql = "SELECT password FROM users WHERE id = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("i", $param_id);

            // Set parameters
            $param_id = $_SESSION['id'];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Store result
                $stmt->store_result();

                // Check if username exists, if yes then verify password
                if ($stmt->num_rows == 1) {
                    // Bind result variables
                    $stmt->bind_result($hashed_password);
                    if ($stmt->fetch()) {
                        if (password_verify($new_password, $hashed_password)) {

                            // Password is not valid, display a generic error message
                            $new_password_err = "Mật khẩu trùng với mật khẩu cũ.";
                        } else {
                            // Store data in session variables
                            $_SESSION["id"] = $param_id;
                        }
                    }
                } else {
                    $new_password_err = "Lỗi.";
                }
            } else {
                echo "Đã xảy ra lỗi! Vui lòng thử lại.";
            }
        }
    }

    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "Vui lòng xác nhận mật khẩu.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Mật khẩu xác nhận không trùng khớp.";
        }
    }

    // Check input errors before updating the database
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";

        if ($stmt = $connect->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bind_param("si", $param_password, $param_id);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: ../login.php");
                exit();
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


<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="../../css/user-styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Đổi mật khẩu</title>
</head>

<body>
    <header>
        <!-- thêm header vào file -->
        <?php include "../layout/user/header.php" ?>
    </header>

    <nav>
        <!-- thêm menu vào file -->
        <?php include "../layout/user/navigation.php" ?>
    </nav>
    <main>
        <div class="container">

            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <fieldset>
                    <h2> Đổi mật khẩu </h2>

                    <h6><span class="error-message"><?= $current_password_err ?></span></h6>
                    <h6><span class="error-message"><?= $new_password_err ?></span></h6>
                    <h6><span class="error-message"><?= $confirm_password_err ?></span></h6>

                    <div class="form-group">
                        <label>Mật khẩu hiện tại</label>
                        <input type="password" name="current_password" class="
                        <?php
                        echo (!empty($current_password_err)) ? 'is-invalid' : '';
                        echo (!empty($current_password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $current_password; ?>" placeholder="Nhập mật khẩu hiện tại">
                    </div>

                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" name="new_password" class="
                        <?php
                        echo (!empty($new_password_err)) ? 'is-invalid' : '';
                        echo (!empty($new_password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $new_password; ?>" placeholder="Nhập mật khẩu mới">
                    </div>
                    
                    <div class="form-group">
                        <label>Xác nhận mật khẩu</label>
                        <input type="password" name="confirm_password" class="
                        <?php
                        echo (!empty($confirm_password_err)) ? 'is-invalid' : '';
                        echo (!empty($confirm_password)) ? 'is-valid' : '';
                        ?>" value="<?php echo $confirm_password; ?>" placeholder="Xác nhận mật khẩu mới">
                    </div>

                    <div class="button-group">
                        <button class="button-33" type="submit" name="reset_password">Cập nhật mật khẩu</button>
                        <a href="index.php" class="button-16 float-right">Hủy</a>
                    </div>
                </fieldset>
            </form>
        </div>
    </main>
    <footer>
        <!-- thêm footer vào file -->
        <?php include "../layout/user/footer.php" ?>
    </footer>
</body>

</html>