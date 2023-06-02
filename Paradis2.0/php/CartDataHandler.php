<?php
include 'BDconection.php';
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    include 'UsersDataHandler.php';
    session_start();
    $servername = "LocalHost";
    $username = "root";
    $password = "";
    $dbname = "paradis";

    $conn = connectToDatabase($servername, $username, $password, $dbname);
    $user = $_SESSION['user'];
    addToCart($user->id,$_GET['id'],$_GET['quant'],$conn);
    header("Refresh: 0; ../cart.html");
}
function addToCart($U_ID, $I_ID, $Quant, $conn) {
    try {
        // Start a transaction
        $conn->beginTransaction();

        // Check if the item exists
        $itemQuery = $conn->prepare("SELECT * FROM inventory WHERE I_ID = :I_ID");
        $itemQuery->bindParam(":I_ID", $I_ID);
        $itemQuery->execute();

        if ($itemQuery->rowCount() == 0) {
            // Item does not exist
            return "Invalid item ID";
        }

        // Check if the user already has the item in the cart
        $cartQuery = $conn->prepare("SELECT * FROM cart WHERE U_ID = :U_ID AND I_ID = :I_ID");
        $cartQuery->bindParam(":U_ID", $U_ID);
        $cartQuery->bindParam(":I_ID", $I_ID);
        $cartQuery->execute();

        if ($cartQuery->rowCount() > 0) {
            // User already has the item in the cart, update the quantity
            $updateQuery = $conn->prepare("UPDATE cart SET Quant = :Quant WHERE U_ID = :U_ID AND I_ID = :I_ID");
            $updateQuery->bindParam(":Quant", $Quant);
            $updateQuery->bindParam(":U_ID", $U_ID);
            $updateQuery->bindParam(":I_ID", $I_ID);
            $updateQuery->execute();
        } else {
            // User does not have the item in the cart, insert a new row
            $insertQuery = $conn->prepare("INSERT INTO cart (U_ID, I_ID, Quant) VALUES (:U_ID, :I_ID, :Quant)");
            $insertQuery->bindParam(":U_ID", $U_ID);
            $insertQuery->bindParam(":I_ID", $I_ID);
            $insertQuery->bindParam(":Quant", $Quant);
            $insertQuery->execute();
        }

        // Commit the transaction
        $conn->commit();

        return "Item added to cart successfully";
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $conn->rollback();

        // Handle exceptions
        return "Error: " . $e->getMessage();
    }
}



