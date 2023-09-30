<?php
session_start();
include "connection.php";

$curpass = $_POST['curpass'];
$newpass = $_POST['newpass'];
$conpass = $_POST['conpass'];
$email = $_SESSION['email'];

if (!isset($_SESSION['wrongPassCount'])) {
    $_SESSION['wrongPassCount'] = 0;
}

if ($newpass == $conpass) {
    $sql = "SELECT db_password FROM register WHERE db_email = '$email'";
    $res = mysqli_query($connection, $sql);

    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $oldpass = $row["db_password"];
        if ($oldpass == $curpass) {
            $query = "UPDATE register SET db_password = '$newpass' WHERE db_email = '$email'";
            $result = mysqli_query($connection, $query);

            if ($result) {
                $msg1 = "Password updated successfully!";
            } else {
                $msg = "Error updating password.";
            }
        } else {
            $msg = "Your current password is wrong.";
            $_SESSION['wrongPassCount']++;

            if ($_SESSION['wrongPassCount'] >= 3) {
                header('Location: forgetpass.php');
                exit();
            }
        }
    } else {
        $msg = "No data.";
    }
} else {
    $msg = "Please confirm your password.";
}
include 'edit_profile.php';

?>
