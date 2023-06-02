<?php
    include "BDconection.php";
    include "UsersDataHandler.php";

    $conn=connectToDatabase("LocalHost","root","","paradis");

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = searchUserByEmail($conn, $email);

        if ($user) {
            // User found, compare passwords
            if ($user->password === $password) {
                // Passwords match, login successful
                echo "Login successful!";
                session_start();
                $_SESSION['user']=$user;
                header("Refresh: 2; ../index.php");
            } else {
                // Passwords don't match
                echo "Incorrect password!";
            }
        } else {
            // User not found
            echo "User not found!";
        }
    }

?>
