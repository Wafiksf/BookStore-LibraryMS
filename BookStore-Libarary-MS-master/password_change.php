<!DOCTYPE html>
<html>
<head>
  <title>Forget Password - New Password Setup</title>
  <link rel="icon" href="images/Logo1.png" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <link rel="stylesheet" href="css/login.css">
  <script src="reset_password.js"></script>
</head>
<body>
<?php
include 'header.php';

if (isset($_SESSION["msg"])) {
  $msg = $_SESSION["msg"];
  unset($_SESSION["msg"]);
} else {
  $msg = "";
}
if (isset($_SESSION["msg1"])) {
    $msg1 = $_SESSION["msg1"];
    unset($_SESSION["msg1"]);
  } else {
    $msg1 = "";
  }
?>
<div class="confirm-pass">
  <div class="container cont-forget col-5">
    <h2>New Password Setup</h2>
    <p class="msg-forget-green"><?php echo $msg; ?><p>
    <p class="msg-forget-red"><?php echo $msg1; ?><p>
    <form id="resetPasswordForm" action="password_change_action.php" method="POST">
        <input type="hidden" name="password_token" value="<?php if(isset($_GET['token'])){echo $_GET['token'];} ?>">
        <input type="hidden" name="email" value="<?php if(isset($_GET['email'])){echo $_GET['email'];} ?>">
      <div class="form-group">
        <label for="newPassword">New Password:</label>
        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
      </div>
      <div class="form-group">
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
      </div>
      <input type="hidden" id="email" name="email" value="">
      <button type="submit" class="btn btn-primary" name="password_update" id="change-pass">Change Password</button>
    </form>
  </div>
</div>
<?php
include 'footer.php';
?>
</body>
</html>