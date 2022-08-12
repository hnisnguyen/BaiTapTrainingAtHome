<!-- Dùng để logout, xóa hết session hay cookie -->

<?php
// Initialize the session (Chạy session)
session_start();
 
// Unset all of the session variables (Xóa các biến trong session)
$_SESSION = array();
 
// Destroy the session. (Xóa hoặc hủy session)
session_destroy();

// Kiểm tra nếu còn cookie thì xóa
if(isset($_COOKIE['USER_NAME']))
{
    unset($_COOKIE['USER_NAME']);
    unset($_COOKIE['PASSWORD']);
    unset($_COOKIE['ROLE']);
    setcookie('USER_NAME','',time()-86400*30);
    setcookie('PASSWORD','',time()-86400*30);
    setcookie('ROLE','',time()-86400*30);
}
 
// Redirect to login page (Trả về trang đăng nhập)
header("location: login.php");
exit;
?>