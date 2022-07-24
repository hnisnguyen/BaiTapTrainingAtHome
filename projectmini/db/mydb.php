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

// Ngắt kết nối database
function disconnectdb($connect) {
    $connect -> close();
}


