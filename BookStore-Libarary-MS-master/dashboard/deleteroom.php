<?php
include 'connection.php';
session_start();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM room WHERE id=$id";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        $_SESSION["msg"] = "Deleted!";
        header('Location: room.php');
        exit;
    } else {
        die(mysqli_error($connection));
    }
}
?>