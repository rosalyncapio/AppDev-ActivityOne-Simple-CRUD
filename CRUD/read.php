<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Product</title>
</head>
<body>
    <h2>View Product</h2>
    <?php
    require_once "connect.php";

    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        $id = trim($_GET["id"]);

        $sql = "SELECT * FROM products WHERE id = ?";
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $id);

            if($stmt->execute()){
                $result = $stmt->get_result();
                if($result->num_rows == 1){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    echo "<p><strong>Product Name:</strong> " . $row['Name'] . "</p>";
                    echo "<p><strong>Description:</strong> " . $row['Description'] . "</p>";
                    echo "<p><strong>Price:</strong> " . $row['Price'] . "</p>";
                    echo "<p><strong>Quantity:</strong> " . $row['Quantity'] . "</p>";
                } else{
                    echo "<p>No records found.</p>";
                }
            } else{
                echo "Error: Could not execute the query. " . $mysqli->error;
            }
        }

        $stmt->close();
    } else{
        echo "Error: Invalid request.";
    }

    $conn->close();
    ?>
    <p><a href="index.php">Back to Product List</a></p>
</body>
</html>
