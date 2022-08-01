<!-- Dùng để xóa menu -->

<?php

if (isset($_POST['delete'])) {
    $table = $_POST['table'];
    $id_menu = $_POST['id'];
    $result1 = deleteItemById($table, $id_menu);
    if ($result1 == 1) {
        // $parent = $id_menu;
        // $result2 = deleteItemByParent($table, $parent);
        // if ($result2 == 1) {
        echo ("<meta http-equiv='refresh' content='0; url=listLesson.php?table=$table&parent=$parent'>"); // Trả về trang list
        // }
    }
}
?>
<?php if (isset($_GET['id']) && isset($_GET['table']) && isset($_GET['parent'])) {
    $table = $_GET['table'];
    $parent = $_GET['parent'];
    $id_menu = $_GET['id']; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&parent=$parent&id=$id_menu&#popup-del-lesson")  ?>" method="post">
        <!-- Truyền id vào input hidden -->
        <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />

        <!-- Truyền table vào input hidden -->
        <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

        <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
        <div id="popup-del-lesson" class="overlay">
            <div class="popup">
                <a class="close" href='listLesson.php?table=<?= $table ?>&parent=<?= $parent ?>'>&times;</a>
                <div class="content">
                    Bạn có chắc muốn xóa không?
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="delete">OK</button>
                    <a href="listLesson.php?table=<?= $table ?>&parent=<?= $parent ?>" class="button-16 float-right">Hủy</a>
                </div>
            </div>
        </div>
    </form>
<?php } ?>