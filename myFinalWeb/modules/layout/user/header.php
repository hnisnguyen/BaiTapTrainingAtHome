<!-- Header cho trang người dùng -->

<?php

if (isset($_SESSION) && isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
?>
<div class="header-user">
    <div class="dropdown-wrapper" style="float: right;">
        <div class="greeting"><i class="fas fa-user-circle"></i> Hello, <?= $username ?></div>
        <div class="user-dropdown">
            <a href="changePassword.php"><i class="fas fa-unlock"></i> Đổi mật khẩu</a>
            <hr />
            <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
        </div>
    </div>
</div>
<!--    echo "<div class='greeting'><i class='fas fa-user-circle'></i> Hello, " . $username . "</div>";-->
<!--    echo "<a href='../logout.php'><i class='fas fa-sign-out-alt'></i> Đăng xuất </a>";-->
<?php
} else {
    echo "<a href='../login.php'> Đăng nhập </a>";
}
?>

<img src="../../images/logoIDS.png" alt="IDS Vietnam" />
<p>IDS Vietnam</p>