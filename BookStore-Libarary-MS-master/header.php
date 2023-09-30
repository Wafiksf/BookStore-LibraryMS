<!DOCTYPE html>
<html lang="en">

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'connection.php';
require 'emailwarning.php';
if (isset($_SESSION["email"])) {
    $email = $_SESSION["email"];

    $sql = "SELECT db_fname, db_lname, role FROM register WHERE db_email='$email'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Store the values in variables
        $fname = $row['db_fname'];
        $lname = $row['db_lname'];
        $role=$row['role'];
        $_SESSION['role']=$role;

    } else {
        echo "No matching record found.";
    }
}
?>


<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Header</title>
</head>
<body>
    <header>
        <section class="head-top">
            <div class="top-icons">
                <a href="#" class="tw"><i class="fa-brands fa-twitter"></i></a>
                <a href="#" class="in"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" class="fb"><i class="fa-brands fa-facebook"></i></a>
                <a href="#" class="tt"><i class="fa-brands fa-tiktok"></i></a>
                <a href="#" class="wa"><i class="fa-brands fa-whatsapp"></i></a>
            </div>
            <nav class="nav-top">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa-solid fa-user fa-user-e"></i>
                </a>

                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <?php if(isset($_SESSION["email"])) { ?>
        <li>
            <a class="dropdown-item"><b><?php echo $fname . ' ' . $lname; ?></b></a>
        </li>
        <li>
            <a class="dropdown-item" href="edit_profile.php"><i class="fa-solid fa-edit"></i>My Profile</a>
        </li>
            <?php if($_SESSION["role"]==1) { ?>
            <li>
                        <a class="dropdown-item" href="dashboard/index.php"><i class="fas fa-chart-pie"></i>Admin Pannel</a>
                    </li>
                    <?php }?>
        <li>
            <a class="dropdown-item" href="logout.php"><i class="fa-solid fa-arrow-right-to-bracket"></i>Logout</a>
        </li>
    <?php } else { ?>
        <li>
            <a class="dropdown-item" href="login.php"><i class="fa-solid fa-arrow-right-to-bracket"></i>LOGIN</a>
        </li>
        <li>
            <a class="dropdown-item" href="signup.php"><i class="fa-solid fa-user-plus"></i>SIGN UP</a>
        </li>
    <?php } ?>
                </ul>
                <?php if(isset($_SESSION["email"])) { ?>
                    <a href="favorite.php"><i class="fa-solid fa-heart fa-heart-e"></i></a>
                    <a href="cart.php"><i class="fa-solid fa-cart-shopping fa-cart-shopping-e"></i></a>
                <?php } else { ?>
                    <a href="login.php"><i class="fa-solid fa-heart fa-heart-e"></i></a>
                    <a href="login.php"><i class="fa-solid fa-cart-shopping fa-cart-shopping-e"></i></a>
                <?php } ?>
                <a href="#" class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                    data-bs-toggle="dropdown" aria-expanded="false"><i
                        class="fa-solid fa-magnifying-glass"></i>SEARCH</a>
                <div class="dropdown-menu p-3" aria-labelledby="searchDropdown">
                <form action="books.php" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control search-input" name="search" placeholder="Search...">
                        <button class="btn btn-primary search-btn" type="submit"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                    </form>
                </div>
            </nav>
        </section>
        <hr class="my-hr none-hr">
        <section class="head-down">
            <div class="logo">
            <a href="index.php" class="logo-title"><h1>BOOK<span>STORE</span></h1></a>
            </div>
            <div class="hamburger">
                <div class="line"></div>
                <div class="line"></div>
                <div class="line"></div>
            </div>
            <nav class="nav-bar">
                <ul>
                    <li>
                        <a href="books.php">SHOP</a>
                    </li>
                    <li>
                        <a href="reservation.php" class="active">ROOMS</a>
                    </li>
                    <li>
                        <a href="contactus.php">CONTACT US</a>
                    </li>
                    <li>
                        <a href="aboutus.php">ABOUT US</a>
                    </li>
                </ul>
            </nav>
        </section>
    </header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/header.js"></script>
</body>
</html>