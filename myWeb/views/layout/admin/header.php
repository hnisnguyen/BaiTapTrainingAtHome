<?php
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
} ?>

<div class="header-admin">
    <div class="dropdown-wrapper" style="float: right;">
        <div class="greeting"><i class="fas fa-user-circle"></i> Hello, <?= $username ?></div>
        <div class="admin-dropdown">
            <a href=""><i class="fas fa-user"></i> Profile</a>
            <a href="../../admin/change_password/changePassword.php"><i class="fas fa-unlock"></i> Đổi mật khẩu</a>
            <hr />
            <a href="../../logout.php"><i class="fas fa-sign-out-alt"></i> Log out</a>
        </div>
    </div>
</div>