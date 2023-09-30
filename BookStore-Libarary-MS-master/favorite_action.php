<?php
include 'connection.php';
$bookId = $_POST['id'];

session_start(); 

if (!isset($_SESSION['email'])) {
    header("location:login.php");
    exit();
}
$email = $_SESSION['email'];

$checkQuery = "SELECT * FROM favorite WHERE fav_user_email = '$email' AND fav_book_id = '$bookId'";
$result = mysqli_query($connection, $checkQuery);

if (mysqli_num_rows($result) == 0) {
    $insertQuery = "INSERT INTO favorite (fav_user_email, fav_book_id) VALUES ('$email', '$bookId')";
    mysqli_query($connection, $insertQuery);

    $_SESSION['msg'] = "Added to favorites!";
} else {
    $_SESSION['msg'] = "Book already exists in favorites!";
}
mysqli_close($connection);
header('Location: books.php');
?>

