<?php
session_start();

if (isset($_SESSION) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    echo "<div class='greeting'><i class='fas fa-user-circle'></i> Hello, " . $username . "</div>";
    echo "<a href='../logout.php'><i class='fas fa-sign-out-alt'></i> Đăng xuất </a>";
} else {
    echo "<a href='../login.php'> Đăng nhập </a>";
}
?>

<img src="../../images/logoIDS.png" alt="IDS Vietnam" />
<p>IDS Vietnam</p>