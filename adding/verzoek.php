<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controleer of het formulier is ingediend

    // Ontvang en valideer de ingevoerde gegevens
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    // Controleer of een afbeelding is geüpload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        
        // Verplaats de geüploade afbeelding naar de gewenste map (bijv. 'uploads/')
        $upload_path = '../uploads/' . $image_name;
        move_uploaded_file($image_tmp, $upload_path);
    } else {
        // Geen afbeelding geüpload
        $upload_path = null;
    }

    // Voeg de gegevens toe aan de 'verzoek' database
    $insert_sql = "INSERT INTO verzoek (name, description, price, image_url) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("ssds", $name, $description, $price, $upload_path);
    
    if ($stmt->execute()) {
        // Succesvol toegevoegd aan de database
        $message = "Verzoek is succesvol ingediend!";
    } else {
        // Er is een fout opgetreden bij het toevoegen aan de database
        $error_message = "Fout bij het indienen van het verzoek: " . $conn->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Product Verzoek</title>
    <link rel="stylesheet" href="../css/verzoek.css">
</head>
<body>
    <div class="container">
        <h1>Product Verzoek</h1>
        <p><?php echo isset($message) ? $message : ''; ?></p>
        <p><?php echo isset($error_message) ? $error_message : ''; ?></p>
        <form action="verzoek.php" method="POST" enctype="multipart/form-data">
            <label for="name">Naam:</label>
            <input type="text" name="name" required><br>

            <label for="description">Beschrijving:</label>
            <textarea name="description" required></textarea><br>

            <label for="price">Prijs:</label>
            <input type="number" step="0.01" name="price" required><br>

            <label for="image">Afbeelding:</label>
            <input type="file" name="image" accept="image/*" required><br>

            <button type="submit">Verzoek Indienen</button>
        </form>
        <a href="../index.php">Terug naar Startpagina</a>
    </div>
</body>
</html>
