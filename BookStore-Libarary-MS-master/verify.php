<?php
session_start();
include "connection.php";

$verificationCode = $_GET['code'];

$sql = "SELECT * FROM register WHERE verification_code='$verificationCode'";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $email = $row['db_email'];
    
    $updateSql = "UPDATE register SET email_verified=1 WHERE db_email='$email'";
    mysqli_query($connection, $updateSql);
       
    header("Location:login.php?verified");
    exit();
} 
?>

