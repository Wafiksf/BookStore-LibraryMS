<?php
include "connection.php";
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

session_start();

$email = $_POST['email'];

$email = filter_var($email, FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit();
}

$stmt = $connection->prepare("SELECT * FROM register WHERE db_email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $token = bin2hex(random_bytes(16));
    $resetLink = "localhost/lms/password_change.php?email=$email&token=$token";

    $mail = new PHPMailer(true); 

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = '';
        $mail->Password = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        $mail->setFrom('', 'bookStore'); 
        $mail->addAddress($email); 
        $mail->addReplyTo('', 'bookStore'); 

        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = "Click the following link to reset your password:<br><a href='$resetLink'>Click Me</a>";
        $mail->AltBody = 'Click the following link to reset your password: ' . $resetLink;

        $mail->SMTPDebug = false;

        $mail->send();

        $stmt = $connection->prepare("UPDATE register SET verification_token = ? WHERE db_email = ?");
        $stmt->bind_param("ss", $token, $email);
        $stmt->execute();
        $stmt->close();

        $_SESSION["msg"] = "Email sent successfully. Please check your inbox.";
        header('Location: forgetpass.php');
        exit();

    } catch (Exception $e) {
        echo "Failed to send the email. Error: " . $mail->ErrorInfo;
    }
} else {
    $_SESSION["msg1"] = "Email does not exist.";
    header('Location: forgetpass.php');
    exit();
}

$connection->close();
?>
