<!-- File này dùng để ràng buộc form input và update -->

<?php

/*  
    - Hàm này dùng để gọi khi muốn kiểm tra các giá trị trong Form được điền chưa và xuất ra thông báo lỗi
    - Hàm trả về các giá trị của người dùng nhập vào hoặc các thông báo lỗi về điền nội dung 
    - Cần truyền vào các thông tin như trong ngoặc, nếu không truyền mặc định là rỗng
*/
function checkValidForm($title="", $date_add="", $description="", $content="")
{

    // Khai báo các giá trị lỗi ban đầu (mặc định là rỗng)
    $titleErr = "";
    $descriptionErr = "";
    $contentErr = "";

    $valid = null;

    // if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (
            empty($_POST["title"]) || empty($_POST["date_add"])
            || empty($_POST["description"]) || empty($_POST["content"])
        ) {
            if (empty($_POST["title"])) {
                $titleErr = "Title is required";
                $valid = 0;
            } else {
                $title = test_input($_POST["title"]);
            }

            if (!empty($_POST["date_add"])) {
                $date_add = test_input($_POST["date_add"]);
            }

            if (empty($_POST["description"])) {
                $descriptionErr = "Description is required";
                $valid = 0;
            } else {
                $description = test_input($_POST["description"]);
            }
            if (empty($_POST["content"])) {
                $contentErr = "Content is required";
                $valid = 0;
            } else {
                $content = test_input($_POST["content"]);
            }
        } else {
            $valid = 1;
        }
    // } else {
    //     $valid = 0;
    // }
    return [
        $valid, $title, $date_add, $description, $content,
        $titleErr, $descriptionErr, $contentErr
    ];
}

// Hàm kiểm tra dữ liệu nhập vào
function test_input($data): string
{
    $data = trim($data);
    $data = stripslashes($data);
    return htmlspecialchars($data);
}
