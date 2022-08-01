<!-- 
    * Chạy link cho file này đầu tiên 
    * File này hiển thị danh sách và các nút để tương tác thêm xóa sửa 
    * Muốn xem chi tiết các hàm có dạng: ten_ham(), 
                ví dụ hàm getList() trong file này, thì nhấn giữ Ctrl và click chuột vào hàm đó
-->

<?php
include "../../db/mydb.php";    // dùng để gọi các hàm kết nối hoặc đóng database
include "../../db/function.php";    // dùng để gọi các hàm thực thi SQL

// tên bảng
$table = "tintuc";

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Link import CSS chung -->
    <link rel="stylesheet" type="text/css" href="../../css/styles.css">

    <!-- Link import CSS cho popup -->
    <link rel="stylesheet" type="text/css" href="../../css/popup.css">

    <!-- Link import cho icon font awesome free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />

    <title>List</title>
</head>

<body>
    <header>
        <!-- thêm header vào file -->
        <?php include_once "../layout/header.php" ?>    
    </header>

    <nav>
        <!-- thêm menu vào file -->
        <?php include_once "../layout/menu.php" ?>
    </nav>

    <main>
        <div class="container">
            <div class="head">
                <h2> List of News </h2>

                <!-- Nút thêm mới (dấu cộng) -->
                <a href='?table=<?= $table ?>#popup-insert' class="button-8"><i class="fas fa-plus"></i></a>

            </div>

            <!-- bảng danh sách tin tức -->
            <div class="table">
                <table>

                    <!-- Phần tiêu đề -->
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
                            <th class="th-edit">Edit</th>
                            <th class="th-delete">Delete</th>
                        </tr>
                    </thead>

                    <!-- Phần danh sách -->
                    <tbody>
                        <?php
                        $data = getList($table);    // Thực thi câu lệnh "SELECT * FROM ..." trong SQL

                        // Truyền các giá trị của dữ liệu theo từng dòng để in ra từng dòng của bảng
                        while ($row = $data->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['title'] . "</td>";
                            echo "<td>" . $row['date_add'] . "</td>";
                            echo "<td>" . $row['description'] . "</td>";
                            echo "<td>" . $row['content'] . "</td>";

                            // Nút chỉnh sửa (icon bút chì)
                            echo "<td class='icon-td'><a href=\"?id=" . $row['id'] . "&table=" . $table . "#popup-edit\">
                                <i class='fas fa-pencil-alt edit-icon'></i></a></td></td>";

                            // Nút xóa (icon thùng rác)
                            echo "<td class='icon-td'><a href=\"?id=" . $row['id'] . "&table=" . $table . "#popup-del\">
                                <i class='fa fa-trash delete-icon'></i></a></td>";
                            echo "</tr>";
                        }

                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer>
        <!-- thêm footer vào file -->
        <?php include_once "../layout/footer.php" ?>
    </footer>
</body>

</html>

<?php

// Thêm các file của popup và kiểm tra form
include "validation/validateForm.php";  // file chứa hàm kiểm tra ràng buộc form
include "popup/popup_insert.php";
include "popup/popup_delete.php";
include "popup/popup_edit.php";

?>