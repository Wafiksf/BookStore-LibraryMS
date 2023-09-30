<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books</title>
    <link rel="stylesheet" href="css/books.css">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
  </head>
<body>
<div id="myModal" class="modal">
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
                        <label class="form-check-label" for="purchase" style="color: #1886a9;">Purchase</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="purchase_option" id="borrow" value="borrow">
                        <label class="form-check-label" for="borrow" style="color: #1886a9;">Borrow</label>
                    </div>
                    <br>
                    <button type="submit" name="submit" class="btn btn-primary" style="background-color: #1886a9; border-color: #1886a9;">Add to cart</button>
                </form>
            </div>
        </div>
    </div>
</div>


<?php
include 'header.php';
if (isset($_GET['search'])) {
    $search=$_GET['search'];
?>

<div class="container">
  <div class="row justify-content-center">
    
    <?php
    include 'connection.php';
    
    $sql = "SELECT * FROM books b
    JOIN author_books a ON a.book_id=b.book_id
    JOIN authors s ON s.author_id=a.author_id 
    JOIN categories c ON c.category_id=b.category
    WHERE b.book_name LIKE '%$search%' OR s.author_name LIKE '%$search%'OR c.category_name LIKE '%$search%'";
    $result = mysqli_query($connection, $sql);
    if (mysqli_num_rows($result) == 0) {
        echo '<div class="d-flex justify-content-center align-items-center flex-column">
        <i class="big-face fa-regular fa-face-frown-open"></i>
        <h1 class="face-h1">Oops!</h1>
        <p class="face-p">No Books Found.</p>
        </div>';
    }else{

    $colors = array('--blue' => '#1886a9', '--red' => '#C12E2A', '--yellow' => '#FCB940');
    $counter = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $bookId = $row['book_id'];
    $image = $row['book_img'];
    $title = $row['book_name'];
    $price = $row['book_price'];
    $author = $row['author_name'];

    $currentColor = array_keys($colors)[$counter % count($colors)];

    $class = 'book-' . str_replace('--', '', $currentColor);
    
    echo '<div class="col-lg-2 book d-flex flex-column justify-content-center align-items-center ' . $class . '">';
    echo '<a href="bookinfo.php?bookid=' . $bookId . '"><img src="uploads/' . $image . '" alt="' . $title . '" width="150px" height="250px"></a>';
    echo '<div class="title"><h4>' . $title . '</h4></div>';
    echo '<div class="author">by ' . $author . '</div>';
    echo '<div class="price">' . $price . ' $ </div>';
    echo '<br>';
    echo '<div class="btns-div">';
    echo '<form action="favorite_action.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $bookId . '">';
    echo '<button type="submit" class="book-icon"><i class="fa-solid fa-heart col-3 book-icon"></i></button>';
    echo '</form>';
    echo '<button type="button" class="book-icon cart-plus-btn" data-bs-toggle="modal" data-bs-target="#myModal" data-bookid="' . $bookId . '"><i class="fa-solid fa-cart-plus col-3 book-icon"></i></button>';
    echo '</div>';
    echo '</div>';

    $counter++;
}
    }
mysqli_close($connection);
?>
  
</div>
</div>

<?php
}else{
?>

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
<div class="container">
  <div class="row justify-content-center">
    <?php
    include 'connection.php';
    
    
    $sql = "SELECT books.*, authors.author_name
            FROM books
            JOIN author_books ON books.book_id = author_books.book_id
            JOIN authors ON author_books.author_id = authors.author_id";
    $result = mysqli_query($connection, $sql);

    $colors = array('--blue' => '#1886a9', '--red' => '#C12E2A', '--yellow' => '#FCB940');
    $counter = 0;

while ($row = mysqli_fetch_assoc($result)) {
    $bookId = $row['book_id'];
    $image = $row['book_img'];
    $title = $row['book_name'];
    $price = $row['book_price'];
    $author = $row['author_name'];

    $currentColor = array_keys($colors)[$counter % count($colors)];

    $class = 'book-' . str_replace('--', '', $currentColor);

    echo '<div class="col-lg-2 book d-flex flex-column justify-content-center align-items-center ' . $class . '">';
    echo '<a href="bookinfo.php?bookid=' . $bookId . '"><img src="uploads/' . $image . '" alt="' . $title . '" width="150px" height="250px"></a>';
    echo '<div class="title"><h4>' . $title . '</h4></div>';
    echo '<div class="author">by ' . $author . '</div>';
    echo '<div class="price">' . $price . ' $ </div>';
    echo '<br>';
    echo '<div class="btns-div">';
    echo '<form action="favorite_action.php" method="post">';
    echo '<input type="hidden" name="id" value="' . $bookId . '">';
    echo '<button type="submit" class="book-icon"><i class="fa-solid fa-heart col-3 book-icon"></i></button>';
    echo '</form>';
    echo '<button type="button" class="book-icon cart-plus-btn" data-bs-toggle="modal" data-bs-target="#myModal" data-bookid="' . $bookId . '"><i class="fa-solid fa-cart-plus col-3 book-icon"></i></button>';
    echo '</div>';
    echo '</div>';

    $counter++;
}
mysqli_close($connection);
?>
  
</div>
</div>
<?php
}
?>
<?php
include 'footer.php';
?>
<script src="js/books.js"></script>

</body>
</html>