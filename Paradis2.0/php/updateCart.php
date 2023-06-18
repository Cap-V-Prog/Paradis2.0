<?php


require_once 'BDconection.php';
require_once 'CartDataHandler.php';
require_once 'UsersDataHandler.php';
session_start(); // Start the session
$conn = connectToDatabase("LocalHost", "root", "", "paradis");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user'])) {
        $userID = $_SESSION['user'];

        // Retrieve cart items by user ID
        $cartItems = searchCartByUserId($userID->id, $conn);

        if (!empty($cartItems)) {
            foreach ($cartItems as $cartItem) {
                $itemID = $cartItem['I_ID'];
                $quantity = $_POST['products_' . $itemID];

                if ($quantity == 0) {
                    // Remove the item from the cart if the quantity is 0
                    $stmt = $conn->prepare("DELETE FROM cart WHERE U_ID = :userID AND I_ID = :itemID");
                    $stmt->bindParam(':userID', $userID->id);
                    $stmt->bindParam(':itemID', $itemID);
                    $stmt->execute();
                } else {
                    // Update the cart item quantity in the database
                    $stmt = $conn->prepare("UPDATE cart SET Quant = :quantity WHERE U_ID = :userID AND I_ID = :itemID");
                    $stmt->bindParam(':quantity', $quantity);
                    $stmt->bindParam(':userID', $userID->id);
                    $stmt->bindParam(':itemID', $itemID);
                    $stmt->execute();
                }
            }
        }
    }
}
header('Location: ../cart.php');
exit();
?>
