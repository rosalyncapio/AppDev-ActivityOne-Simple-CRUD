<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Product</title>
</head>
<body>
    <h2>Update Product</h2>
    <?php
    require_once "connect.php";

    if(isset($_POST["id"]) && !empty($_POST["id"])){
        $id = $_POST["id"];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        $sql = "UPDATE products SET name = ?, description = ?, price = ?, quantity = ? WHERE id = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("ssdii", $name, $description, $price, $quantity, $id);

            if($stmt->execute()){
                echo "Product updated successfully!";
                $name = $description = $price = $quantity = "";
            } else{
                echo "Error: Could not execute the query. " . $conn->error;
            }
        } else{
            echo "Error: Could not prepare the query. " . $conn->error;
        }

        $stmt->close();
    } else{
        if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
            $id = trim($_GET["id"]);

            $sql = "SELECT * FROM products WHERE id = ?";
            if($stmt = $conn->prepare($sql)){
                $stmt->bind_param("i", $id);
                
                if($stmt->execute()){
                    $result = $stmt->get_result();
                    if($result->num_rows == 1){
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        $name = $row["Name"];
                        $description = $row["Description"];
                        $price = $row["Price"];
                        $quantity = $row["Quantity"];
                    } else{
                        echo "Error: No records found.";
                        exit();
                    }
                } else{
                    echo "Error: Could not execute the query. " . $conn->error;
                }
            }

            $stmt->close();
        } else{
            echo "Error: Invalid request.";
            exit();
        }
    }

    $conn->close();
    ?>
    
    <form action="update.php" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <p>
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" value="<?php echo $name; ?>" required>
        </p>
        <p>
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" value="<?php echo $description; ?>" required>
        </p>
        <p>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" value="<?php echo $price; ?>" required>
        </p>
        <p>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>" required>
        </p>
        <input type="submit" value="Update Product">
    </form>
    <p><a href="index.php">Back to Product List</a></p>
</body>
</html>