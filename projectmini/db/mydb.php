<?php
function connectdb(){
    $username = "root"; // Khai báo username
    $password = "";      // Khai báo password
    $server = "localhost";   // Khai báo server
    $dbname = "nhom_tintuc";      // Khai báo database

    // Kết nối database thuctap
    $connect = new mysqli($server, $username, $password, $dbname);
    //Nếu kết nối bị lỗi thì xuất báo lỗi và thoát.
    if ($connect->connect_error) {
        die("Không kết nối :" . $connect->connect_error);
    }
    return $connect;
}

function disconnectdb($connect) {
    $connect -> close();
}

function displayList($table) {
    $connect = connectdb();
    $sql = "SELECT * FROM $table";
    $result = $connect->query($sql);
    if ($result) {
        $numRows = $result->num_rows;
        $connect->close();
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
        $connect->close();
    }
    return $result;
}

