<!-- Dùng để xem danh sách -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";
$id = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$data_content = getContent($id);

$row_content = $data_content->fetch_assoc();
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
    <title>Nội dung bài</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php"?>
    <div class="container">
        <div class="table">
            <div class="head">
                <?php
                $data = getItemById('menu', $id);
                $row = $data->fetch_assoc();
                echo "<h3 class='menu-title'>" . $row['name_menu'] . "</h3>"
                ?>
                <h3> Nội dung </h3>
                <!-- Nút thêm mới (dấu cộng) -->
                <?php if (is_null($row_content)) {
                    $table = 'menu'; ?>
                    <a href='insert.php?table=<?= $table ?>&id=<?= $id ?>' class="button-8">
                        <i class="fas fa-plus"></i></a>
                <?php } ?>
            </div>
            <table class="content_list">
                <thead>
                    <tr>
                        <th rowspan="2">Nội dung</th>
                        <th rowspan="2">Ngày và giờ tạo</th>
                        <th rowspan="2">Ngày và giờ sửa</th>
                        <th colspan="2">Thao tác</th>
                    </tr>
                    <tr>
                        <th>Sửa</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data_content = getContent($id);
                    while ($row = $data_content->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td class='content'>" . substr($row['content'], 0, 2300) . "<br/>(còn tiếp)</td>";
                        echo "<td>" . $row['create_date'] . "</td>";
                        echo "<td>" . $row['update_date'] . "</td>";

                        echo "<td class='icon-td'><a href='update.php?id=" . $row['id_menu'] . "'>
                            <i class='fas fa-pencil-alt edit-icon'></i></a></td>";

                        echo "<td class='icon-td'><a href='?id=" . $row['id_menu'] . "#popup-del-content'>
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
include "delete.php";
?>