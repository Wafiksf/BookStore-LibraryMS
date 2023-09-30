<?php
require_once('payment/vendor/autoload.php');
require("connection.php");

// Assuming you have a database connection established
session_start();

$email = $_SESSION['email'];

// Retrieve data from the "addcart" table
$query = "SELECT SUM(Total) AS totalAmount FROM addcart WHERE cart_user_email = '$email'";
$result = mysqli_query($connection, $query);

// Check if the query was successful
if ($result) {
    $row = mysqli_fetch_assoc($result);
    $totalAmount = $row['totalAmount'];

    // Close the database connection
    mysqli_close($connection);

    // Create a payment intent using Stripe API
    $stripeSecretKey = ''; // Replace with your actual secret key
    \Stripe\Stripe::setApiKey($stripeSecretKey);

    try {
        $totalAmount = (isset($totalAmount) && is_numeric($totalAmount) && $totalAmount >= 1) ? $totalAmount : 1;

        $intent = \Stripe\PaymentIntent::create([
            'amount' => round($totalAmount * 100),
            'currency' => 'usd',
        ]);

        // Return the client secret
        echo json_encode(['clientSecret' => $intent->client_secret]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
        // Handle the error
        echo json_encode(['error' => $e->getMessage()]);
    }
} else {
    // Handle the query error
    echo json_encode(['error' => 'Failed to retrieve data from the addcart table.']);
}
?>
