<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add New Product</title>
</head>

<body>
    <h2>Add New Product</h2>
    <?php
    require_once "connect.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];


        $sql = "INSERT INTO products (name, description, price, quantity) VALUES (?, ?, ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssdi", $name, $description, $price, $quantity);

            if ($stmt->execute()) {
                echo "Product added successfully!";
             
            } else {
                echo "Error: Could not execute the query. " . $mysqli->error;
            }
        } else {
            echo "Error: Could not prepare the query. " . $mysqli->error;
        }

        $stmt->close();
    }

    $conn->close();
    ?>

    <form action="create.php" method="post">
        <p>
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>
        </p>
        <p>
            <label for="description">Description:</label>
            <input type="text" name="description" id="description" required>
        </p>
        <p>
            <label for="price">Price:</label>
            <input type="number" name="price" id="price" step="0.01" required>
        </p>
        <p>
            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" id="quantity" required>
        </p>
        <input type="submit" value="Add Product">
        <p><a href='index.php'>Back</a></p>
    </form>
</body>

</html>