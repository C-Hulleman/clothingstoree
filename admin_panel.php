<!-- admin_panel.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <?php
    session_start();
    if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
        header("Location: admin.php");
        exit();
    }
    ?>

    <div class="container">
        <h1>Admin Panel</h1>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
    <label for="name">Product Name:</label>
    <input type="text" name="name" required><br>

    <label for="description">Description:</label>
    <textarea name="description" required></textarea><br>

    <label for="price">Price:</label>
    <input type="number" step="0.01" name="price" required><br>

    <label for="image">Image:</label>
    <input type="file" name="image" accept="image/*" required><br>

    <button type="submit">Add Product</button>
</form>

        <a href="logout.php">Logout</a>
        <a href="index.php">home_page</a>
    </div>
    <script src="./js/admin.js"></script>
</body>
</html>
