<?php
include 'connection.php';

if (isset($_POST['bookId']) && isset($_POST['bookName']) && isset($_POST['authorName']) && isset($_POST['price']) && isset($_POST['category']) && isset($_POST['description']) && isset($_POST['qty']) && isset($_FILES['image'])) {

    $bookId = $_POST['bookId'];
    $bookName = $_POST["bookName"];
    $authorName = $_POST["authorName"];
    $price = $_POST["price"];
    $category = $_POST["category"];
    $bookDesc = $_POST["description"];
    $qty = $_POST["qty"];
    $bookImg = $_FILES['image']['name'];
    $Img_tmp = $_FILES['image']['tmp_name'];

    // Check if the author already exists in the authors table
    $authorQuery = "SELECT author_id FROM authors WHERE author_name = ?";
    $authorStatement = mysqli_prepare($connection, $authorQuery);
    mysqli_stmt_bind_param($authorStatement, "s", $authorName);
    mysqli_stmt_execute($authorStatement);
    $authorResult = mysqli_stmt_get_result($authorStatement);

    if (mysqli_num_rows($authorResult) > 0) {
        // Author already exists, retrieve the author_id
        $authorRow = mysqli_fetch_assoc($authorResult);
        $authorId = $authorRow['author_id'];
    } else {
        // Author doesn't exist, insert the author into the authors table
        $authorSql = "INSERT INTO authors (author_name) VALUES (?)";
        $authorStatement = mysqli_prepare($connection, $authorSql);
        mysqli_stmt_bind_param($authorStatement, "s", $authorName);

        if (mysqli_stmt_execute($authorStatement)) {
            // Retrieve the generated author_id
            $authorId = mysqli_insert_id($connection);
        } else {
            echo "Error: " . mysqli_error($connection);
            // Handle the error and return an appropriate response
            return;
        }
    }
    $borrowPrice = $price * 0.1;

    // Update the book in the books table
    $bookSql = "UPDATE books SET book_name = ?, book_price = ?, borrow_price = ?, category = ?, book_desc = ?, quantity = ?, book_img = ? WHERE book_id = ?";
    $bookStatement = mysqli_prepare($connection, $bookSql);
    mysqli_stmt_bind_param($bookStatement, "sssssssi", $bookName, $price, $borrowPrice, $category, $bookDesc, $qty, $bookImg, $bookId);
    move_uploaded_file($Img_tmp, "uploads/" . $bookImg);

    if (mysqli_stmt_execute($bookStatement)) {
        // Update the author-book relationship in the Author_Books table
        $authorBookSql = "UPDATE Author_Books SET author_id = ? WHERE book_id = ?";
        $authorBookStatement = mysqli_prepare($connection, $authorBookSql);
        mysqli_stmt_bind_param($authorBookStatement, "ii", $authorId, $bookId);

        if (mysqli_stmt_execute($authorBookStatement)) {
            echo "Success!";
            
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Error: " . mysqli_error($connection);
    }
} else {
    echo "Incomplete form data. Please fill in all the required fields.";
}
?>
