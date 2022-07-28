<!-- Dùng để chỉnh sửa lesson -->

<?php
$table = "menu";
?>

<?php
include "../../../db/myFunction.php";

// truyền giá trị id và table nếu url có "?id=...&table=..."
if (isset($_GET['table']) && isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $table = $_GET['table'];
    $data = getItemById($table, $id_menu);

    while ($row = $data->fetch_assoc()) {
        $name_menu = $row['name_menu'];
        $parent = $row['parent'];
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $table = $_POST['table'];
    $id_menu = $_POST['id'];
    $id_menu_dad = $_POST['id_menu_dad'];
    $name_lesson = $_POST['name_lesson'];
    $result = updateItem($table, $id_menu, $name_lesson, $id_menu_dad);
    if ($result == 1) {
        $parent = $id_menu_dad;
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
        <?php if (isset($_GET['table']) && isset($_GET['id'])) {

        ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&parent=$parent#popup-insert-lesson")  ?>" method="post">
                <!-- Truyền id vào input hidden -->
                <input type="hidden" name="id" id="get_id" value='<?= $id_menu ?>' />

                <!-- Truyền table vào input hidden -->
                <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>

                <fieldset>
                    <h3>Chỉnh sửa Bài học</h3>

                    <div class="form-group">
                        <label for="id_menu">Chọn menu</label>
                        <div class="select-wrapper">
                            <select class="select-wrapper" name="id_menu_dad" id="id_menu_dad">
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
                        <input type="text" name="name_lesson" id="name_lesson" value='<?= $name_menu ?>' placeholder="Nhập tên bài học ..." />
                    </div>

                    <button type="submit" class="button-33" name="update">Cập nhật</button>
                    <a href="listLesson.php?table=<?= $table ?>&parent=<?= $parent ?>" class="button-16 float-right">Hủy</a>
                </fieldset>

            </form>
        <?php } ?>
    </div>
</body>

</html>