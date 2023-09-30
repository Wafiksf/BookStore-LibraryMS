<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/signup.css"/>
    <title>Sign up</title>
</head>
<body>

<?php
include 'header.php';
?>

    <div class="container-su">
        <div class="part1-su">
            <div class="inputs-signup">
                <h1>Sign up</h1>
                 <?php if (isset($error_message)): ?>
              <p style="color: red;"><?php echo $error_message; ?></p>
              <?php endif; ?>
              <?php if (isset($done)): ?>
              <p style="color: green;"><?php echo $done; ?></p>
              <?php endif; ?>
                <form method="POST" action="signup_action.php">
                    <input type="text" name="fistname" required placeholder="Firstname" class="case"><br><br>
                    <input type="text" name="lastname" required placeholder="Lastname"class="case"><br><br>
                    <input type="email" name="email" required placeholder="Email"class="case"><br><br>
                    <input type="password" name="password" required placeholder="Password"class="case"><br><br>
                    <input type="password" name="confirmpassword" required placeholder="Confirm Password"class="case"><br><br>
                    <div class="button-su">
                    <button type="submit" class="submit-su" style="cursor:pointer;">Create Account</button>
                </div>
                </form>
            </div>
        </div>
        <div class="part2-su">
            <img  src="images/signup.webp">
        </div>

    </div>

    <?php
include 'footer.php';
?>

</body>

</html>