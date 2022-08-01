<?php require "info.php" ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/popup.css">
        <link rel="stylesheet"
              href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <title>List of news</title>
    </head>

    <body>
    <?php include "../../BT_Design_Web/layout/header.php" ?>
    <?php include "../../BT_Design_Web/layout/menu.php" ?>

    <div class="container">
        <h3> List of News </h3>
        <div>
            <form>
                <a href="addNews.php"><input class="button-8" type="button" value="Create"></a>
            </form>
        </div>
        <table>
            <thead>
            <tr>
                <th rowspan="2">ID</th>
                <th rowspan="2">Title</th>
                <th rowspan="2">Date</th>
                <th rowspan="2">Description</th>
                <th rowspan="2">Content</th>
                <th colspan="2">Action</th>
            </tr>
            <tr>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM tintuc";
            $data = $connect->query($sql); ?>
            <?php foreach ($data as $key => $val) : ?>
                <?php
                echo '<tr>
                                <td>' . $val['id'] . '</td>
                                <td>' . $val['title'] . '</td>
                                <td>' . $val['date_add'] . '</td>
                                <td>' . $val['description'] . '</td>
                                <td>' . $val['content'] . '</td>
                                <td class="icontd"><a href="updateNews.php?id=' . $val['id'] . '"><i class="fas fa-pencil-alt"></i></a></td>
                                <!-- <td class="icontd"><a class="deleteicon" href="actionSuccess.php?id=' . $val['id'] . '" 
                                onclick="return confirm(\'Bạn có chắc chắn muốn xóa?\')"><i class="fa fa-trash"></i></a></td> -->
                                <td class="icontd"><a class="deleteicon" href="?id=' . $val['id'] . '#popup1"><i class="fa fa-trash"></i></a></td>
                                </tr>'
                ?>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </body>
    <?php include "../../BT_Design_Web/layout/footer.php"?>

    </html>

<?php include "popup_delete.php" ?>