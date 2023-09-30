<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/footer.css">
    <title>Document</title>
</head>
<body>
    <footer class="footer">
        <section class="first-part">
            <div class="footer-logo">
                <h1>BOOK<span>STORE</span></h1>
            </div>
            <div class="footer-text">
                <div class="footer-title">
                    <h3>Discover</h3>
                    <ul>
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="books.php">BOOKS</a></li>
                        <li><a href="reservation.php">ROOMS</a></li>
                    </ul>
                </div>
                <div class="footer-title">
                    <h3>My Account</h3>
                    <ul>
                        <?php if(isset($_SESSION["email"])) { ?>
                        <li><a href="logout.php">LOGOUT</a></li>
                        <li><a href="cart.php">VIEW CART</a></li>
                        <li><a href="favorite.php">MY WISHLIST</a></li>
                        <?php } else { ?>
                        <li><a href="login.php">SIGN IN</a></li>
                        <li><a href="login.php">VIEW CART</a></li>
                        <li><a href="login.php">MY WISHLIST</a></li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="footer-title">
                    <h3>Who We Are</h3>
                    <ul>
                        <li><a href="aboutus.php">ABOUT US</a></li>
                        <li><a href="contactus.php">CONTACT US</a></li>
                        <li><a href="#">DONATE</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <hr class="my-hr">
        <section class="second-part">
            <p class="footer-title2">© 2023 <span>BOOK STORE.</span> All rights reserved.</p>
            <div class="social-icons">
                <a href="#" class="tw"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="in"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="fb"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="tt"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#" class="wa"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
        </section>
    </footer>
</body>
</html>