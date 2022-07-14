<?php require "info.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Success Page</title>
    <link rel="stylesheet" href="css/mystyle.css">
</head>

<body>
    <?php
    //Lấy giá trị POST từ form vừa submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        //Code xử lý, insert dữ liệu vào table
        $sql = "INSERT INTO tintuc (title, date_add, description, content)
                        VALUES ('$title', '$date_add', '$description', '$content')";

        if ($connect->query($sql) === TRUE) { ?>
            <div  class="container">
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
    <?php } else {
            echo "Error: " . $sql . "<br>" . $connect->error;
        }
    }
    //Đóng database
    $connect->close(); ?>



    <a href="listNews.php"><input class="button-8" type="button" value="Back to list"></a>
</body>

</html>