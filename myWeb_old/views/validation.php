<!-- File này dùng để ràng buộc form input và update -->

<?php

// Hàm kiểm tra dữ liệu nhập vào
function test_input($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}

/*  
    - Hàm này dùng để gọi khi muốn kiểm tra các giá trị trong Form được điền chưa và xuất ra thông báo lỗi
    - Hàm trả về các giá trị của người dùng nhập vào hoặc các thông báo lỗi về điền nội dung 
    - Cần truyền vào các thông tin như trong ngoặc, nếu không truyền mặc định là rỗng
*/
function checkValidNameMenu($name_menu = "")
{
    // Khai báo các giá trị lỗi ban đầu (mặc định là rỗng)
    $nameErr = "";

    $valid = null;

    if (empty($_POST["name_menu"])) {
        $nameErr = "Vui lòng nhập tên Menu";
        $valid = 0;
    } else {
        $name_menu = test_input($_POST["name_menu"]);
    }
    return [$valid, $name_menu, $nameErr];
}

function checkValidNameLesson($name_lesson = "")
{
    // Khai báo các giá trị lỗi ban đầu (mặc định là rỗng)
    $nameErr = "";

    $valid = null;

    if (empty($_POST["name_lesson"])) {
        $nameErr = "Vui lòng nhập tên bài học";
        $valid = 0;
    } else {
        $name_lesson = test_input($_POST["name_lesson"]);
    }
    return [$valid, $name_lesson, $nameErr];
}

function checkValidSelectMenu($id_selected = "")
{
    // Khai báo các giá trị lỗi ban đầu (mặc định là rỗng)
    $selectErr = "";

    $valid = null;

    if (empty($_POST["id_selected"])) {
        $selectErr = "Vui lòng chọn một menu";
        $valid = 0;
    } else {
        $id_selected = test_input($_POST["id_selected"]);
    }
    return [$valid, $id_selected, $selectErr];
}