<!-- Dùng để chỉnh sửa menu -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";
include "../../validation.php";

/*  
    Khi url: "  ...?table={gia_tri_table}&id={gia_tri_id} " 
    ==> $_GET['table'] = {gia_tri_table} 
        $_GET['id'] = {gia_tri_id} 
*/
// Truyền giá trị vào biến $table và $id
if (isset($_GET['table']) && isset($_GET['id'])) {
    $id_menu = $_GET['id'];
    $table = $_GET['table'];
    $data = getItemById($table, $id_menu);  // Hàm lấy mọi thông tin có id_menu = $id_menu

    while ($row = $data->fetch_assoc()) {
        $name_menu = $row['name_menu']; // Lấy giá trị name_menu của id_menu có được gán vào biến $name_menu
    }
}

// Khởi tạo message và style cho thông báo
$msg = "";
$msgStyle = "error";    // class style .error hoặc .success cho thông báo hiện ra

// Xử lý form (method = POST) sau khi bấm nút 'Cập nhật' với nút 'Cập nhật' có name = 'update' => $_POST['update']
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {

    // Hàm kiểm tra lỗi
    [$valid, $name_menu, $nameErr] = checkValidNameMenu();

    // Kiểm tra nếu tên menu trống thì truyền lỗi lấy từ hàm checkValidNameMenu() vào biến $msg
    if (empty($name_menu)) {
        $msg = $nameErr;
    } else {
        // Nếu tên menu đã được điền
        $msg = "Cập nhật thành công! <br/> Trở về danh sách sau 2s ";
        $msgStyle = "success";
        $id_menu = $_POST['id'];
        $update_by = $_SESSION['id'];
        $result = updateItem($table, $id_menu, $name_menu, $update_by); // Hàm cập nhật (UPDATE) thông tin trong bảng
        if ($result) {
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
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?table=$table&id=$id_menu")  ?>" method="post">
            <!-- Truyền id vào input hidden -->
            <input type="hidden" name="id" id="get_id" value='<?= $id_menu ?>' />

            <!-- Truyền table vào input hidden -->
            <input type="hidden" name="table" id="get_table" value='<?= $table ?>'>
            <div id="edit-menu">

                <fieldset>
                    <h3>Chỉnh sửa Menu</h3>

                    <!-- In ra lỗi hoặc thành công -->
                    <span class='<?= $msgStyle; ?>'><?= $msg ?></span>

                    <!-- 
                            Form để nhập tên Menu, với name = name_menu để lưu vào $_POST và gọi bằng cách: $_POST['name_menu'] 

                            name = 'name_menu' -> $_POST['name_menu']
                        -->
                    <div class="form-group">
                        <label for="name_menu">Tên menu:</label>
                        <input type="text" name="name_menu" id="name_menu" value='<?= $name_menu ?>' placeholder="Nhập tên menu ..." />
                    </div>

                    <!-- Các nút: 
                        Cập nhật ( name = 'update' -> $_POST['update'] ), 
                        Reset, 
                        Hủy -->
                    <div class="button-group">
                        <button type="submit" class="button-33" name="update">Cập nhật</button>
                        <button type="reset" class="button-33 reset-btn" name="reset">Reset</button>
                        <a href="list.php" class="button-16 float-right">Hủy</a>
                    </div>
                </fieldset>

            </div>
        </form>
    </div>
</body>

</html>