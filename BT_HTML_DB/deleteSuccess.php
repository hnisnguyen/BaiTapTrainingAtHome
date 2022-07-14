<?php require "info.php" ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Success Page</title>
    <link rel="stylesheet" href="css/mystyle.css">
</head>

<body>
    <div class="container">
        <?php
        //Lấy giá trị POST từ form vừa submit
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
            if (isset($_POST["id"])) {
                $id = $_REQUEST['id'];
            }
            
            $sql = "DELETE FROM tintuc WHERE id=$id";       
            if ($connect->query($sql) === TRUE) { ?>
                <div>
                    <h3>Successful !!!</h3>
                </div>
        <?php } else {
                echo "Error: " . $sql . "<br>" . $connect->error;
            }
        }
        //Đóng database
        $connect->close(); ?>
        <a href="listNews.php"><input type="button" value="Back to list"></a>
    </div>
</body>

</html>