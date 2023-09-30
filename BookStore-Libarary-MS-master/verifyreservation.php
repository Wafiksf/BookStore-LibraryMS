<?php
session_start();
include "connection.php";
$email=$_SESSION['email'];
$verificationCode = $_GET['code'];

$sql = "SELECT * FROM reservation WHERE verification_code='$verificationCode' AND db_email='$email' AND status=0";
$result = mysqli_query($connection, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $id=$row['id'];
    $updateSql = "UPDATE reservation SET status=1 WHERE db_email='$email' AND id='$id'";
    mysqli_query($connection, $updateSql);
       
    header("Location:reservation.php?verified=".$id."&code=".$verificationCode);
    exit();
} 
?>

