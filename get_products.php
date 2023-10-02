<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // File upload handling (same as before)

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert product data into the database
        $sql = "INSERT INTO products (name, description, price, image_url)
                VALUES ('$name', '$description', $price, '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            // Redirect back to admin.php
            header("Location: admin.php");
            exit(); // Make sure to exit to prevent further execution
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
}

$conn->close();
?>
