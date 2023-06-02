<?php
if (!function_exists('connectToDatabase')) {
    require_once 'BDconection.php';
}
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['age'], $_POST['email'], $_POST['telephone'], $_POST['password'], $_POST['nif'], $_POST['gender'])) {
    $servername = "LocalHost";
    $username = "root";
    $password = "";
    $dbname = "paradis";

    $conn = connectToDatabase($servername, $username, $password, $dbname);

    addUser($conn, $_POST['name'], $_POST['age'], $_POST['email'], "NULL", $_POST['telephone'], $_POST['password'], $_POST['nif'], $_POST['gender']);
    header("Refresh: 3; ../index.php");
}

class UsersData
{
    public $id;
    public $name;
    public $age;
    public $email;
    public $address;
    public $telephone;
    public $password;
    public $nif;
    public $gender;

    public function __construct($id, $name, $age, $email, $address, $telephone, $password, $nif, $gender)
    {
        $this->id = $id;
        $this->name = $name;
        $this->age = $age;
        $this->email = $email;
        $this->address = $address;
        $this->telephone = $telephone;
        $this->password = $password;
        $this->nif = $nif;
        $this->gender = $gender;
    }
}

function listUserTable($conn)
{
    // Query to retrieve data from the table
    $sql = "SELECT * FROM users";
    $stmt = $conn->query($sql);

    // Check if any rows are returned
    if ($stmt->rowCount() > 0) {
        // Create an array to store the data
        $data = array();

        // Loop through each row and create MyStruct objects
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $UsersData = new UsersData(
                $row['U_ID'],
                $row['Nome'],
                $row['Birthday'],
                $row['Email'],
                $row['Address'],
                $row['Tell'],
                $row['Password'],
                $row['NIF'],
                $row['Gender']
            );

            // Add the object to the data array
            $data[] = $UsersData;
        }

        return $data;
    } else {
        echo "<br>No results found";
        return array(); // Empty array if no results found
    }
}

function addUser($conn, $name, $age, $email, $address, $telephone, $password, $nif, $gender) {

    $conn->beginTransaction(); // Begin the transaction

    $sql = "INSERT INTO users (Nome, Birthday, Email, Address, Tell, Password, NIF, Gender) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    try {
        $stmt->execute([$name, $age, $email, $address, $telephone, $password, $nif, $gender]);
        $conn->commit(); // Commit the transaction
        echo "User added successfully.";
    } catch (PDOException $e) {
        $conn->rollback(); // Rollback the transaction
        echo "Error adding user: " . $e->getMessage();
    }
}

function searchUserByEmail($conn, $email)
{
    $sql = "SELECT * FROM users WHERE Email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $user = new UsersData(
            $row['U_ID'],
            $row['Nome'],
            $row['Birthday'],
            $row['Email'],
            $row['Address'],
            $row['Tell'],
            $row['Password'],
            $row['NIF'],
            $row['Gender']
        );
        return $user;
    } else {
        echo "No user found with the email: $email";
        return null;
    }
}