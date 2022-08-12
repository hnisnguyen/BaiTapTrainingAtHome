<!-- Dùng để xóa nội dung bài học -->

<?php

if (isset($_POST['delete'])) {
    $id_menu = $_POST['id'];
    $result = deleteContent($id_menu);
    if ($result == 1) {
        echo ("<meta http-equiv='refresh' content='0; url=list.php?id=$id_menu'>"); // Trả về trang list
    }
}
?>
<?php if (isset($_GET['id'])) {
    $id_menu = $_GET['id']; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id_menu&#popup-del-content")  ?>" method="post">
        <!-- Truyền id vào input hidden -->
        <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />

        <!-- Truyền table vào input hidden -->
        <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

        <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
        <div id="popup-del-content" class="overlay">
            <div class="popup">
                <a class="close" href='list.php?id=<?= $id_menu ?>'>&times;</a>
                <div class="content">
                    Bạn có chắc muốn xóa không?
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="delete">OK</button>
                    <a href="list.php?id=<?= $id_menu ?>" class="button-16 float-right">Hủy</a>
                </div>
            </div>
        </div>
    </form>
<?php } ?>