<?php
class ItemData
{
    public $id;
    public $name;
    public $stock;
    public $price;
    public $desc;
    public $image;

    public function __construct($id, $name, $stock, $price, $desc, $image)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stock = $stock;
        $this->price = $price;
        $this->desc = $desc;
        $this->image = $image;
    }
}

function listItemTable($conn)
{

    // Query to retrieve data from the table
    $sql = "SELECT * FROM inventory";
    $stmt = $conn->query($sql);

    // Check if any rows are returned
    if ($stmt->rowCount() > 0) {
        // Create an array to store the data
        $data = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $UsersData = new ItemData(
                $row['I_ID'],
                $row['name'],
                $row['stock'],
                $row['price'],
                $row['Description'],
                $row['Image']
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

function addInventoryItem($conn, $name, $stock, $price, $description, $image) {
    try {
        // Start a transaction
        $conn->beginTransaction();

        $sql = "INSERT INTO inventory (name, stock, price, Description, Image)
                VALUES (:name, :stock, :price, :description, :image)";
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':stock', $stock);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image', $image);

        $stmt->execute();

        // Commit the transaction
        $conn->commit();

        echo "Inventory item added successfully.";
    } catch (PDOException $e) {
        // Rollback the transaction on error
        $conn->rollback();

        echo "Error: " . $e->getMessage();
    }
}

function searchInventoryItem($conn, $id)
{
    $sql = "SELECT * FROM inventory WHERE I_ID = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $itemData = new ItemData(
            $row['I_ID'],
            $row['name'],
            $row['stock'],
            $row['price'],
            $row['Description'],
            $row['Image']
        );

        return $itemData;
    } else {
        echo "Product with ID $id not found.";
        return null;
    }
}

function searchRandomInventoryItems($conn, $limit)
{
    $sql = "SELECT * FROM inventory ORDER BY RAND() LIMIT :limit";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $data = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $itemData = new ItemData(
                $row['I_ID'],
                $row['name'],
                $row['stock'],
                $row['price'],
                $row['Description'],
                $row['Image']
            );

            $data[] = $itemData;
        }

        return $data;
    } else {
        echo "No results found.";
        return array();
    }
}


