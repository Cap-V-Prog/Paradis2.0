<?php
include "BDconection.php";
include "UsersDataHandler.php";
$conn = connectToDatabase("LocalHost", "root", "", "paradis");
session_start();

// Check if the update form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $user_id = $_SESSION["user"]->id;
    $name = $_POST["name"];
    $address = $_POST["address"];
    $tel = $_POST["tel"];

    // Prepare the SQL statement
    $stmt = $conn->prepare("UPDATE users SET Nome = :name, Address = :address, Tell = :tel WHERE U_ID = :user_id");

    // Bind the parameters to the statement
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":address", $address);
    $stmt->bindParam(":tel", $tel);
    $stmt->bindParam(":user_id", $user_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Profile update successful, redirect to a success page or perform any other desired actions
        $updatedUser = searchUserById($conn, $user_id);
        $_SESSION['user'] = $updatedUser;
        header("Location: ../../Profile");
        exit();
    } else {
        // Profile update failed, handle the error appropriately
        echo "Profile update failed: " . $stmt->errorInfo()[2];
    }

    // Close the statement
    $stmt = null;
}

// Close the database connection
$conn = null;
?>
