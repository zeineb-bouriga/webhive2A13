<?php
include 'config.php'; // Ensure this connects to the database
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize inputs
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $img = mysqli_real_escape_string($conn, $_POST['img']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Validate inputs
    if (!empty($name) && is_numeric($price) && !empty($description) && !empty($img) && in_array($status, ['active', 'inactive', 'sale'])) {
        // SQL query to insert data
        $sql = "INSERT INTO products (name, price, description, img, status) 
                VALUES ('$name', '$price', '$description', '$img', '$status')";

        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>Product added successfully!</p>";
        } else {
            echo "<p style='color: red;'>Error: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color: red;'>Please fill in all fields correctly!</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Add Product</title>
</head>
<body>
    <h2>Add a New Product</h2>
    <form action="ajoute_produit.php" method="POST">
        <label for="name">Product Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="price">Price:</label><br>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="description">Description:</label><br>
        <textarea id="description" name="description" rows="4" required></textarea><br><br>

        <label for="img">Image URL:</label><br>
        <input type="text" id="img" name="img" required><br><br>

        <label for="status">Status:</label><br>
        <select id="status" name="status" required>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
            <option value="sale">Sale</option>
        </select><br><br>

        <button type="submit">Add Product</button>
    </form>

    <?php include 'footer.php'; ?>
</body>
</html>
