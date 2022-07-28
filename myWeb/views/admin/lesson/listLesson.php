<!-- Dùng để xem danh sách -->

<?php
include "../../../db/myFunction.php";
if (isset($_GET['table']) && isset($_GET['parent'])) {
    $table = $_GET['table'];
    $parent = $_GET['parent'];

?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="../../../css/styles.css">
        <link rel="stylesheet" type="text/css" href="../../../css/popup.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
        <title>Danh sách Bài học</title>
    </head>

    <body>
        <?php include "../../layout/admin/sidebar.php" ?>
        <div class="container">
            <div class="table">
                <div class="head">
                    <!-- <a class="button-16" href="../menu/listMenu.php">Trở về danh sách menu</a> -->
                    <h3> Danh sách Bài học </h3>
                    <!-- Nút thêm mới (dấu cộng) -->
                    <a href='insertLesson.php?table=<?= $table ?>&parent=<?= $parent ?>' class="button-8"><i class="fas fa-plus"></i></a>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">Tên bài</th>
                            <th colspan="3">Thao tác</th>
                        </tr>
                        <tr>
                            <th>Xem</th>
                            <th>Sửa</th>
                            <th>Xóa</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php


                        $data = getListByParent($table, $parent);
                        $count = 1;
                        while ($row = $data->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>Bài " . $count . ": " . $row['name_menu'] . "</td>";
                            echo "<td class='icon-td'><a href=''><i class='fas fa-eye view-icon'></i></a></td>";

                            echo "<td class='icon-td'><a href='updateLesson.php?table=" . $table . "&id=" . $row['id_menu'] . "'>
                            <i class='fas fa-pencil-alt edit-icon'></i></a></td>";

                            echo "<td class='icon-td'><a href='?table=" . $table . "&parent=" . $parent . "&id=" . $row['id_menu'] . "#popup-del-lesson'>
                            <i class='fa fa-trash delete-icon'></i></a></td>";
                            echo "</tr>";
                            $count += 1;
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>

    </html>

<?php
}
include "../lesson/deleteLesson.php";
?>