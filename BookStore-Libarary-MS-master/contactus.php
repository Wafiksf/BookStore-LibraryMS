<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    session_start();
    $email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
    $name = $_POST["name"];
    $emailentred = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    if ($emailentred != $email) {
        $msg = "Please login first";
    } else {
        $stmt = $connection->prepare("INSERT INTO contactus (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $subject, $message);
        $stmt->execute();

        $msg1 = "Thank you for your message! We will get back to you shortly.";

        $stmt->close();
        mysqli_close($connection);
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/contactus.css">
    <title>ContactUs</title>
</head>
<body>
<?php
include 'header.php';
?>
    <div class="lufy">
    <div>
        <h1>Contact</h1>
        <p>Feel free to reach out to us anytime!</p>
        <?php if (isset($msg)): ?>
              <p style="color: red; font-weight: bold;"><?php echo $msg; ?></p>
        <?php endif; ?>
        <?php if (isset($msg1)): ?>
              <p style="color: green; font-weight: bold;"><?php echo $msg1; ?></p>
        <?php endif; ?>
    </div>
    </div>
    <div class="cent">
    <div class="one-pice">
        <div class="zoro">
            <h2>Get In Touch</h2>
            <p>We're here to help! Don't hesitate to get in touch with us.</p>
            <div class="ror">
                <i class="fa-solid fa-envelope fa-shake"></i>
                <a href="bookshop@gmail.com">bookstore@gmail.com</a>
            </div>
        </div>
        <hr class="contact-hr">
        <div class="sanji">
            <form method="POST" action="">
                <div class="cent">
                <label for="name">Send Us a Message</label>
                <input type="text" class="cont-input" id="name" name="name" placeholder="Your Name" required>
                <input type="email" class="cont-input" id="email" name="email" placeholder="Email" required>
                <input type="text" class="cont-input" id="subject" name="subject" placeholder="Subject" required>
                <textarea placeholder="Message" name="message" required></textarea><br>
                </div>
                <div class="center-btn">
                   <button type="submit">Send Message</button>
                </div>
            </form>
        </div>
        <div class="usop">
            <h3>Follow Us</h3>
            <div>
            <i class="fa-brands fa-facebook"></i>
            <i class="fa-brands fa-instagram"></i>
            <i class="fa-brands fa-twitter"></i>
            </div>
        </div>
    </div>
</div>
    <?php
include 'footer.php';
?>
</body>
</html>