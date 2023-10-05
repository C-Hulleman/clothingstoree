<?php
include '../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // File upload handling
    $targetDir = "../products";  // Use forward slashes and correct path
    $targetFile = $targetDir . '/' . basename($_FILES["image"]["name"]); // Use forward slash
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));


    // Check if the file is an actual image
    $check = getimagesize($_FILES["image"]["tmp_name"]);    
    if ($check === false) {
        die("Error: File is not an image.");
    }

    // Check file size (adjust the limit as needed)
    if ($_FILES["image"]["size"] > 500000) {
        die("Error: File is too large.");
    }

    // Allow certain file formats (you can add more as needed)
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        die("Error: Only JPG, JPEG, PNG & GIF files are allowed.");
    }

    // Move the uploaded file to the "products" folder
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Insert product data into the database
        $sql = "INSERT INTO products (name, description, price, image_url)
                VALUES ('$name', '$description', $price, '$targetFile')";

        if ($conn->query($sql) === TRUE) {
            echo "Product added successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error uploading the file.";
    }
}

$conn->close();
?>
<script>
    // Redirect to the admin page after 5 seconds
    setTimeout(function() {
        window.location.href = "../admin/admin_panel.php";
    }, 5000); // 5000 milliseconds (5 seconds)
</script>