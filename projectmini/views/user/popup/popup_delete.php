<!-- File này dùng để hiển thị popup cho việc xóa 1 thông tin và thực thi nó khi nhấn OK -->

<?php

// thực hiện xóa khi bấm nút ok hay submit (có name="delete" -> $_POST['delete'])
if (isset($_POST['delete'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];

    // Chạy SQL "DELETE FROM table WHERE id=..."
    deleteItem($table, $id);
    echo("<meta http-equiv='refresh' content='0'>"); // refresh page
    
}

?>

<form action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" method="post">
    <!-- Truyền id vào input hidden -->
    <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />

    <!-- Truyền table vào input hidden -->
    <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

    <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
    <div id="popup-del" class="overlay">
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