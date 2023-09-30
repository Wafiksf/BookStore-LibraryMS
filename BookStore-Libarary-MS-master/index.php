<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/Logo1.png" type="image/x-icon">
    <link rel="stylesheet" href="path/to/font-awesome/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.css'>
    <link rel="stylesheet" href="css/home.css">
    <title>Welcome To BOOKSTORE</title>
</head>

<body>
<?php
require 'connection.php';

include 'header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['rating']) && isset($_POST['bookid']) && isset($_SESSION['email'])) {
        $ratingValue = $_POST['rating'];
        $bookId = $_POST['bookid'];
        $email=$_SESSION['email'];
        // Check if the user has already rated the book
        $existingRatingQuery = "SELECT * FROM rating WHERE item_id = '$bookId' AND user_email='$email'";
        $existingRatingResult = mysqli_query($connection, $existingRatingQuery);
        $numRows = mysqli_num_rows($existingRatingResult);

        if ($numRows > 0) {
            // Update the existing rating
            $updateRatingQuery = "UPDATE rating SET rating_value = '$ratingValue' WHERE item_id = '$bookId' AND user_email='$email'";
            mysqli_query($connection, $updateRatingQuery);
        } else {
            // Insert a new rating
            $insertRatingQuery = "INSERT INTO rating (item_id, rating_value,user_email) VALUES ('$bookId', '$ratingValue','$email')";
            mysqli_query($connection, $insertRatingQuery);
        }
    
    }
    else {
        header("location:login.php");
    }
}
?>
    <section class="main">
        <div class="first-sec">
            <div class="books-for-all">
                <div class="title_cont">
                    <div class="B_F">
                        <p>
                            B
                        </p>
                        <p>
                            F
                        </p>
                    </div>
                    <div class="O" class="color-changing-div"></div>
                    <div class="O_R">
                        <p>
                            O
                        </p>
                        <p>
                            R
                        </p>
                    </div>
                    <div class="K_ALL">
                        <p>
                            KS
                        </p>
                        <p class="ALL">
                            ALL
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $sql = "SELECT * FROM home";
    $result = mysqli_query($connection,$sql);
    $row=mysqli_fetch_assoc($result);
$category=$row['category_name'];

                
    ?>
    <hr class="hr-divid"> 
    <section class="donation-section">
    <div class="donation-content">
        <?php include 'connection.php';
        $sqll="SELECT SUM(totalAmount) as rent FROM payment WHERE paymentType='borrow'";
        $rslt=mysqli_query($connection,$sqll);
        $roww=mysqli_fetch_assoc($rslt);
        $rent=$roww['rent']; ?>
        <h1 class="donation-title" style="color :#1886a9;">Donations</h1>
        <p class="thank-you-message">Thank you all for your contributions!</p>
        <p class="donation-line">We have received a total of <span style="color :#1886a9;"><?php echo $rent?> $</span> .</p>
    </div>
   </section>
   <hr class="hr-divid"> 
    <section class="description">
        <div class="left-part">
            <div class="left-img">
                <img src="uploads/<?php echo $row['db_image1']   ?>" alt="photo" width="500px">
            </div>
        </div>
        <div class="right-part">
            <div class="text-cont">
                <?php
                echo $row['db_text1'];
                ?>
            </div>
        </div>
    </section>

    <hr class="hr-divid">

    <section class="slider-cont">
        <h2 class="title">Whats New</h2>
        <div class="book-slide">
            <div class="book js-flickity"
                data-flickity-options='{ "wrapAround": true, "autoPlay": 2000, "pauseAutoPlayOnHover": false }'>
               <?php
            $sq = "SELECT * FROM books b 
            INNER JOIN author_books a ON
            b.book_id=a.book_id
            INNER JOIN authors aa ON
            aa.author_id=a.author_id
            INNER JOIN categories c ON 
            c.category_id=b.category
            ORDER BY date DESC LIMIT 6";

            $r=mysqli_query($connection,$sq);
           while ($re=mysqli_fetch_assoc($r)) {
            $id=$re['book_id'];
            $rat= "SELECT COUNT(DISTINCT user_email) AS user_count FROM rating WHERE item_id = '$id'";

            $rati=mysqli_query($connection,$rat);
            $rating=mysqli_fetch_assoc($rati);

            $fullrate="SELECT ROUND(AVG(rating_value)) AS users_value FROM rating WHERE item_id='$id'";
            $full=mysqli_query($connection,$fullrate);
            $ful=mysqli_fetch_assoc($full);
            $user_has_rated=$ful['users_value'];
        ?>
            <div id="book_<?php echo $re['book_id']; ?>" class="book-cell">
                <div class="book-img">
                    <img src="uploads/<?php echo $re['book_img'] ?>" alt="" class="book-photo">
                </div>
                <div class="book-content">
                    <div class="book-title"><?php echo $re['book_name'] ?></div>
                    <div class="book-author">by <?php echo $re['author_name'] ?></div>
                    <form method="POST" action="index.php">
                        <div class="rate">
                        <fieldset class="rating red">
    <input type="checkbox" id="star5_<?php echo $re['book_id']; ?>" name="rating" value="5" <?php if ($user_has_rated == 5) echo 'checked'; ?> disabled />
    <label class="full" for="star5_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star4_<?php echo $re['book_id']; ?>" name="rating" value="4" <?php if ($user_has_rated == 4) echo 'checked'; ?> disabled />
    <label class="full" for="star4_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star3_<?php echo $re['book_id']; ?>" name="rating" value="3" <?php if ($user_has_rated == 3) echo 'checked'; ?> disabled />
    <label class="full" for="star3_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star2_<?php echo $re['book_id']; ?>" name="rating" value="2" <?php if ($user_has_rated == 2) echo 'checked'; ?> disabled />
    <label class="full" for="star2_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star1_<?php echo $re['book_id']; ?>" name="rating" value="1" <?php if ($user_has_rated == 1) echo 'checked'; ?> disabled />
    <label class="full" for="star1_<?php echo $re['book_id']; ?>"></label>
</fieldset>


                            <span class="book-voters"><?php if (isset($rating['user_count'])){
                            echo $rating['user_count'];    
                        }else {
                               echo 0;
                            } ?> voters</span>
                        </div>
                        </form>
                        <div class="book-sum"><?php echo $re['book_desc'] ?>
                             </div>
                             <a href="bookinfo.php?bookid=<?php echo $re['book_id']; ?>">
    <div class="book-see">See The Book</div>
</a>
           </div>
                </div>
               <?php } ?>
        </div>
    </section>

    <hr class="hr-divid">

    <section class="description1">
        <div class="left-part1">
            <div class="text-cont1">
            <?php echo $row['db_text2']?>       
        </div>
        </div>
        <div class="right-part1">
            <div class="right-img1">
                <img src="uploads/<?php echo $row['db_image2']   ?>" alt="photo" width="500px">
            </div>
        </div>
    </section>

    <hr class="hr-divid">

    <section class="slider-cont" id="trending">
        <h2 class="title">Trending Now</h2>
        <div class="book-slide">
            <div class="book js-flickity"
                data-flickity-options='{ "wrapAround": true, "autoPlay": 2000, "pauseAutoPlayOnHover": false }'>
               <?php
               
               
            $sq = "SELECT * FROM books b 
            INNER JOIN author_books a ON
            b.book_id=a.book_id
            INNER JOIN authors aa ON
            aa.author_id=a.author_id
            INNER JOIN categories c ON 
            c.category_id=b.category
            WHERE c.category_name='$category' LIMIT 6";

            $r=mysqli_query($connection,$sq);
           while ($re=mysqli_fetch_assoc($r)) {
            $id=$re['book_id'];
            $rat= "SELECT COUNT(DISTINCT user_email) AS user_count FROM rating WHERE item_id = '$id'";

            $rati=mysqli_query($connection,$rat);
            $rating=mysqli_fetch_assoc($rati);

            $fullrate="SELECT ROUND(AVG(rating_value)) AS users_value FROM rating WHERE item_id='$id'";
            $full=mysqli_query($connection,$fullrate);
            $ful=mysqli_fetch_assoc($full);
            $user_has_rated=$ful['users_value'];
        ?>
            <div class="book-cell" id="book_<?php echo $re['book_id']; ?>">
  <div class="book-img">
    <img src="uploads/<?php echo $re['book_img'] ?>" alt="" class="book-photo">
  </div>
  <div class="book-content">
    <div class="book-title"><?php echo $re['book_name'] ?></div>
    <div class="book-author">by <?php echo $re['author_name'] ?></div>
    <form method="POST" action="index.php">
      <div class="rate">
      <fieldset class="rating">
    <input type="checkbox" id="star5_<?php echo $re['book_id']; ?>" name="rating" value="5" <?php if ($user_has_rated == 5) echo 'checked'; ?> disabled />
    <label class="full" for="star5_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star4_<?php echo $re['book_id']; ?>" name="rating" value="4" <?php if ($user_has_rated == 4) echo 'checked'; ?> disabled />
    <label class="full" for="star4_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star3_<?php echo $re['book_id']; ?>" name="rating" value="3" <?php if ($user_has_rated == 3) echo 'checked'; ?> disabled />
    <label class="full" for="star3_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star2_<?php echo $re['book_id']; ?>" name="rating" value="2" <?php if ($user_has_rated == 2) echo 'checked'; ?> disabled />
    <label class="full" for="star2_<?php echo $re['book_id']; ?>"></label>
    <input type="checkbox" id="star1_<?php echo $re['book_id']; ?>" name="rating" value="1" <?php if ($user_has_rated == 1) echo 'checked'; ?> disabled />
    <label class="full" for="star1_<?php echo $re['book_id']; ?>"></label>
</fieldset>

        <span class="book-voters" id="voters_<?php echo $re['book_id']; ?>">
          <?php if (isset($rating['user_count'])) {
            echo $rating['user_count'];
          } else {
            echo 0;
          } ?> voters
        </span>
      </div>
    </form>
    <div class="book-sum"><?php echo $re['book_desc'] ?></div>
    <a href="bookinfo.php?bookid=<?php echo $re['book_id']; ?>">
      <div class="book-see">See The Book</div>
    </a>
  </div>
</div>

               <?php } ?>
        </div>
    </section>

    <hr class="hr-divid">

    
    <?php
include 'footer.php';
?>
   
    <script src='https://cdnjs.cloudflare.com/ajax/libs/flickity/1.0.0/flickity.pkgd.js'></script>
    


</body>

</html>