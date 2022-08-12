<!-- Dùng để thêm mới bài học -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";   // File chứa các hàm tương tác
include "../../validation.php";         // File chứa các hàm kiểm tra form

/* 
    Khi url: "...?table={gia_tri_table}&parent={gia_tri_parent}" 
    ==> $_GET['table'] = {gia_tri_table}
        $_GET['parent'] = {gia_tri_parent} 
*/
// Truyền giá trị vào biến $table và $parent
if (isset($_GET['table']) && isset($_GET['parent'])) {
    $table = $_GET['table'];
    $parent = $_GET['parent'];

    // Khởi tạo các biến rỗng để truyền giá trị vào
    $id_menu = "";
    $name_menu = "";
    $id_secondary = "";
    $name_secondary = ""; // chưa xài
    $parent_secondary = ""; // chưa xài

    $data = getAllDetailByParent($table, $parent);  // Hàm lấy các giá trị bao gồm các giá trị con của nó (secondary)
    while ($row = $data->fetch_assoc()) {
        // primary
        $id_menu = $row['id_menu'];
        $name_menu = $row['name_menu'];

        // secondary
        $id_secondary = $row['id_secondary'];
        $name_secondary = $row['name_secondary']; // chưa xài
        $parent_secondary = $row['parent_secondary']; // chưa xài
    }
} elseif (isset($_GET['table'])) {  // Nếu url chỉ là: "...?table={gia_tri_table}" ==> chỉ lấy được $_GET['table'] = {gia_tri_table}
    $table = $_GET['table'];
} else { // Nếu url không có phần: "...?..."
    die();
}

// Khởi tạo message và style cho thông báo
$msg = "";
$msgStyle = "error";    // class style .error hoặc .success cho thông báo hiện ra

// Xử lý form (method = POST) sau khi bấm nút Thêm với nút Thêm có name = 'insert' => $_POST['insert']
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {

    // Hàm kiểm tra lỗi
    [$valid, $id_selected, $selectErr] = checkValidSelectMenu();

    // Kiểm tra nếu tên menu trống thì truyền lỗi lấy từ hàm checkValidNameMenu() vào biến $msg
    if (empty($id_selected)) {
        $msg = $selectErr;
    } else {
        $parent = $id_selected; // select hết lỗi thì gán vào biến parent để thực hiện việc update
        [$valid, $name_lesson, $nameErr] = checkValidNameLesson();
        if (empty($name_lesson)) {
            $msg = $nameErr;
        } else {
            // Nếu tên menu đã được điền
            $msg = "Thêm thành công! <br/> Trở về danh sách sau 2s ";
            $msgStyle = "success";
            $create_by = $_SESSION['id'];
            $result = addItem($table, $name_lesson, $create_by, $parent);
            if ($result == 1) {
                echo ("<meta http-equiv='refresh' content='2; url= list.php?table=$table&parent=$parent'>"); // Trả về trang list
            }
        }
    }
}
?>

<!-- HTML -->
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
    <?php include "../../layout/admin/header.php" ?>
    <div class="container">
        <!-- Đường dẫn Form nếu có đủ table và parent trong url -->
        <?php if (isset($_GET['table']) && isset($_GET['parent'])) { ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&parent=$parent")  ?>" method="post">

                <!-- Đường dẫn Form nếu chỉ có table trong url -->
            <?php } elseif (isset($_GET['table'])) { ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table")  ?>" method="post">

                    <!-- Nếu không có gì -->
                <?php } else {
                die();
            } ?>

                <!-- Truyền table vào input hidden -->
                <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>

                <fieldset>
                    <h3>Thêm mới Bài học</h3>

                    <!-- In ra lỗi hoặc thành công -->
                    <span class='<?= $msgStyle; ?>'><?= $msg ?></span>

                    <!-- Form select dropdown: name = 'id_menu' ==> $_POST['id_menu'] -->
                    <div class="form-group">
                        <label for="id_menu">Chọn menu</label>
                        <div class="select-wrapper">
                            <select class="select-wrapper" name="id_selected" id="id_selected">
                                <option value="" hidden>Menu</option>
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

                    <!-- 
                        Form để nhập tên Bài học, với name = name_lesson để lưu vào $_POST và gọi bằng cách: $_POST['name_lesson'] 

                        name = 'name_lesson' -> $_POST['name_lesson']
                    -->
                    <div class="form-group">
                        <label for="name_lesson">Tên bài học:</label>
                        <input type="text" name="name_lesson" id="name_lesson" placeholder="Nhập tên bài học ..." />
                    </div>

                    <!-- Các nút: 
                        Thêm ( name = 'insert' -> $_POST['insert'] ), 
                        Reset, 
                        Hủy -->
                    <div class="button-group">
                        <button type="submit" class="button-33" name="insert">Thêm</button>
                        <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>

                        <?php if (isset($_GET['table']) && isset($_GET['parent'])) { ?>
                            <a href="list.php?table=<?= $table ?>&parent=<?= $parent ?>" class="button-16 float-right">Hủy</a>
                        <?php } ?>
                    </div>
                </fieldset>

                </form>
    </div>
</body>

</html>