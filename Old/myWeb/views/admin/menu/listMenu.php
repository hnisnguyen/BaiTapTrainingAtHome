<!-- Dùng để xem danh sách -->

<?php
include "../../../db/myFunction.php";
$table = "menu";
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
    <title>Danh sách menu</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <div class="container">
        <div class="table">
            <div class="head">
                <h3> Danh sách menu </h3>
                <!-- Nút thêm mới (dấu cộng) -->
                <a href='insertMenu.php?table=<?= $table ?>' class="button-8"><i class="fas fa-plus"></i></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Tên menu</th>
                        <th colspan="3">Thao tác</th>
                    </tr>
                    <tr>
                        <th>Xem</th>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $data = getListByParent($table);
                    while ($row = $data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['name_menu'] . "</td>";
                        echo "<td class='icon-td'><a href='../lesson/listLesson.php?table=".$table."&parent=".$row['id_menu']."'>
                            <i class='fas fa-eye view-icon'></i></a></td>";

                        echo "<td class='icon-td'><a href='updateMenu.php?table=".$table."&id=".$row['id_menu']."'>
                            <i class='fas fa-pencil-alt edit-icon'></i></a></td>";

                        echo "<td class='icon-td'><a href='?table=".$table."&id=".$row['id_menu']."#popup-del-menu'>
                            <i class='fa fa-trash delete-icon'></i></a></td>";
                        echo "</tr>";
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>

<?php 
// include "../menu/insertMenu.php";
// require "../menu/updateMenu.php";
include "../menu/deleteMenu.php";
?>