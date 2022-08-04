<div class="sidebar">
    <div class="sidebar-header">
        <div class="logo">
            <img src="../../../images/logoIDS.png" alt="" />
            <h3 class="logo_name">
                <span>IDS Viet Nam</span>
            </h3>
        </div>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <h3>MENU</h3>
                <ul>
                    <li><a href="../../admin/menu/list.php">Danh sách menu</a></li>
                    <li><a href="../../admin/menu/insert.php?table=menu">Thêm mới menu</a></li>
                </ul>
            </li>
            <li>
                <h3>Bài học</h3>
                <ul>
                    <!--                    <li><a href="../../admin/lesson/list.php">Danh sách bài học</a></li>-->
                    <li><a href="../../admin/lesson/insert.php?table=menu">Thêm mới bài học</a></li>
                    <!--                    <li><a href="">Chỉnh sửa bài học</a></li>-->
                </ul>
            </li>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) { ?>
                <li>
                    <h3>User</h3>
                    <ul>
                        <li><a href="../../admin/user/list.php">Danh sách người dùng</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
    </div>
</div>