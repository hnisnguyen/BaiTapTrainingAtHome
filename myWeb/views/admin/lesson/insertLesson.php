<!-- Dùng để thêm mới lesson -->

<?php
include "../../../db/myFunction.php";
$table = "menu";
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $table = $_POST['table'];
    $parent = $_POST['id_menu'];
    $name_lesson = $_POST['name_lesson'];
    $result = addItem($table, $name_lesson, $parent);
    if ($result == 1) {
        echo ("<meta http-equiv='refresh' content='0; url= listLesson.php?table=$table&parent=$parent'>"); // Trả về trang list
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/styles.css">
    <title>Thêm mới Menu</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <div class="container">
        <?php if (isset($_GET['table']) && isset($_GET['parent'])) {
            $table = $_GET['table'];
            $parent = $_GET['parent'];
        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&parent=$parent#popup-insert-lesson")  ?>" method="post">
                <!-- Truyền table vào input hidden -->
                <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>

                <fieldset>
                    <h3>Thêm mới Bài học</h3>

                    <div class="form-group">
                        <label for="id_menu">Chọn menu</label>
                        <div class="select-wrapper">
                            <select class="select-wrapper" name="id_menu" id="id_menu">
                                <?php $data = getListByParent($table);
                                while ($row = $data->fetch_assoc()) {
                                    if ($row['id_menu'] == $parent) {
                                        echo "<option selected value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                    } else {
                                        echo "<option value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                    }
                                } ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="name_lesson">Tên bài học:</label>
                        <input type="text" name="name_lesson" id="name_lesson" placeholder="Nhập tên bài học ..." />
                    </div>

                    <button type="submit" class="button-33" name="insert">Thêm</button>
                    <a href="listLesson.php?table=<?= $table ?>&parent=<?= $parent ?>" class="button-16 float-right">Hủy</a>
                </fieldset>

            </form>
        <?php } ?>
    </div>
</body>

</html>