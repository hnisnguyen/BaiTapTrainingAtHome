<!-- File này để hiển thị popup để thêm mới và thực thi việc thêm mới -->

<?php
// truyền giá trị table nếu url có "?table=..."
if (isset($_GET['table'])) {
    $table = $_GET['table'];
}

// kiểm tra form nếu không lỗi (tức là $valid = checkValidForm()[0] == 1) thì thực hiện code
if (checkValidForm()[0] == 1) {

    // Nếu Form submit là post
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // thực hiện insert khi bấm nút ok hay submit (có name="insert" -> $_POST['insert'])
        if (isset($_POST['insert'])) {

            $table = $_POST['table'];
            $title = $_POST['title'];
            $date_add = $_POST['date_add'];
            $description = $_POST['description'];
            $content = $_POST['content'];

            // chạy SQL INSERT INTO
            $result = addItem($table, $title, $date_add, $description, $content);

            // Nếu SQL thực thi thành công
            if ($result == 1) {
                echo ("<meta http-equiv='refresh' content='0; url=list.php'>"); // Trả về trang list
            }
        }
    }
} else {    // $valid = checkValidForm()[0] == 0
    [
        $valid, $title, $date_add, $description, $content,
        $titleErr, $descriptionErr, $contentErr
    ] = checkValidForm();   // Kiểm tra form trống hay không và truyền các giá trị (value) và lỗi (error)
?>
    <!-- form popup chuyển đến chính nó nếu valid = 0 -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table#popup-insert")  ?>" method="post">

        <!-- Truyền table vào input hidden -->
        <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

        <!-- Form popup gọi bằng cách truyền id div vào href cần gọi -->
        <div id="popup-insert" class="overlay">
            <div class="popup">
                <a class="close" href="list.php">&times;</a> <br />
                <div class="content">
                    <fieldset>
                        <h3>Create news</h3>

                        <!-- Xuất ra lỗi nếu trống -->
                        <?php
                        if (isset($_POST['insert'])) {
                            if (empty($title)) { ?>
                                <span class="error"><?= $titleErr; ?></span>
                            <?php } elseif (empty($description)) { ?>
                                <span class="error"><?= $descriptionErr; ?></span>
                            <?php } elseif (empty($content)) { ?>
                                <span class="error"><?= $contentErr; ?></span>
                            <?php } else {
                                "";
                            }
                        } else { ?>
                            <span class="error"><?= "* This field is required."; ?></span>
                        <?php
                        }
                        ?>

                        <!-- Form -->
                        <div class="form-group">
                            <label for="title">Title <span class="error">*</span></label>
                            <input type="text" id="title" name="title" value="<?php echo $title; ?>" />
                        </div>
                        <div class="form-group">
                            <label for="date_add">Date</label>
                            <input type="date" id="date_add" name="date_add" value="<?php echo date("Y-m-d"); ?>" />
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="error">*</span></label>
                            <textarea name="description" id="description" placeholder="Enter text here ..."><?php echo $description; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="content">Content <span class="error">*</span></label>
                            <textarea name="content" id="content" placeholder="Enter text here ..."><?php echo $content; ?></textarea>
                        </div>
                    </fieldset>
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="insert">Add</button>
                    <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                    <a href="list.php" class="button-16 float-right">Hủy</a>
                </div>
            </div>
        </div>
    </form>

<?php } ?>