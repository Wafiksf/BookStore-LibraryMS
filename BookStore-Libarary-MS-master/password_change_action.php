<?php
require_once 'connection.php';
session_start();

if (isset($_POST['password_update'])) {
  $newPassword = $_POST['newPassword'];
  $confirmPassword = $_POST['confirmPassword'];
  $token = $_POST['password_token'];
  $email = $_POST['email'];

  $query = "SELECT * FROM register WHERE verification_token = '$token'";
  $result = mysqli_query($connection, $query);

  if (mysqli_num_rows($result) > 0) {
    if ($newPassword === $confirmPassword) {
      $updateQuery = "UPDATE register SET db_password = '$newPassword', verification_token = '-1' WHERE verification_token = '$token' LIMIT 1";
      mysqli_query($connection, $updateQuery);

      $_SESSION['msg'] = "Password updated successfully!";
      header("Location: password_change.php?token=$token&email=$email");
    } else {
      $_SESSION['msg1'] = "Please confirm your password.";
      header("Location: password_change.php?token=$token&email=$email");
    }
  } else {
    $_SESSION['msg1'] = "Expired reset link.";
    header("Location: password_change.php?token=$token&email=$email");
  }
}
?>
