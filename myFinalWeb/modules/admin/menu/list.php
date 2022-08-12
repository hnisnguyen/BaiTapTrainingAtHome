<!-- Dùng để xem danh sách menu -->
<?php require "../../validLoggedIn.php" ?>
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
    <title>Menu</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php" ?>
    <div class="container">
        <div class="table">
            <div class="head">
                <h3> Danh sách menu </h3>
                <!-- Nút thêm mới (dấu cộng) -->
                <a href='insert.php?table=<?= $table ?>' class="button-8"><i class="fas fa-plus"></i></a>
            </div>
            <table>
                <thead>
                    <tr>
                        <th rowspan="2">Tên menu</th>
                        <th rowspan="2">Ngày và giờ tạo</th>
                        <th rowspan="2">Người tạo</th>
                        <th rowspan="2">Ngày và giờ sửa</th>
                        <th rowspan="2">Người sửa</th>
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
                        echo "<td>" . $row['create_date'] . "</td>";

                        $item = getUser($row['create_by'])->fetch_assoc();
                        echo "<td>" . $item['name'] . "</td>";
                        echo "<td>" . $row['update_date'] . "</td>";

                        $item = getUser($row['update_by'])->fetch_assoc();
                        if (!empty($item)) {
                            echo "<td>" . $item['name'] . "</td>";
                        } else {
                            echo "<td></td>";
                        }
                        echo "<td class='icon-td'><a href='../lesson/list.php?table=" . $table . "&parent=" . $row['id_menu'] . "'>
                            <i class='fas fa-eye view-icon'></i></a></td>";

                        echo "<td class='icon-td'><a href='update.php?table=" . $table . "&id=" . $row['id_menu'] . "'>
                            <i class='fas fa-pencil-alt edit-icon'></i></a></td>";

                        echo "<td class='icon-td'><a href='?table=" . $table . "&id=" . $row['id_menu'] . "#popup-del-menu'>
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
include "../menu/delete.php";
?>