<?php
require_once 'connection.php';

$stmt = $connection->prepare("SELECT books.book_id, books.book_name, books.book_price, books.quantity, books.borrow_price, books.book_desc, books.book_img, authors.author_name, categories.category_id, categories.category_name
            FROM books
            JOIN author_books ON books.book_id = author_books.book_id
            JOIN authors ON author_books.author_id = authors.author_id
            JOIN categories ON books.category = categories.category_id");
$stmt->execute();
$stmt->bind_result($bookId, $bookName, $bookPrice, $quantity, $borrowPrice, $bookDesc, $bookImg, $authorName, $categoryId, $categoryName);

$result = array();

while ($stmt->fetch()) {
    $row = array(
        'bookId' => $bookId,
        'bookImg' => $bookImg,
        'bookName' => $bookName,
        'bookPrice' => $bookPrice,
        'quantity' => $quantity,
        'borrowPrice' => $borrowPrice,
        'bookDesc' => $bookDesc,
        'authorName' => $authorName,
        'categoryName' => $categoryName,
        'categoryId' => $categoryId,
    );
    $result[] = $row;
}

$stmt->close();
$connection->close();

header('Content-Type: application/json');

echo json_encode($result);
?>
