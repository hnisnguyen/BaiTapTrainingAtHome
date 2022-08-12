<?php
require_once "../db/mydb.php";
if (isset($_POST['send_mail'])) {
    $email = $_POST['email'];
} else {
    exit();
}

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load composer's autoloader
require 'vendor/autoload.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'yuisnguyen@gmail.com';                 // SMTP username
    $mail->Password = 'dlzjhdpoxjjbnlpi';                           // SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;// Enable TLS encryption;
    // `PHPMailer::ENCRYPTION_STARTTLS` also accepted
    $mail->Port = 465;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('yuisnguyen@gmail.com', 'Admin');
    $mail->addAddress($email);     // Add a recipient

    $code = substr(str_shuffle('1234567890QWERTYUIOPASDFGHJKLZXCVBNM'), 0, 10);
    $host = $_SERVER['HTTP_HOST'];

    //Content
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->CharSet = 'UTF-8';
    $mail->Subject = 'Password Reset';
    $mail->Body = 'To reset your password click 
    <a href="http://localhost/thuctap_IDS/myFinalWeb/modules/reset_password.php?code=' . $code . '">here </a>. </br>
    Reset your password in 2 minutes.';
    
    $verifyQuery = $connect->query("SELECT * FROM users WHERE email = '$email'");
    if ($verifyQuery->num_rows) {
        $codeQuery = $connect->query("UPDATE users SET code_reset = '$code', update_date = NOW() WHERE email = '$email'");

        $mail->send();
    }

} catch
(Exception $e) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
}