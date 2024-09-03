<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Product</title>
</head>
<body>
    <h2>Delete Product</h2>
    <?php
    require_once "connect.php";

    if(isset($_POST["id"]) && !empty($_POST["id"])){
        $id = $_POST["id"];

        $sql = "DELETE FROM products WHERE id = ?";
        
        if($stmt = $conn->prepare($sql)){
            $stmt->bind_param("i", $id);

            if($stmt->execute()){
                echo "Product deleted successfully!";
                echo "<p><a href='index.php'>Back</a></p>";
            } else{
                echo "Error: Could not execute the query. " . $mysqli->error;
            }
        } else{
            echo "Error: Could not prepare the query. " . $mysqli->error;
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
                        echo "<p>Are you sure you want to delete this product?</p>";
                        echo "<p><strong>Product Name:</strong> " . $row['Name'] . "</p>";
                        echo "<form action='delete.php' method='post'>";
                        echo "<input type='hidden' name='id' value='$id'>";
                        echo "<input type='submit' value='Yes, Delete'>";
                        echo "</form>";
                        echo "<p><a href='index.php'>Cancel</a></p>";
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
</body>
</html>
