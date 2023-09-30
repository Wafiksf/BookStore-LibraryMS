<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && isset($_POST['fav_id'])) {
        $itemId = $_POST['fav_id'];

        $query = "DELETE FROM favorite WHERE fav_id = $itemId";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: favorite.php');
        } else {
            echo "Failed to delete item.";
        }
    }
}
?>
