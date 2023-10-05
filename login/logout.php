<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (isset($_SESSION['user_id'])) {
    // Vernietig alle sessievariabelen
    session_destroy();

    // Stuur de gebruiker terug naar de index.php
    header("Location: ../index/index.php");
    exit();
} else {
    // Als de gebruiker niet is ingelogd, stuur ze dan ook terug naar index.php
    header("Location: ../index/index.php");
    exit();
}
?>
