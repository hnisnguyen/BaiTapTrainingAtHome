<!-- Dùng để kiểm tra người dùng đăng nhập hay chưa -->

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

// Check if the user is logged in, if not then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../../login.php");
    exit;
} else {
    // Check if the user's role is user or not, if isUser (role = 0), redirect him to index of user
    if (isset($_SESSION["loggedin"]) && $_SESSION["role"] === 0) {
        header("location: ../../user/index.php");
    }
}
?>