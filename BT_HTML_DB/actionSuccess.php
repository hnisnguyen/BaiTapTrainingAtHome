<?php require "info.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Success Page</title>
    <link rel="stylesheet" type="text/css" href="css/styles.css">
</head>

<body>
    <?php
    //Lấy giá trị POST từ form vừa submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["id"])) {
            $id = $_REQUEST['id'];
            // trim(id) do khi ghép chuỗi nó dư khoảng cách
            $id = trim($id, " ");
        }
        if (isset($_POST["title"])) {
            $title = $_REQUEST['title'];
        }
        if (isset($_POST["date_add"])) {
            $date_add = $_REQUEST['date_add'];
        }
        if (isset($_POST["description"])) {
            $description = $_REQUEST['description'];
        }
        if (isset($_POST["content"])) {
            $content = $_REQUEST['content'];
        }

        $sql = "";
        if (!isset($id)) {
            //Code xử lý, insert dữ liệu vào table
            // baseneme(URL) để lấy đuôi của url
            // $_SERVER["HTTP_REFERER"] lấy link trước của link hiện tại sử dụng (trang có nút truy cập vào link file này)
            if (basename($_SERVER["HTTP_REFERER"]) == "addNews.php") {
                $sql = "INSERT INTO tintuc (title, date_add, description, content)
                        VALUES ('$title', '$date_add', '$description', '$content')";
            }
        } else {
            //Code xử lý, update dữ liệu của table
            if (basename($_SERVER["HTTP_REFERER"]) == "updateNews.php?id=$id") {
                $sql = "UPDATE tintuc 
                SET title='$title', date_add='$date_add', description='$description', content='$content'
                WHERE id=$id";
            }

            //Code xử lý, xóa dữ liệu của table
            if (basename($_SERVER["HTTP_REFERER"]) == "deleteNews.php?id=$id") {
                $sql = "DELETE FROM tintuc WHERE id=$id";
            }
        }
        if ($connect->query($sql) === TRUE) {
            if (empty($title) && empty($description) && empty($date_add) && empty($content)){ 
    ?>
            <div class="container">
                <div>
                    <h3>Successful !!!</h3>
                </div>
            </div>
            <?php } else { ?>
                <div class="container">
                    <div>
                        <h3>Successful !!!</h3>
                    </div>
                        <div>
                            <h3><u>News Information:</u></h3>
                            <div>
                                <div>
                                    <b><i>Title: </i></b><i><?php echo $title; ?></i>
                                </div>
                                <div>
                                    <b><i>Date: </i></b><i><?php echo $date_add; ?></i>
                                </div>
                                <div>
                                    <b><i>Description: </i></b><i><?php echo $description; ?></i>
                                </div>
                                <div>
                                    <b><i>Content: </i></b><i><?php echo $content; ?></i>
                                </div>
                            </div>
                        </div>
                </div>
        <?php } 
        } else {
                echo "Error: " . $sql . "<br>" . $connect->error;
            }
    }
    //Đóng database
    $connect->close(); ?>



    <a href="listNews.php"><input class="button-8" type="button" value="Back to list"></a>
</body>
</html>