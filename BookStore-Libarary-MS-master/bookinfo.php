<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="css/bookinfo.css">
    <title>Book Info</title>
    <style>
        .star-yellow {
    color: #FFD700;
}
.rating {
  display: inline-block;
}

.rating input {
  display: none;
}

.rating label {
  float: right;
  color: #aaa;
}

.rating label:before {
  content: '\2605'; /* Unicode character for a star */
  font-size: 30px;
  padding: 5px;
}

.rating input:checked ~ label,
.rating input:checked ~ label ~ label {
  color: #ffcc00; /* Color for filled stars */
}


 

    </style>
</head>
<?php

?>
<body>
    <?php
    include 'connection.php';
    if (isset($_GET['bookid'])) {
        $bookId = $_GET['bookid'];
        $sql = "SELECT books.*, categories.category_name, authors.author_name
                FROM books
                JOIN categories ON books.category = categories.category_id
                JOIN author_books ON books.book_id = author_books.book_id
                JOIN authors ON author_books.author_id = authors.author_id
                WHERE books.book_id = '$bookId'";

        $result = mysqli_query($connection, $sql);
        $row = mysqli_fetch_array($result);
        $bookId = $row['book_id'];
        $bookname = $row['book_name'];
        $bookprice = $row['book_price'];
        $bookimage = $row['book_img'];
        $categoryname = $row['category_name'];
        $authorname = $row['author_name'];
        $description = $row['book_desc'];
        $quantity = $row['quantity'];
    }if (!isset($_GET['bookid'])) {
        header("location:books.php");
    }
    include 'header.php';
    ?>
    <div id="myModal2" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Would you like to buy or borrow the book?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="cart-option-form" method="POST" action="addcart_action.php">
                    <input type="hidden" id="modal-book-id" name="id" value="">
                    <input type="hidden" id="modal-qty" name="quantity" value="">
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
    <div class="cont">
        <div class="book-cont">
                <div class="main-img">
                    <img src="uploads/<?php echo $bookimage; ?>" alt="" width="318px" height="501px">
                </div>
            <div class="info-book col-sm-7">
                <div>
                    <h1 class="book-title"><?php echo $bookname; ?></h1>
                    <?php
                    if($quantity == 0){
                        echo '<p class="outstock">Out of stock</p>';
                    }else{
                        echo '<p class="stock">In stock</p>';
                    }
                    ?>
                </div>
                <div class="author">
                    <p><?php echo $authorname; ?></p>
                </div>
                <div class="price">
                    <h3><?php echo $bookprice; ?> $</h3>
                </div>
                <div class="btns row">
                    <div class="col-sm-2">
                        <input class="form-control" id="qty" value="1" min="1" max="100" type="number" placeholder="1">
                    </div>
                    <div class="col-sm-3">
                    <button type="button" class="btn btn-primary add-cart" id="btn-primarye" data-bs-toggle="modal" data-bs-target="#myModal2" data-bookid="<?php echo $bookId; ?>" onclick="setModalQuantity()">Add To Cart</button>
                    </div>
                    <div class="col-sm-1">
                    <form action="favorite_action.php" method="POST">
                      <input type="hidden" name="id" value="<?php echo $bookId; ?>">
                      <button class="btn btn-danger" id="btn-danger2"><i class="fa-solid fa-heart" style="color: white;"></i></button>
                    </form>
                    </div>
                    <div class="col-sm-3">
                    <a href="https://api.whatsapp.com/send?text=Check out this product: <?php echo urlencode($bookname); ?> - <?php echo urlencode($description); ?>. Link: <?php echo urlencode('https://booklibrary.com/bookinfo.php?bookid='.$bookId); ?>&phone=+96179126020" class="btn btn-success" id="wa" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
                <div class="infor">
                    <p><span class="bold-span">Author: </span><?php echo $authorname; ?></p>
                    <p><span class="bold-span">Category: </span><?php echo $categoryname; ?></p>
                    <p>Average Rating:</p>
    <?php
    // Calculate and display the average rating with stars
    $averageRating = "SELECT AVG(rating_value) AS totalrating FROM rating WHERE item_id='$bookId'";
   
    $avr = mysqli_query($connection, $averageRating);
    
    if (mysqli_num_rows($avr) > 0) {
        $rew = mysqli_fetch_array($avr);
        $roundedRating = $rew['totalrating'];
        $roundedRating = round($roundedRating);
    } else {
        $roundedRating = 0;
    }
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $roundedRating) {
            echo '<i class="fas fa-star star-yellow"></i>'; 
        } else {
            echo '<i class="far fa-star"></i>';
        }
    }
    
    ?>
                    
                </div>
            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
    <div class="cont2">
        <div class="details">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#details" id="nav-link">Details</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#reviews" id="nav-link">Reviews</a>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="details">
                    <h3>Description</h3>
                    <p><?php echo $description; ?></p>
                </div>
                <div class="tab-pane fade" id="reviews">
                    <h3>CUSTOMER REVIEWS</h3>
                    <?php
                    $se="SELECT * FROM rating WHERE item_id='$bookId' AND user_email='$email'";
                    $re=mysqli_query($connection,$se);
                    if (mysqli_num_rows($re)>0) {
                        $us=mysqli_fetch_assoc($re);
                        $user_has_rated=$us['rating_value'];
                    }else {
                        $user_has_rated=0;
                    }

?>
                    <form action="rating_action.php" method="POST">
  <fieldset class="rating">
    <input type="radio" id="star5" name="rating" value="5" onclick="submitRating(5, <?php echo $bookId; ?>)" <?php if ($user_has_rated == 5) echo 'checked'; ?> />
    <label class="full" for="star5"></label>
    <input type="radio" id="star4" name="rating" value="4" onclick="submitRating(4, <?php echo $bookId; ?>)" <?php if ($user_has_rated == 4) echo 'checked'; ?> />
    <label class="full" for="star4"></label>
    <input type="radio" id="star3" name="rating" value="3" onclick="submitRating(3, <?php echo $bookId; ?>)" <?php if ($user_has_rated == 3) echo 'checked'; ?> />
    <label class="full" for="star3"></label>
    <input type="radio" id="star2" name="rating" value="2" onclick="submitRating(2, <?php echo $bookId; ?>)" <?php if ($user_has_rated == 2) echo 'checked'; ?> />
    <label class="full" for="star2"></label>
    <input type="radio" id="star1" name="rating" value="1" onclick="submitRating(1, <?php echo $bookId; ?>)" <?php if ($user_has_rated == 1) echo 'checked'; ?> />
    <label class="full" for="star1"></label>
  </fieldset>
</form>

    
                    <div class="review">
                    <?php

$requete = "SELECT f.feedback_title, f.feedback_desc, CONCAT(r.db_fname, ' ', r.db_lname) AS user_name
            FROM feedback f
            INNER JOIN register r ON f.user_email = r.db_email
            WHERE f.book_id = $bookId
            ORDER BY f.id DESC
            LIMIT 3";

$resultat = mysqli_query($connection, $requete);

while ($ligne = mysqli_fetch_assoc($resultat)) {
    echo "<h4>" . $ligne['feedback_title'] . "</h4>";
    echo "<p>" . $ligne['feedback_desc'] . "</p>";
    echo "<p><strong>by: " . $ligne['user_name'] . "</strong></p>";
    echo "<hr>"; 
}

mysqli_close($connection);
?>
                    <form action="feedback_action.php" method="POST">
                            <label for="">Title *</label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Title review">
                            <label for="">Review *</label>
                            <textarea name="review" id="review" cols="30" rows="10"class="form-control" placeholder="review"></textarea>
                            <input type="hidden" name="idd" value="<?php echo $bookId; ?>">
                            <br>
                            <button type="submit" class="btn btn-secondary">Leave A Review</button>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
    <?php
include 'footer.php';
?>
    <script src="js/info.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    
    <script>
        function submitRating(ratingValue, bookId) {
    $.ajax({
        url: 'rating_action.php',
        type: 'POST',
        data: {
            rating: ratingValue,
            book_id: bookId
        }});
  window.location.href = 'bookinfo.php?bookid='+bookId;
}
    </script>
</body>

</html>