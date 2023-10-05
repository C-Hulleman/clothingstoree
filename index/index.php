<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array(); // Initialize the cart as an empty associative array
}

include '../config/config.php';

// Controleer of er een verwijderactie voor een product is uitgevoerd
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete-product'])) {
    $product_id = $_POST['product-id'];
    
    // Controleer of de gebruiker een admin is voordat je een product verwijdert
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {

        $delete_sql = "DELETE FROM products WHERE id = $product_id";
        if ($conn->query($delete_sql) === TRUE) {
            // Product is succesvol verwijderd
            header("Location: ../index/index.php"); // Herleid naar de hoofdpagina of een andere locatie
            exit();
        } else {
            // Er is een fout opgetreden bij het verwijderen van het product
            echo "Error: " . $conn->error;
        }
    }
}

// Uitloggen
if (isset($_GET['logout'])) {
    // Voer uitloglogica uit en vernietig de sessie
    session_destroy();
    header("Location: ../index/index.php"); // Herleid naar de hoofdpagina of een andere locatie na uitloggen
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Clothing Store</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://kit.fontawesome.com/7478ce291c.js" crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <h1>Clothing Store</h1>
    <?php
    if (isset($_SESSION['user_id'])) {
        // Als een gebruiker is ingelogd, toon een welkomstbericht en de mogelijkheid om uit te loggen
        echo "<p>Welcome, " . htmlspecialchars($_SESSION['username']) . "!</p>";
        echo "<a href='../index/index.php?logout=1'>Logout</a>";

        // Controleer of de gebruikersnaam overeenkomt met een beheerdersaccount
        $admin_username = $_SESSION['username'];
        $admin_query = "SELECT * FROM admin_credentials WHERE username = '$admin_username'";
        $admin_result = $conn->query($admin_query);

        if ($admin_result->num_rows > 0) {
            // De gebruiker is een beheerder
            $_SESSION['is_admin'] = true;
            echo "<a href='../admin/admin.php' class='admin-button' target='_blank'>Admin Panel</a>";
        } else {
            // De gebruiker is geen beheerder
            $_SESSION['is_admin'] = false;
        }
    } else {
        // Als er geen gebruiker is ingelogd, toon een link naar de inlogpagina
        echo "<a href='../login/login.php' class='login-link' target='_blank'>Login </a>";
        echo "<a href='../login/register.php' class='register-link' target='_blank'>Register</a>";
    }
    ?>
    <a href="../cart/show_cart.php" class="cart-link" target='_blank'>View Cart</a>
    <a href="../adding/verzoek.php" class="request-link" target='_blank'>Request Product</a> <!-- Link naar verzoekpagina toegevoegd -->
    <div class="product-list">
        <?php
        $sql = "SELECT * FROM products";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='product'>";
                echo "<img src='" . htmlspecialchars($row['image_url']) . "' alt='" . htmlspecialchars($row['name']) . "'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                echo "<p>" . htmlspecialchars($row['description']) . "</p>";
                echo "<p>Price: $" . number_format($row['price'], 2) . "</p>";

                // Toegevoegde knop voor het verwijderen van producten, alleen zichtbaar voor admins
                if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                    echo "<form method='POST'>";
                    echo "<button class='delete-product' name='delete-product'>Delete</button>";
                    echo "<input type='hidden' name='product-id' value='" . $row['id'] . "'>";
                    echo "</form>";
                }

                // Add "Add to Cart" button with product ID
                echo "<form method='POST'>";
                echo "<button class='add-to-cart' data-product-id='" . $row['id'] . "' data-product-name='" . htmlspecialchars($row['name']) . "' name='add-to-cart'>Add to Cart</button>";
                echo "<input type='hidden' name='product-id' value='" . $row['id'] . "'>";
                echo "</form>";

                echo "</div>";
            }
        } else {
            echo "No products available.";
        }

        $conn->close();
        ?>
    </div>
</div>
<script src="../js/script.js"></script>
</body>
</html>
