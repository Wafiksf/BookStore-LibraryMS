<?php
require 'connection.php';
session_start();

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $rating = $_POST['rating'];
        $bookId = $_POST['book_id'];

        $sql = "SELECT * FROM rating WHERE item_id='$bookId' AND user_email='$email'";
        $result = mysqli_query($connection, $sql);

        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE rating SET rating_value = '$rating' WHERE item_id='$bookId' AND user_email='$email'";
        } else {
            $sql = "INSERT INTO rating (item_id, user_email, rating_value) VALUES ('$bookId', '$email', '$rating')";
        }

        $result = mysqli_query($connection, $sql);

        if ($result) {
            echo "Rating submitted successfully!";
        } else {
            echo "Error submitting rating.";
        }
    } else {
        echo "Invalid request.";
    }
} else {
    echo "User not logged in.";
}
?>
