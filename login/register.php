<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../index//index.php"); // Als de gebruiker al is ingelogd, stuur ze door naar de hoofdpagina
    exit();
}

include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Controleer of de gebruikersnaam al in gebruik is
    $check_username_sql = "SELECT * FROM users WHERE username = '$username'";
    $check_result = $conn->query($check_username_sql);

    if ($check_result->num_rows > 0) {
        $registration_error = "Deze gebruikersnaam is al in gebruik.";
    } else {
        // Voeg de nieuwe gebruiker toe aan de database
        $insert_sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        if ($conn->query($insert_sql) === TRUE) {
            header("Location: ../login/login.php"); // Stuur de gebruiker door naar de inlogpagina na succesvol registreren
            exit();
        } else {
            $registration_error = "Er is een fout opgetreden bij het registreren. Probeer het opnieuw.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registreren</title>
    <link rel="stylesheet" href="../css/register.css">
</head>
<body>
<div class="container">
    <h1>Registreren</h1>
    <?php
    if (isset($registration_error)) {
        echo "<p class='error-message'>$registration_error</p>";
    }
    ?>
    <form method="POST">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Registreren</button>
    </form>
    <a href="../login/login.php">Heb je al een account? Log hier in.</a>
    <a href="../index.php">home</a>
</div>
</body>
</html>
