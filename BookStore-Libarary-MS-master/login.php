<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css"/>
    <title>Login</title>
</head>

<body>
<?php
include 'header.php';
?>
    <section class="container-login">
        <div class="part1">
            <div class="img1">
                <img src="images/login.png" class="image1" alt="library"
                    width="600px">
            </div>
        </div>
        <div class="part2">
            <div class="login-card">
                <h1>Login</h1>
                <p>Login to your account</p>
                <?php if (isset($error_message)): ?>
              <p style="margin: 0 0 20px 0; color: #FCB940; font-size: 20px; border: 1px solid #FCB940; padding: 4px; border-radius:50px; height:50px"><?php echo $error_message; ?></p>
              <?php endif; ?>
              <?php if (isset($_GET['verified'])): ?>
              <p style="color: green;"><?php echo 'Thanks for verifying please sign in'; ?></p>
              <?php endif; ?>
                <form method="POST" action="login_action.php">
                    <div class="inputs">
                        <input type="email" placeholder="Email" class="usps" name="email"><br>
                        <input type="password" placeholder="Password" class="usps" name="password"><br>
                    </div>
                    <div class="link">
                        <a href="forgetpass.php" class="links">Forgot password?</a>
                        <a href="signup.php" class="links">Don't have a account? Sign up</a><br>
                    </div>
                    <div class="submit">
                        <button type="submit" class="button">Login</button>
                </form>
            </div>
        </div>
    </section>

    <?php
include 'footer.php';
?>
</body>

</html>