<!-- File này để hiển thị popup để chỉnh sửa và thực thi việc chỉnh sửa -->

<?php

// truyền giá trị id và table nếu url có "?id=...&table=..."
if (isset($_GET['id']) && isset($_GET['table'])) {
    $id = $_GET['id'];
    $table = $_GET['table'];

    // Chạy SQL lấy đối tượng có id bằng với id có được từ url
    $data = getItemByID($table, $id);

    // google serach hàm fetch_assoc nếu không biết 
    while ($row = $data->fetch_assoc()) {
        $title = $row['title'];
        $date_add = $row['date_add'];
        $description = $row['description'];
        $content = $row['content'];
    }
}

// kiểm tra form nếu không lỗi (tức là $valid = checkValidForm()[0] == 1) thì thực hiện code
if (checkValidForm()[0] == 1) {

    // Nếu Form submit là post
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // thực hiện insert khi bấm nút ok hay submit (có name="update" -> $_POST['update'])
        if (isset($_POST['update'])) {
            // [
            //     $valid, $title, $date_add, $description, $content,
            //     $titleErr, $descriptionErr, $contentErr
            // ] = checkValidForm();
            // if ($valid === 1) {
            $id = $_POST['id'];
            $table = $_POST['table'];
            $title = $_POST['title'];
            $date_add = $_POST['date_add'];
            $description = $_POST['description'];
            $content = $_POST['content'];

            // chạy SQL "UPDATE table SET ... WHERE id = ..."
            $result = updateItem($table, $id, $title, $date_add, $description, $content);
            if ($result == 1) {
                echo ("<meta http-equiv='refresh' content='0; url=list.php'>"); // Trả về trang list
            }
        }
        // }
    }
} else {
    [
        $valid, $title, $date_add, $description, $content,
        $titleErr, $descriptionErr, $contentErr
    ] = checkValidForm($title, $date_add, $description, $content);
?>
    <!-- form popup chuyển đến chính nó nếu valid = 0 -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id=$id&table=$table#popup-edit")  ?>" method="post">
        <!-- Truyền id vào input hidden -->
        <input type="hidden" name="id" id="get_id" value='<?php echo $_GET['id']; ?>' />

        <!-- Truyền table vào input hidden -->
        <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

        <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
        <div id="popup-edit" class="overlay">
            <div class="popup">
                <a class="close" href="list.php">&times;</a>
                <div class="content">
                    <fieldset>
                        <h3>Update news</h3>

                        <!-- Xuất ra lỗi nếu trống, cái này chưa làm được -->
                        <?php
                        if (isset($_POST['update'])) {
                            if (empty($title)) { ?>
                                <span class="error"><?= $titleErr; ?></span>
                            <?php } elseif (empty($description)) { ?>
                                <span class="error"><?= $descriptionErr; ?></span>
                            <?php } elseif (empty($content)) { ?>
                                <span class="error"><?= $contentErr; ?></span>
                        <?php } else {
                                "";
                            }
                        }
                        ?>

                        <!-- Form -->
                        <div class="form-group">
                            <input type="hidden" id="id" name="id" value=' <?php echo $id ?> ' />
                        </div>
                        <div class="form-group">
                            <label for="title">Title <span class="error">*</span></label>
                            <input type="text" id="title" name="title" value='<?php echo $title ?>' />
                        </div>
                        <div class="form-group">
                            <label for="date_add">Date</label>
                            <input type="date" name="date_add" id="date_add" value='<?php echo $date_add ?>' />
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="error">*</span></label>
                            <textarea name="description" id="description" rows="4" cols="50" placeholder="Enter text here ..."><?php echo $description ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Content <span class="error">*</span></label>
                            <textarea name="content" id="content" rows="4" cols="50" placeholder="Enter text here ..."><?php echo $content ?></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="update">OK</button>
                    <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                    <a href="list.php" class="button-16 float-right">Hủy</a>
                </div>
            </div>
        </div>
    </form>
<?php } ?>