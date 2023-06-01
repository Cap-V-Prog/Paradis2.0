<?php
function addToCart($U_ID, $I_ID, $Quant, $conn) {
    try {
        // Check if the user exists
        $userQuery = $conn->prepare("SELECT * FROM users WHERE U_ID = :U_ID");
        $userQuery->bindParam(":U_ID", $U_ID);
        $userQuery->execute();

        if ($userQuery->rowCount() == 0) {
            // User does not exist
            return "Invalid user ID";
        }

        // Check if the item exists
        $itemQuery = $conn->prepare("SELECT * FROM inventory WHERE I_ID = :I_ID");
        $itemQuery->bindParam(":I_ID", $I_ID);
        $itemQuery->execute();

        if ($itemQuery->rowCount() == 0) {
            // Item does not exist
            return "Invalid item ID";
        }

        // Start a transaction
        $conn->beginTransaction();

        // Insert into the cart table
        $insertQuery = $conn->prepare("INSERT INTO cart (U_ID, I_ID, Quant) VALUES (:U_ID, :I_ID, :Quant)");
        $insertQuery->bindParam(":U_ID", $U_ID);
        $insertQuery->bindParam(":I_ID", $I_ID);
        $insertQuery->bindParam(":Quant", $Quant);
        $insertQuery->execute();

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


