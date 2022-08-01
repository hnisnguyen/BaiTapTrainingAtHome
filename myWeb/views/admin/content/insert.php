<!-- Dùng để chỉnh sửa lesson -->
<?php require "../../validLoggedIn.php" ?>

<?php
include "../../../db/myFunction.php";
?>

<?php if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id_menu_primary = "";
    $id_menu_secondary = $_GET['id'];
    $data = getItemById($table, $id_menu_secondary);
    while ($row = $data->fetch_assoc()) {
        $id_menu_primary = $row['parent'];
    }
}       ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $id_menu_secondary = $_POST['id_menu_secondary'];
    $content = $_POST['content'];
    $result = addContent($content, $id_menu_secondary);
    if ($result == 1) {
        echo ("<meta http-equiv='refresh' content='0; url= list.php?id=$id_menu_secondary'>"); // Trả về trang list
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Thêm mới Menu</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php"?>
    <div class="container">

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&id=$id_menu_secondary") ?>" method="post">
            <!-- Truyền table vào input hidden -->
            <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>

            <fieldset>
                <h3>Thêm nội dung Bài học</h3>

                <div class="form-group">
                    <label for="id_menu">Menu</label>
                    <div class="select-wrapper">
                        <select class="select-wrapper" name="id_menu_primary" id="id_menu_primary" disabled>
                            <?php $data_primary = getListByParent($table);
                            while ($row = $data_primary->fetch_assoc()) {
                                if ($row['id_menu'] == $id_menu_primary) {
                                    echo "<option selected value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name_lesson">Chọn bài học:</label>
                    <div class="select-wrapper">
                        <select class="select-wrapper" name="id_menu_secondary" id="id_menu_secondary" aria-readonly="true">
                            <?php 
                            $data_secondary = getListByParent($table, $id_menu_primary);
                            while ($row = $data_secondary->fetch_assoc()) {
                                if ($row['id_menu'] == $id_menu_secondary) {
                                    echo "<option selected value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                } else {
                                    echo "<option value='" . $row['id_menu'] . "'>" . $row['name_menu'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="name_lesson">Nội dung:</label>
                    <textarea name="content" id="content-editor"></textarea>
                </div>

                <div class="button-group">
                    <button type="submit" class="button-33" name="insert">Thêm</button>
                    <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                    <a href="../lesson/list.php?table=<?= $table ?>&parent=<?= $id_menu_primary ?>" class="button-16 float-right">Hủy</a>
                </div>
            </fieldset>

        </form>
    </div>

    <script src="../../ckeditor/ckeditor.js"></script>

    <script>
        CKEDITOR.replace("content-editor");
    </script>
</body>

</html>