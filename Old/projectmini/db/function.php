<?php

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

// trả về list
function getList($table) {
    $sql = "SELECT * FROM $table";
    return checkQuery($sql);
}

// Lấy dữ liệu bằng id
function getItemByID($table, $id) {
    $sql = "SELECT * FROM $table WHERE id = '$id'";
    return checkQuery($sql);
}

// Thêm dữ liệu
function addItem($table, $title, $date_add, $description, $content) {
    $sql = "INSERT INTO $table(title, date_add, description, content) 
            VALUES ('$title', '$date_add', '$description', '$content')";
    return checkQuery($sql);
}

// Cập nhật dữ liệu
function updateItem($table, $id, $title, $date_add, $description, $content) {
    $sql = "UPDATE $table 
                SET title='$title', date_add='$date_add', description='$description', content='$content'
                WHERE id=$id";
    return checkQuery($sql);
}

// Xóa dữ liệu
function deleteItem($table, $id) {
    $sql = "DELETE FROM $table WHERE id=$id";
    return checkQuery($sql);
}