<?php

include 'BDconection.php';
include 'CartDataHandler.php';
$conn = connectToDatabase("LocalHost", "root", "", "paradis");

include 'UsersDataHandler.php';
session_start();

$userID = $_SESSION['user'];
$itemID = $_GET['id'];

$result = removeFromCart($userID->id, $itemID, $conn);

if ($result === "Item removed from cart successfully") {
    // Redirect back to the cart page
    header("Location: ../cart.php");
    exit();
} else {
    // Display an error message
    echo "Error: Failed to remove the item from the cart.";
}


?>
