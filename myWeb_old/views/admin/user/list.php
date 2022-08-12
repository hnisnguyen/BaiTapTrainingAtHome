<!-- Dùng để xem danh sách -->
<?php require "../../validLoggedIn.php" ?>
<?php
include "../../../db/myFunction.php";
?>
<?php if (isset($_SESSION['role']) && $_SESSION['role'] == 1) : ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../../css/styles.css">
    <link rel="stylesheet" type="text/css" href="../../../css/popup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <title>User</title>
</head>

<body>
    <?php include "../../layout/admin/sidebar.php" ?>
    <?php include "../../layout/admin/header.php"?>
    <div class="container">
        <div class="table">
            <div class="head">
                <h3> Danh sách Người dùng </h3>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên người dùng</th>
                        <th>Email</th>
                        <th>Vai trò</th>
                        <th>Ngày và giờ tạo</th>
                        <th>Ngày và giờ sửa</th>
                        <th>Xem</th>
                    </tr>
                    
                </thead>
                <tbody>
                    <?php $data = getAllUser();
                    while ($row = $data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        if ($row['role'] == 1) {
                            echo "<td>Super Admin</td>";
                        } elseif ($row['role'] == 2) {
                            echo "<td>Admin</td>";
                        } else {
                            echo "<td>User</td>";
                        }
                        echo "<td>" . $row['create_date'] . "</td>";
                        echo "<td>" . $row['update_date'] . "</td>";
                        if ($row['role'] != 1) {
                            echo "<td class='icon-td'><a href='view.php?id=".$row['id']."'>
                                <i class='fas fa-eye view-icon'></i></a></td>";
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
<?php endif; ?>