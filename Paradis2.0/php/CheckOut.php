<?php

include 'BDconection.php';
include 'CartDataHandler.php';

// Connect to the database
$conn = connectToDatabase("LocalHost", "root", "", "paradis");

include 'UsersDataHandler.php';
session_start();

// Get the user ID from the session
$userID = $_SESSION['user'];

// Create a new row in the sells table
$date = date("Y-m-d H:i:s"); // Get the current date and time
$paymentMethod = "Debit"; // Set the payment method (you can change it as per your needs)

try {
    // Prepare the SQL statement
    $query = "INSERT INTO sells (U_ID, date, PaymentMethod) VALUES (:userID, :date, :paymentMethod)";
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $stmt->bindParam(':userID', $userID->id);
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':paymentMethod', $paymentMethod);

    // Execute the statement
    $stmt->execute();

    // Get the generated sell ID
    $sellID = $conn->lastInsertId();

    // Move items from cart to itemsells table
    $cartItems = searchCartByUserId($userID->id, $conn);

    foreach ($cartItems as $item) {
        $itemID = $item['I_ID'];
        $quantity = $item['Quant'];

        // Insert the item into itemsells table
        $query = "INSERT INTO itemsells (S_ID, I_ID, Quant) VALUES (:sellID, :itemID, :quantity)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':sellID', $sellID);
        $stmt->bindParam(':itemID', $itemID);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->execute();
    }

    // Clear the cart for the user
    clearCart($userID->id, $conn);

    // Redirect back to the cart page or any other desired page
    header("Location: ../thankyou.html");
    exit();
} catch (PDOException $e) {
    // Display an error message
    echo "Error: " . $e->getMessage();
}

function clearCart($userID, $conn)
{
    // Prepare the SQL statement
    $query = "DELETE FROM cart WHERE U_ID = :userID";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':userID', $userID);
    $stmt->execute();
}
?>
