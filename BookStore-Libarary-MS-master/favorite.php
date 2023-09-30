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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/books.css">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <title>Favorite</title>
</head>
<body>
    <?php
include 'header.php';
?>
<div id="myModal3" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Would you like to buy or borrow the book?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cart-option-form" method="POST" action="addcart_action.php">
                    <input type="hidden" id="modal-book-id" name="id" value="">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="purchase_option" id="purchase" value="purchase" checked>
                        <label class="form-check-label" for="purchase" style="color: #1886a9;">buy</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="purchase_option" id="borrow" value="borrow">
                        <label class="form-check-label" for="borrow" style="color: #1886a9;">borrow</label>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary" style="background-color: #1886a9; border-color: #1886a9;">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="container">
  <div class="row justify-content-center">
    <?php
    include 'connection.php';
    $email=$_SESSION['email'];

    $sql = "SELECT b.*, f.fav_id, a.author_name
            FROM favorite f
            JOIN books b ON f.fav_book_id = b.book_id 
            JOIN author_books ab ON b.book_id = ab.book_id
            JOIN authors a ON ab.author_id = a.author_id
            WHERE fav_user_email='$email'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 0) {
      echo '<div class="d-flex justify-content-center align-items-center flex-column">
      <i class="big-heart fa-regular fa-heart fa-beat-fade"></i>
      <h1 class="heart-h1">Add books to your favorites</h1>
      <p class="heart-p">You haven\'t added any book to your favorites yet.</p>
      </div>';
    } else {
      echo '<div class="col-lg-12 mb-5">';
      echo '<h1 class="d-flex align-items-center">Your favorites books</h1>';
      echo '<hr>';
      echo '</div>';

      $colors = array('--blue' => '#1886a9', '--red' => '#C12E2A', '--yellow' => '#FCB940');

      $counter = 0;

$user_id = 0;

if ($connection) {
    $registerSql = "SELECT user_id FROM register";
    $registerResult = mysqli_query($connection, $registerSql);

    if ($registerResult && mysqli_num_rows($registerResult) > 0) {
        $registerRow = mysqli_fetch_assoc($registerResult);
        $user_id = $registerRow['user_id'];
    }
}
      while ($row = mysqli_fetch_assoc($result)) {
        $bookId = $row['book_id'];
        $image = $row['book_img'];
        $title = $row['book_name'];
        $author = $row['author_name'];
        $price = $row['book_price'];
        $itemId = $row['fav_id']; 

        $currentColor = array_keys($colors)[$counter % count($colors)];

        $class = 'book-' . str_replace('--', '', $currentColor);

        echo '<div class="col-lg-2 book d-flex flex-column justify-content-center align-items-center ' . $class . '">';
        echo '<a href="bookinfo.php?bookid=' . $bookId . '"><img src="uploads/' . $image . '" alt="' . $title . '" width="150px" height="250px"></a>';
        echo '<h4 class="title">' . $title . '</h4>';
        echo '<div class="author">by ' . $author . '</div>';
        echo '<h5 class="price">' . $price . ' $ </h5>';
        echo '<br>';
        echo '<div class="btns-div">';
        echo '<form action="deletefav_action.php" method="post">';
        echo '<input type="hidden" name="fav_id" value="' . $itemId . '">';
        echo '<button type="submit" class="book-icon" name="delete"><i class="fa-solid fa-trash col-3 book-icon"></i></button>';
        echo '</form>';
        echo '<button type="button" class="book-icon cart-plus-btn2" data-bs-toggle="modal" data-bs-target="#myModal3" data-bookid="' . $bookId . '"><i class="fa-solid fa-cart-plus col-3 book-icon"></i></button>';
        echo '</div>';
        echo '</div>';

        $counter++;
      }
    }

    mysqli_close($connection);
    ?>
  </div>
</div>
<script src="js/favorite.js"></script>

<?php
include 'footer.php';
?>
</body>
</html>