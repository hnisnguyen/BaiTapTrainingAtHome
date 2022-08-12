<!-- Dùng để xóa menu -->

<?php

if (isset($_POST['delete'])) {
    $table = $_POST['table'];
    $id_menu = $_POST['id'];
    $result1 = deleteItemById($table, $id_menu);
    if ($result1 == 1) {
        $parent = $id_menu;
        $result2 = deleteItemByParent($table, $parent);
        if ($result2 == 1) {
            $listItems = getAllDetailByParent($table, $parent);
            $listIdMenu = array();
            while ($row = $listItems->fetch_assoc()) {
                $listIdMenu[] = $row['id_secondary'];
            }
            foreach ($listIdMenu as $item) {
                $result3 = deleteContent($item);
            }
            if ($result3 == 1) {
                echo ("<meta http-equiv='refresh' content='0'>"); // Trả về trang list
            }
        }
    }
}
?>
<?php if (isset($_GET['id']) && isset($_GET['table'])) { ?>
    <form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
        <!-- Truyền id vào input hidden -->
        <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />

        <!-- Truyền table vào input hidden -->
        <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

        <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
        <div id="popup-del-menu" class="overlay">
            <div class="popup">
                <a class="close" href="list.php">&times;</a>
                <div class="content">
                    Bạn có chắc muốn xóa không?
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="delete">OK</button>
                    <a href="list.php" class="button-16 float-right">Hủy</a>
                </div>
            </div>
        </div>
    </form>
<?php } ?>