<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../admin/admin.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$is_admin = $_SESSION['is_admin'];

if ($is_admin) {
    // Gebruiker is een admin, toon admininformatie
    $admin_info = "You are an admin.";
} else {
    // Gebruiker is een gewone gebruiker
    $admin_info = "You are a regular user.";
}

// Haal verzoekproducten op uit de 'verzoek' tabel
$request_products = array();

$sql = "SELECT * FROM verzoek";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $request_products[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../css/admin-panel.css">
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <p><?php echo $admin_info; ?></p>
        <div class="tab-menu">
            <button id="add-product-tab">Add Product</button>
            <button id="request-product-tab">verzoekproducten</button>
        </div>
        <div class="tab-content" id="add-product-content">
            <form action="../adding/add_product.php" method="POST" enctype="multipart/form-data">
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
        </div>
        <div class="tab-content" id="request-product-content">
            <h2>Request Products</h2>
            <ul class="request-product-list">
                <?php
                foreach ($request_products as $product) {
                    echo "<li class='request-product-item'>";
                    echo "<strong>Name:</strong> " . htmlspecialchars($product['name']) . "<br>";
                    echo "<strong>Description:</strong> " . htmlspecialchars($product['description']) . "<br>";
                    echo "<strong>Price:</strong> $" . number_format($product['price'], 2) . "<br>";
                    echo "<strong>Image:</strong> <img src='" . htmlspecialchars($product['image_url']) . "' alt='" . htmlspecialchars($product['name']) . "'><br>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
        <a href="../login/logout.php">Logout</a>
        <a href="../index/index.php">home_page</a>
        <a href="../admin/admin_make_admin.php" target='_blank'>Make User Admin</a>
    </div>
    <script src="../js/admin.js"></script>

</body>
</html>

