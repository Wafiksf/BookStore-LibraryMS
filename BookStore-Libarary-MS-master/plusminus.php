<?php
include "connection.php";

session_start();
if (!isset($_SESSION['email'])) {
    header("location: login.php");
    exit();
}

$email = $_SESSION['email'];

if (isset($_GET['type']) && isset($_GET['ID']) && isset($_GET['status'])) {
    $type = $_GET['type'];
    $ID = $_GET['ID'];
    $purchaseOption = $_GET['status'];

    if ($purchaseOption == 'purchase') {
        $minQty = 1;
        if ($type == 'plus') {
            $sql = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.cart_qty = c.cart_qty + 1
            WHERE books.book_id = '$ID' AND c.cart_qty + 1 <= books.quantity AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
            $sqll = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.total = books.book_price * c.cart_qty
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            mysqli_query($connection, $sql);
            mysqli_query($connection, $sqll);

        if (mysqli_affected_rows($connection) === 0) {
            $bookName = "";
            $bookQuery = "SELECT book_name FROM books WHERE book_id = '$ID'";
            $bookResult = mysqli_query($connection, $bookQuery);
            
            if ($bookResult && mysqli_num_rows($bookResult) > 0) {
                $bookData = mysqli_fetch_assoc($bookResult);
                $bookName = $bookData['book_name'];
            }
            
            $_SESSION['msg'] = "The book '$bookName' is out of stock. You can't add more.";
        }
            header("location:cart.php");
        } elseif ($type == 'minus') {
            $sql = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.cart_qty = CASE WHEN c.cart_qty > $minQty THEN c.cart_qty - 1 ELSE $minQty END
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
            $sqll = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.total = books.book_price * c.cart_qty
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            mysqli_query($connection, $sql);
            mysqli_query($connection, $sqll);
            
            header("location:cart.php");
        }
    }

    if ($purchaseOption == 'borrow') {
        $minQty = 1;
        $maxQty = 1;
        if ($type == 'plus') {
            $sql = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.cart_qty = CASE WHEN c.cart_qty < $maxQty THEN c.cart_qty + 1 ELSE $maxQty END
            WHERE books.book_id = '$ID' AND c.cart_qty + 1 <= books.quantity AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
            $sqll = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.total = books.borrow_price * c.cart_qty
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            mysqli_query($connection, $sql);
            mysqli_query($connection, $sqll);
            header("location:cart.php");
        } elseif ($type == 'minus') {
            $sql = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.cart_qty = CASE WHEN c.cart_qty > $minQty THEN c.cart_qty - 1 ELSE $minQty END
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";
            $sqll = "UPDATE addcart c
            JOIN books ON c.cart_book_id = books.book_id 
            SET c.total = books.borrow_price * c.cart_qty
            WHERE books.book_id = '$ID' AND c.cart_user_email = '$email' AND status_book = '$purchaseOption'";

            mysqli_query($connection, $sql);
            mysqli_query($connection, $sqll);
            header("location:cart.php");
        }
    }
}
?>
