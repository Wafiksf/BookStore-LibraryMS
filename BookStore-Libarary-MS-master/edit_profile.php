<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
include 'connection.php';
    if (!isset($_SESSION['email'])) {
      header("Location: index.php");
      exit();
  }else{
    $email = $_SESSION["email"];

    $sql = "SELECT db_fname, db_lname FROM register WHERE db_email='$email'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        $fname = $row['db_fname'];
        $lname = $row['db_lname'];

    } else {
        echo "No matching record found.";
    }
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/profile.css">
    <title>My Profile</title>
</head>
<body>
  <?php
   include 'header.php';
  ?>
<div class="container mt-4">
  <div class="info col-4">
    <h3>Personal Informations</h3><br>
    <h5>Logged in with:</h5>
    <p><?php echo $email; ?></p>
    <h5>Username</h5>
    <p><?php echo $fname . ' ' . $lname; ?></p>
    <?php if (isset($msg)): ?>
     <div class="msg"><p><?php echo $msg; ?></p></div>
    <?php endif; ?>
    <?php if (isset($msg1)): ?>
      <div class="msg1"><p><?php echo $msg1; ?></p></div>
    <?php endif; ?>
    <a href="#" class="btn btn-warning" id="btn-warning" onclick="showResetPasswordDiv()">Reset Password</a>
    <a href="#" class="btn btn-primary" id="btn-primary" onclick="showEditNameDiv()">Edit Name</a>
  </div>

  <div class="info col-4" id="editDiv" style="display: none;">
    <a href="#" class="btn btn-danger" id="btn-danger" style="float: left;" onclick="hideEditDiv()"><i class="fa-solid fa-arrow-left"></i></a><br><br>
    <div id="editContent"></div>
  </div>
</div>
<script src="js/profile.js"></script>
<?php
   include 'footer.php';
  ?>
</body>
</html>
