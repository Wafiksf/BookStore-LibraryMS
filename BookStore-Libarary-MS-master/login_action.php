<?php
include 'connection.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST["email"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM register WHERE db_email='$email' AND db_password='$password'";
    $result = mysqli_query($connection, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if ($row['email_verified'] == 1) {
            $_SESSION['email'] = $email;
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Please verify your email before logging in.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }
    include 'login.php';
    mysqli_close($connection);
}

?>