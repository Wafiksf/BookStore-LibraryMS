<?php
include 'connection.php';
session_start();

if (!isset($_SESSION['email'])) {
    header("location: login.php");
    exit();
}

$bookId = $_POST['id'];
$email = $_SESSION['email'];
$purchaseOption = $_POST['purchase_option'];

if(isset($_POST['quantity'])){
    $qty = $_POST['quantity'];
    if ($qty <= 0){
        $_SESSION['msg'] = "Quantity must be a positive value!";
        header('Location: books.php');
        exit();
    }
}else{
    $qty = 1;
}

if ($purchaseOption == 'purchase') {
    $sql = "SELECT * FROM books
            JOIN addcart c ON c.cart_book_id = books.book_id 
            WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $bookQuantityQuery = "SELECT quantity FROM books WHERE book_id = '$bookId'";
        $bookQuantityResult = mysqli_query($connection, $bookQuantityQuery);
        $bookQuantityRow = mysqli_fetch_assoc($bookQuantityResult);
        $bookQuantity = $bookQuantityRow['quantity'];

        $bookQuantityQueryy = "SELECT SUM(cart_qty) AS fullcart FROM addcart WHERE cart_user_email='$email' AND cart_book_id='$bookId'";
        $bookQuantityResultt = mysqli_query($connection, $bookQuantityQueryy);
        $bookQuantityRoww = mysqli_fetch_assoc($bookQuantityResultt);
        $bookQuantittyy = $bookQuantityRoww['fullcart'];

        if ($bookQuantittyy >= $bookQuantity) {
            $_SESSION['msg'] = "Quantity exceeds available stock.";
            header('Location: books.php');
            exit();
        }

        if ($qty > $bookQuantity) {
            $_SESSION['msg'] = "Quantity exceeds available stock.";
            header('Location: books.php');
            exit();
        }

        $sql = "UPDATE addcart c
                JOIN books ON c.cart_book_id = books.book_id 
                SET c.cart_qty = c.cart_qty + $qty
                WHERE books.book_id = '$bookId' AND c.cart_qty < books.quantity AND c.cart_user_email = '$email'  AND status_book = '$purchaseOption'";
        $sqll = "UPDATE addcart c
                 JOIN books ON c.cart_book_id = books.book_id 
                 SET c.total = books.book_price * c.cart_qty
                 WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
    } else {
        $bookQuantityQuery = "SELECT quantity FROM books WHERE book_id = '$bookId'";
        $bookQuantityResult = mysqli_query($connection, $bookQuantityQuery);
        $bookQuantityRow = mysqli_fetch_assoc($bookQuantityResult);
        $bookQuantity = $bookQuantityRow['quantity'];

        if ($bookQuantity > 0) {
            if ($qty > $bookQuantity) {
                $_SESSION['msg'] = "Quantity exceeds available stock.";
                header('Location: books.php');
                exit();
            }

            $sql = "INSERT INTO addcart (cart_book_id, cart_user_email, cart_qty, status_book) VALUES ('$bookId', '$email', '$qty', '$purchaseOption')";
            $sqll = "UPDATE addcart c
                     JOIN books ON c.cart_book_id = books.book_id 
                     SET c.total = books.book_price * c.cart_qty
                     WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            $_SESSION['msg'] = "Added to cart!";
        } else {
            $_SESSION['msg'] = "Out of stock.";
            header('Location: books.php');
            exit();
        }
    }

    mysqli_query($connection, $sql);
    mysqli_query($connection, $sqll);
}


if ($purchaseOption == 'borrow') {
    $sql = "SELECT * FROM books
        JOIN addcart c ON c.cart_book_id = books.book_id 
        WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
$bookQuantityQuery = "SELECT quantity FROM books WHERE book_id = '$bookId'";
$bookQuantityResult = mysqli_query($connection, $bookQuantityQuery);
$bookQuantityRow = mysqli_fetch_assoc($bookQuantityResult);
$bookQuantity = $bookQuantityRow['quantity'];

$bookQuantityQueryy = "SELECT SUM(cart_qty) AS fullcart FROM addcart WHERE cart_user_email='$email' AND cart_book_id='$bookId'";
$bookQuantityResultt = mysqli_query($connection, $bookQuantityQueryy);
$bookQuantityRoww = mysqli_fetch_assoc($bookQuantityResultt);
$bookQuantittyy = $bookQuantityRoww['fullcart'];

    if ($bookQuantittyy >= $bookQuantity) {
        $_SESSION['msg'] = "Quantity exceeds available stock.";
        header('Location: books.php');
        exit();
    }
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) > 0) {
        $sql1 = "UPDATE addcart c
                JOIN books ON c.cart_book_id = books.book_id 
                SET c.cart_qty = 1
                WHERE books.book_id = '$bookId' AND c.cart_qty < books.quantity AND c.cart_user_email = '$email'  AND status_book = '$purchaseOption'";
        $sqll1 = "UPDATE addcart c
                 JOIN books ON c.cart_book_id = books.book_id 
                 SET c.total = books.borrow_price * c.cart_qty
                 WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
    } else {
        $bookQuantityQuery = "SELECT quantity FROM books WHERE book_id = '$bookId'";
        $bookQuantityResult = mysqli_query($connection, $bookQuantityQuery);
        $bookQuantityRow = mysqli_fetch_assoc($bookQuantityResult);
        $bookQuantity = $bookQuantityRow['quantity'];

        if ($bookQuantity > 0) {
            $sql1 = "INSERT INTO addcart (cart_book_id, cart_user_email, cart_qty, status_book) VALUES ('$bookId', '$email', 1 ,'$purchaseOption')";
            $sqll1 = "UPDATE addcart c
                      JOIN books ON c.cart_book_id = books.book_id 
                      SET c.total = books.borrow_price * c.cart_qty
                      WHERE books.book_id = '$bookId' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            $_SESSION['msg'] = "Added to cart!";
        } else {
            $_SESSION['msg'] = "You can't add more, it's out of stock.";
            header('Location: books.php');
            exit();
        }
    }
    mysqli_query($connection, $sql1);
    mysqli_query($connection, $sqll1);
}

mysqli_close($connection);
header('Location: books.php');
?>