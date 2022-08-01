<!-- Dùng để chỉnh sửa menu -->

<?php
include "../../../db/myFunction.php";

// truyền giá trị id và table nếu url có "?id=...&table=..."
if (isset($_GET['table']) && isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $table = $_GET['table'];
    $data = getItemById($table, $id_menu);

    while ($row = $data->fetch_assoc()) {
        $name_menu = $row['name_menu'];
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $table = $_POST['table'];
    $id_menu = $_POST['id'];
    $name_menu = $_POST['name_menu'];
    $result = updateItem($table, $id_menu, $name_menu);
    if ($result) {
        echo ("<meta http-equiv='refresh' content='0; url= listMenu.php'>"); // Trả về trang list
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table#popup-insert")  ?>" method="post">
            <!-- Truyền id vào input hidden -->
            <input type="hidden" name="id" id="get_id" value='<?= $id_menu ?>' />

            <!-- Truyền table vào input hidden -->
            <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>
            <div id="edit-menu">

                <fieldset>
                    <h3>Chỉnh sửa Menu</h3>
                    <div class="form-group">
                        <label for="name_menu">Tên menu:</label>
                        <input type="text" name="name_menu" id="name_menu" value='<?= $name_menu ?>' placeholder="Nhập tên menu ..." />
                    </div>
                    <div class="footer-popup">
                        <button type="submit" class="button-33" name="update">Cập nhật</button>
                        <a href="listMenu.php" class="button-16 float-right">Hủy</a>
                </fieldset>

            </div>
        </form>
    </div>
</body>

</html>