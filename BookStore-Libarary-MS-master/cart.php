<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/cart.css">
    <title>My Cart</title>
</head>

<body>
<?php
include 'header.php';
?>

<section class="add-cart-section">
<?php
include 'connection.php';

$email = $_SESSION['email'];
$sql = "SELECT b.book_id, b.book_img, b.book_name, b.book_price, b.borrow_price, c.cart_qty, c.total, c.cart_id, c.status_book
        FROM addcart c
        JOIN books b ON c.cart_book_id = b.book_id WHERE cart_user_email='$email'";
$result = mysqli_query($connection, $sql);
?>

<div class="col-10">
<div class="themsg">
<?php
if (isset($_SESSION["msg"])) {
  $msg = $_SESSION["msg"];
  unset($_SESSION["msg"]);
     echo '<p class="msgcolor">' . $msg . '</p>';
    } else {
        $msg = "";
      }
     ?>
</div>
    <?php
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="d-flex justify-content-center align-items-center flex-column">
        <i class="big-cart fa-solid fa-cart-shopping fa-bounce"></i>
        <h1 class="cart-h1">Your cart is currently empty</h1>
        <p class="cart-p">Before proceed to checkout, you must add some books to your cart.<br>
        You will find a lot of interesting books on our "Shop" page.</p>
        <a class="btn" id="cart-btn" href="http://localhost/lms/books.php"><i class="fa-solid fa-cart-shopping" style="color: #fff;"></i>RETURN TO SHOP</a>
        </div>';
    } else {
        echo '<h1 class="d-flex justify-content-center">Your Cart</h1><br>';
        echo '<table class="table text-center align-middle">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Image</th>';
        echo '<th>Title</th>';
        echo '<th>For</th>';
        echo '<th>Price</th>';
        echo '<th>Quantity</th>';
        echo '<th>Total</th>';
        echo '<th>Edit</th>';
        echo '<th>Action</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        $purchaseTotal = 0;
        $borrowTotal = 0;
        $overallTotal = 0;

        while ($row = mysqli_fetch_array($result)) {
            $image = $row['book_img'];
            $title = $row['book_name'];
            $itemId = $row['cart_id'];
            $quantity = $row['cart_qty'];
            $bookId = $row['book_id'];

            // Get the correct price based on status
            $status = $row['status_book'];
            $price = ($status == 'purchase') ? $row['book_price'] : $row['borrow_price'];
            $total = $row['total'];

            if ($status == 'purchase') {
                $purchaseTotal += $total;
            } else {
                $borrowTotal += $total;
            }

            $overallTotal += $total;

            echo '<tr>';
            echo '<td><img src="uploads/' . $image . '" alt="' . $title . '" width="100px"></td>';
            echo '<td>' . $title . '</td>';
            echo '<td>' . $status . '</td>';
            echo '<td>' . $price . ' $</td>';
            echo '<td>' . $quantity . '</td>';
            echo '<td>$' . $total . '</td>';
            echo '<td>
                <a class="btn btn-secondary" id="btn-secondaryp" href="plusminus.php?type=plus&ID=' . $row['book_id'] . '&status=' . $row['status_book'] . '"><i class="fa-solid fa-plus"></i></a>
                <a class="btn btn-secondary" id="btn-secondarym" href="plusminus.php?type=minus&ID=' . $row['book_id'] . '&status=' . $row['status_book'] . '"><i class="fa-solid fa-minus"></i></a>
            </td>';
            echo '<td class="btns">
                <form method="POST" action="deletecart_action.php">
                    <input type="hidden" name="cart_id" value="' . $itemId . '">
                    <button type="submit" name="delete" class="btn btn-danger" id="btn-danger3"><i class="fa-solid fa-trash"></i></button>
                </form>
            </td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '<div style="text-align: right;">';
        echo '<p><b>Purchase Total:  </b>' . $purchaseTotal . ' $</p>';
        echo '<p><b>Borrow Total:  </b>' . $borrowTotal . ' $</p>';
        echo '<p><b>Overall Total:  </b>' . $overallTotal . ' $</p>';
        echo '<a href="invoice.php" class="btn btn-primary" id="btn-primary3">Checkout</a>';
        echo '</div>';
    }
    ?>
</div>

<?php
mysqli_close($connection);
?>

</section>
<?php
include 'footer.php';
?>
</body>

</html>
