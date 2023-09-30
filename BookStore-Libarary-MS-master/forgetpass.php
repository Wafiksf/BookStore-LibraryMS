<!DOCTYPE html>
<html>
<head>
  <title>Forget Password - Email Validation</title>
  <link rel="icon" href="images/Logo1.png" type="image/x-icon">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="css/login.css">
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
<div class="forget">
  <div class="container cont-forget col-5">
    <h2>Please Enter Your Email Address</h2>
    <p class="msg-forget-green"><?php echo $msg; ?></p>
    <p class="msg-forget-red"><?php echo $msg1; ?></p>
    <form action="forgetpass_action.php" method="POST">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <button type="submit" name="password_reset_link" class="btn btn-primary" id="verify">Verify Email</button>
    </form>
  </div>
  </div>
<?php
include 'footer.php';
?>
</body>
</html>