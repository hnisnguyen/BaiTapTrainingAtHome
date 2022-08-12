<!-- Chứa các hàm để tương tác với database -->

<?php
include "mydb.php";
// Thực thi câu lệnh sql truyền vào
function checkQuery($sql)
{
    $connect = connectdb();
    $result = $connect->query($sql);
    if ($result) {
        disconnectdb($connect);
        return $result;
    } else {
        return "Error: " . $sql . "<br>" . $connect->error;
    }
}

// Thêm mới dữ liệu vào bảng menu
function addItem($table, $name, $create_by, $parent = 0)
{
    $sql = "INSERT INTO $table (name_menu, parent, create_by) VALUES ('$name', '$parent', '$create_by')";
    return checkQuery($sql);
}

// Lấy danh sách của bảng menu khi có id và parent
function getItemById($table, $id_menu, $del_flag = 0)
{
    $sql = "SELECT * FROM $table WHERE id_menu = '$id_menu' AND del_flag = '$del_flag'";
    return checkQuery($sql);
}

// lấy danh sách của bảng menu khi chỉ có parent
function getListByParent($table, $parent = 0, $del_flag = 0)
{
    $sql = "SELECT * FROM $table WHERE parent = '$parent' AND del_flag = '$del_flag'";
    return checkQuery($sql);
}

// Cập nhật dữ liệu vào bảng menu khi có id
function updateItem($table, $id, $name, $update_by, $parent = 0)
{
    $sql = "UPDATE $table SET name_menu = '$name', parent = '$parent', 
            update_date=current_timestamp, update_by = '$update_by' WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Xóa dữ liệu bảng menu khi có id
function deleteItemById($table, $id)
{
    $sql = "UPDATE $table SET del_flag = 1 WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Xóa dữ liệu con của bảng menu có chung 1 parent truyền vào
function deleteItemByParent($table, $parent)
{
    $sql = "UPDATE $table SET del_flag = 1 WHERE parent = '$parent'";
    return checkQuery($sql);
}

// Ghép bảng với chính nó để lấy các giá trị (primary) liên quan bằng id của secondary
// M1 là secondary
// M2 là primary
function getAllDetailById($table, $id)
{
    $sql = "SELECT M1.*, M2.id_menu AS id_primary, M2.name_menu AS name_primary, M2.parent AS parent_primary
            FROM $table M1 
            JOIN $table M2 
            ON M1.parent = M2.id_menu 
            AND M1.id_menu = '$id'";
    return checkQuery($sql);
}

// Ghép bảng với chính nó để lấy các giá trị (secondary) liên quan bằng parent (id của primary)
// M1 là primary
// M2 là secondary
function getAllDetailByParent($table, $parent)
{
    $sql = "SELECT M1.*, M2.id_menu AS id_secondary, M2.name_menu AS name_secondary, M2.parent AS parent_secondary
            FROM $table M1 
            JOIN $table M2 
            ON M1.id_menu = M2.parent 
            AND M1.id_menu = '$parent'";
    return checkQuery($sql);
}

// Thêm mới nội dung vào bảng content
function addContent($content, $id_menu, $create_by, $table = 'content')
{
    $sql = "INSERT INTO $table (content, id_menu, create_by) VALUES ('$content', '$id_menu', '$create_by')";
    return checkQuery($sql);
}

// Lấy nội dung bài học khi có id của menu
function getContent($id_menu, $table = 'content')
{
    $sql = "SELECT * FROM $table WHERE id_menu = '$id_menu' AND del_flag = 0";
    return checkQuery($sql);
}

// Cập nhật nội dung của bảng content
function updateContent($content, $id, $update_by, $table = 'content')
{
    $sql = "UPDATE $table SET content = '$content', update_date=current_timestamp, 
                update_by = '$update_by' WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Xóa content
function deleteContent($id, $table = 'content')
{
    $sql = "UPDATE $table SET del_flag = 1 WHERE id_menu = '$id'";
    return checkQuery($sql);
}

// Lấy tất cả người dùng từ bảng users
function getAllUser($table = 'users')
{
    $sql = "SELECT * FROM $table WHERE del_flg = 0";
    return checkQuery($sql);
}

// Lấy thông tin 1 người dùng khi có id
function getUser($id, $table = 'users')
{
    $sql = "SELECT * FROM $table WHERE id = '$id' AND del_flg = 0";
    return checkQuery($sql);
}

// Cập nhật quyền của người dùng khi có id
function updateRole($id, $role, $table = 'users')
{
    $sql = "UPDATE $table SET role = $role WHERE id = '$id' AND del_flg = 0";
    return checkQuery($sql);
}
