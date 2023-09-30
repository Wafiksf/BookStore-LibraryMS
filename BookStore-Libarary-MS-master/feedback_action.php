<?php
include 'connection.php';
session_start();

// Retrieve the values from the form
$title = $_POST['title'];
$review = $_POST['review'];
$email = $_SESSION['email'];
$bookId = $_POST['idd'];

// Check if title and review are empty
if (empty($title) || empty($review)) {
    $_SESSION['msg'] = "Please add feedback";
    header("Location: bookinfo.php?bookid=".$bookId);
    exit();
}

// Prepare and execute the SQL query to insert the values into the database
$stmt = $connection->prepare("INSERT INTO feedback (feedback_title, feedback_desc, book_id, user_email) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $title, $review, $bookId, $email);
$stmt->execute();

// Close the statement and the database connection
$stmt->close();
$connection->close();

// Redirect the user to a thank you page or display a success message
header("Location: bookinfo.php?bookid=".$bookId);
exit();
?>
