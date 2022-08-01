<!-- Dùng để chỉnh sửa lesson -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";   // File chứa các hàm tương tác
include "../../validation.php";         // File chứa các hàm kiểm tra form

/* 
    Khi url: "...?table={gia_tri_table}&id={gia_tri_id}" 
    ==> $_GET['table'] = {gia_tri_table}
        $_GET['id'] = {gia_tri_id} 
*/
// Truyền giá trị vào biến $table và $id
if (isset($_GET['table']) && isset($_GET['id'])) {
    $table = $_GET['table'];
    $id_menu = $_GET['id'];

    // Khởi tạo các biến rỗng để truyền giá trị vào
    $name_menu = "";
    $parent = "";
    $id_primary = "";
    $name_primary = ""; // chưa xài
    $parent_primary = ""; // chưa xài

    $data = getAllDetailById($table, $id_menu); // Hàm lấy các giá trị bao gồm các giá trị cha của nó (primary)

    while ($row = $data->fetch_assoc()) {
        // secondary
        $name_menu = $row['name_menu'];
        $parent = $row['parent'];

        // primary
        $id_primary = $row['id_primary'];
        $name_primary = $row['name_primary']; // chưa xài
        $parent_primary = $row['parent_primary'];  // chưa xài
    }
} else {
    die;
}

// Khởi tạo message và style cho thông báo
$msg = "";
$msgStyle = "error";    // class style .error hoặc .success cho thông báo hiện ra

// Xử lý form (method = POST) sau khi bấm nút 'Cập nhật' với nút 'Cập nhật' có name = 'update' => $_POST['update']
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    // Hàm kiểm tra lỗi
    [$valid, $name_lesson, $nameErr] = checkValidNameLesson();

    // Kiểm tra nếu tên menu trống thì truyền lỗi lấy từ hàm checkValidNameMenu() vào biến $msg
    if (empty($name_lesson)) {
        $msg = $nameErr;
    } else {
        // Nếu tên menu đã được điền
        $msg = "Cập nhật thành công! <br/> Trở về danh sách sau 2s ";
        $msgStyle = "success";

        $name_lesson = $_POST['name_lesson'];
        $result = updateItem($table, $id_menu, $name_lesson, $parent);
        if ($result == 1) {
            echo ("<meta http-equiv='refresh' content='2; url= list.php?table=$table&parent=$parent'>"); // Trả về trang list
        }
    }
}
?>


<!-- Form -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>Bài học</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php"?>
    <div class="container">
        <?php if (isset($_GET['table']) && isset($_GET['id'])) { ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&id=$id_menu")  ?>" method="post">
                <!-- Truyền id vào input hidden -->
                <input type="hidden" name="id_menu" id="get_id_menu" value='<?= $id_menu ?>' />

                <!-- Truyền table vào input hidden -->
                <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>

                <fieldset>
                    <h3>Chỉnh sửa Bài học</h3>

                    <!-- In ra lỗi hoặc thành công -->
                    <span class='<?= $msgStyle; ?>'><?= $msg ?></span>

                    <div class="form-group">
                        <label for="id_primary">Menu</label>
                        <div class="select-wrapper">
                            <select class="select-wrapper" name="id_primary" id="id_primary" disabled>
                                <?php $data = getListByParent($table);
                                while ($row = $data->fetch_assoc()) {
                                    if ($row['id_menu'] == $id_primary) {
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

                    <div class="button-group">
                        <button type="submit" class="button-33" name="update">Cập nhật</button>
                        <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                        <a href="list.php?table=<?= $table ?>&parent=<?= $parent ?>" class="button-16 float-right">Hủy</a>
                    </div>
                </fieldset>

            </form>
        <?php } ?>
    </div>
</body>

</html>