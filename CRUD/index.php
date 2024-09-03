<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Dashboard</title>
</head>
<body>

    <h2>Product Details</h2>
    <a href="create.php">Add New Product</a>

    <?php
 
    require_once "connect.php";
    

    $sql = "SELECT * FROM products";
    if($result = $conn->query($sql)){
        if($result->num_rows > 0){
            echo '<table>';
                echo "<thead>";
                    echo "<tr>";
                        echo "<th>#</th>";
                        echo "<th>Product Name</th>";
                        echo "<th>Description</th>";
                        echo "<th>Price</th>";
                        echo "<th>Quantity</th>";
                        echo "<th>Created at</th>";
                        echo "<th>Updated at</th>";
                        echo "<th>Actions</th>";
                    echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
                while($row = $result->fetch_array()){
                    echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['Name'] . "</td>";
                        echo "<td>" . $row['Description'] . "</td>";
                        echo "<td>" . $row['Price'] . "</td>";
                        echo "<td>" . $row['Quantity'] . "</td>";
                        echo "<td>" . $row['Created_at'] . "</td>";
                        echo "<td>" . $row['Updated_at'] . "</td>";
                        echo "<td>";
                            echo '<a href="read.php?id='. $row['id'] .'">View</a> ';
                            echo '<a href="update.php?id='. $row['id'] .'">Update</a> ';
                            echo '<a href="delete.php?id='. $row['id'] .'">Delete</a>';
                        echo "</td>";
                    echo "</tr>";
                }
                echo "</tbody>";                            
            echo "</table>";
            
            $result->free();
        } else{
            echo '<div><em>No products were found.</em></div>';
        }
    } else{
        echo "Oops! Something went wrong. Please try again later.";
    }
    
    // Close connection
    $conn->close();
    ?>
    
</body>
</html>