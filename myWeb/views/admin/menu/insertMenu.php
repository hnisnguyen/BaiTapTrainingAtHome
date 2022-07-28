<!-- Dùng để thêm mới menu -->

<?php
include "../../../db/myFunction.php";
$table = "menu";
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {
    $table = $_POST['table'];
    $name_menu = $_POST['name_menu'];
    $result = addItem($table, $name_menu);
    if ($result == 1) {
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table")  ?>" method="post">
            <!-- Truyền table vào input hidden -->
            <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>
            <fieldset>
                <h3>Thêm mới Menu</h3>
                <div class="form-group">
                    <label for="name_menu">Tên menu:</label>
                    <input type="text" name="name_menu" id="name_menu" placeholder="Nhập tên menu ..." />
                </div>
                <div class="footer-popup">
                    <button type="submit" class="button-33" name="insert">Thêm</button>
                    <a href="listMenu.php" class="button-16 float-right">Hủy</a>
            </fieldset>
        </form>
    </div>
</body>

</html>