<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete']) && isset($_POST['cart_id'])) {
        $itemId = $_POST['cart_id'];

        $query = "DELETE FROM addcart WHERE cart_id = $itemId";

        $result = mysqli_query($connection, $query);

        if ($result) {
            header('Location: cart.php');
        } else {
            echo "Failed to delete item.";
        }
    }
}
?>
