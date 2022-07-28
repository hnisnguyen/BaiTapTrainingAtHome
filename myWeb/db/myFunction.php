<!-- Chứa các hàm để tương tác với database -->

<?php
include "mydb.php";
// Thực thi câu lệnh sql truyền vào
function checkQuery($sql) {
    $connect = connectdb();
    $result = $connect->query($sql);
    if ($result) {
        disconnectdb($connect);
        return $result;
    } else {
        return "Error: " . $sql . "<br>" . $connect->error;
    }
}

// Thêm mới dữ liệu 
function addItem($table, $name, $parent = 0) {
    $sql = "INSERT INTO $table (name_menu, parent) VALUES ('$name', '$parent')";
    return checkQuery($sql);
}

// Lấy danh sách khi có id và parent
function getItemById($table, $id_menu, $del_flag = 0) {
    $sql = "SELECT * FROM $table WHERE id_menu = '$id_menu' AND del_flag = '$del_flag'";
    return checkQuery($sql);
}

// lấy danh sách khi chỉ có parent
function getListByParent($table, $parent = 0, $del_flag = 0) {
    $sql = "SELECT * FROM $table WHERE parent = '$parent' AND del_flag = '$del_flag'";
    return checkQuery($sql);
}

// Cập nhật dữ liệu
function updateItem($table, $id, $name, $parent = 0) {
    $sql = "UPDATE $table SET name_menu = '$name', parent = '$parent' WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Xóa dữ liệu parent = 0
function deleteItemById($table, $id) {
    $sql = "UPDATE $table SET del_flag = 1 WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Xóa dữ liệu con thuộc parent đó
function deleteItemByParent($table, $parent) {
    $sql = "UPDATE $table SET del_flag = 1 WHERE parent = '$parent'";
    return checkQuery($sql);
}