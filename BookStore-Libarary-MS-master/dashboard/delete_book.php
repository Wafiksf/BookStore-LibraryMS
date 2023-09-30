<?php
require_once 'connection.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $connection->prepare("DELETE FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $response = "Data deleted successfully.";
    } else {
        $response = "Error deleting data: " . $stmt->error;
    }

    $stmt->close();
} else {
    $response = "Invalid request.";
}

$connection->close();

header('Content-Type: text/plain');

echo $response;
?>
