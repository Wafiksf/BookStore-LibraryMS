<?php
require("connection.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['roomname']) && isset($_POST['roomcap'])) {
        $roomName = $_POST['roomname'];
        $roomCapacity = $_POST['roomcap'];

        // Validate inputs
        if (empty($roomName) || empty($roomCapacity)) {
            $_SESSION["msg"] = "Please fill out all the inputs!";
            header('Location: room.php');
            exit();
        }

        // Perform additional validation if needed
        // ...

        $sql = "SELECT * FROM room WHERE db_room='$roomName'";
        $result = mysqli_query($connection, $sql);
        if (mysqli_num_rows($result) > 0) {
            $sql = "UPDATE room SET db_capacity='$roomCapacity'";
            $result = mysqli_query($connection, $sql);
            header('Location: room.php?update');
        } else {
            $sql = "INSERT INTO room (db_room, db_capacity) VALUES ('$roomName','$roomCapacity')";
            $result = mysqli_query($connection, $sql);
            $_SESSION["msg"] = "Added Successfully!";
            header('Location: room.php');
        }
        exit();
    } else {
        header('Location: room.php?error=missing');
        exit();
    }
}
?>
