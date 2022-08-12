<!-- Dùng để thêm mới menu -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";   // File chứa các hàm tương tác
include "../../validation.php";         // File chứa các hàm kiểm tra form

/* 
    Khi url: "...?table={gia_tri_bat_ky}" 
    ==> $_GET['table'] = {gia_tri_bat_ky} 
*/
// Truyền giá trị vào biến $table
if (isset($_GET['table'])) {
    $table = $_GET['table'];
} else {
    die();
}

// Khởi tạo message và style cho thông báo
$msg = "";
$msgStyle = "error";    // class style .error hoặc .success cho thông báo hiện ra

// Xử lý form (method = POST) sau khi bấm nút Thêm với nút Thêm có name = 'insert' => $_POST['insert']
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert'])) {

    // Hàm kiểm tra lỗi
    [$valid, $name_menu, $nameErr] = checkValidNameMenu();

    // Kiểm tra nếu tên menu trống thì truyền lỗi lấy từ hàm checkValidNameMenu() vào biến $msg
    if (empty($name_menu)) {
        $msg = $nameErr;
    } else {
        // Nếu tên menu đã được điền
        $msg = "Thêm thành công! <br/> Trở về danh sách sau 2s ";
        $msgStyle = "success";
        $create_by = $_SESSION['id'];
        $result = addItem($table, $name_menu, $create_by);  // Hàm thêm mới (INSERT INTO) vào bảng
        if ($result == 1) {
            echo ("<meta http-equiv='refresh' content='2; url= list.php'>"); // Trả về trang list
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
    <title>Menu</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php" ?>
    <div class="container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table")  ?>" method="post">
            <!-- Truyền table vào input hidden -->
            <input type="hidden" name="table" id="get_table" value='<?php echo $_GET['table']; ?>'>

            <!-- Form -->
            <fieldset>
                <h3>Thêm mới Menu</h3>

                <!-- In ra lỗi hoặc thành công -->
                <span class='<?= $msgStyle; ?>'><?= $msg ?></span>

                <!-- 
                        Form để nhập tên Menu, với name = name_menu để lưu vào $_POST và gọi bằng cách: $_POST['name_menu'] 

                        name = 'name_menu' -> $_POST['name_menu']
                    -->
                <div class="form-group">
                    <label for="name_menu">Tên menu: <span class="error">*</span></label>
                    <input type="text" name="name_menu" id="name_menu" maxlength="50" placeholder="Nhập tên menu ..." />
                </div>

                <!-- Các nút: 
                        Thêm ( name = 'insert' -> $_POST['insert'] ), 
                        Reset, 
                        Hủy -->
                <div class="button-group">
                    <button type="submit" class="button-33" name="insert">Thêm</button>
                    <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                    <a href="list.php" class="button-16 float-right">Hủy</a>
                </div>

            </fieldset>
        </form>
    </div>
</body>

</html>