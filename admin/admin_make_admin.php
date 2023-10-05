<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: ../admin/admin.php");
    exit();
}

// Haal alle gebruikers op uit de 'users' tabel
$get_users_sql = "SELECT * FROM users";
$user_list_result = $conn->query($get_users_sql);

$admin_list_result = null; // Initialiseer de variabele als null om fouten te voorkomen

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['make-admin'])) {
        // Haal de gebruiker op uit de 'users' tabel
        $username = $_POST['username'];
        $get_user_sql = "SELECT * FROM users WHERE username = '$username'";
        $get_user_result = $conn->query($get_user_sql);

        if ($get_user_result->num_rows == 1) {
            $row = $get_user_result->fetch_assoc();

            // Hash het wachtwoord van de gebruiker
            $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);

            // Voeg de gebruiker toe aan de 'admin_credentials' tabel met het gehashte wachtwoord
            $sql = "INSERT INTO admin_credentials (username, password) VALUES ('{$row['username']}', '$hashed_password')";
            $result = $conn->query($sql);

            if ($result) {
                // Verwijder de gebruiker uit de 'users' tabel
                $delete_user_sql = "DELETE FROM users WHERE username = '$username'";
                $delete_result = $conn->query($delete_user_sql);

                if ($delete_result) {
                    $success_message = "User '$username' is now an admin.";
                } else {
                    $error_message = "Failed to remove user '$username' from users.";
                }
            } else {
                $error_message = "Failed to make user '$username' an admin.";
            }
        } else {
            $error_message = "User '$username' not found in users.";
        }
    } elseif (isset($_POST['remove-admin'])) {
        // Haal de gebruiker op uit de 'admin_credentials' tabel
        $username = $_POST['username'];
        $get_user_sql = "SELECT * FROM admin_credentials WHERE username = '$username'";
        $get_user_result = $conn->query($get_user_sql);

        if ($get_user_result->num_rows == 1) {
            $row = $get_user_result->fetch_assoc();

            // Voeg de gebruiker toe aan de 'users' tabel zonder het wachtwoord opnieuw te hashen
            $insert_user_sql = "INSERT INTO users (username, password) VALUES ('{$row['username']}', '{$row['password']}')";
            $insert_result = $conn->query($insert_user_sql);

            if ($insert_result) {
                // Verwijder de admin uit de 'admin_credentials' tabel
                $delete_admin_sql = "DELETE FROM admin_credentials WHERE username = '$username'";
                $delete_result = $conn->query($delete_admin_sql);

                if ($delete_result) {
                    $success_message = "Admin '$username' is now a user.";
                } else {
                    $error_message = "Failed to remove admin '$username' from admins.";
                }
            } else {
                $error_message = "Failed to add admin '$username' back to users.";
            }
        } else {
            $error_message = "Admin '$username' not found in admins.";
        }
    }
}

// Haal nu de lijst met admin-gebruikers op
$get_admins_sql = "SELECT * FROM admin_credentials";
$admin_list_result = $conn->query($get_admins_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Make Admin</title>
    <link rel="stylesheet" href="../css/ama.css">
</head>
<body>
    <h1>Make Admin</h1>
    <?php
    if (isset($success_message)) {
        echo "<p>$success_message</p>";
    }
    if (isset($error_message)) {
        echo "<p>$error_message</p>";
    }
    ?>
    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <button type="submit" name="make-admin" id="make-admin-button">Make Admin</button>
        <button type="submit" name="remove-admin" id="remove-admin-button">Remove Admin</button>
    </form>

    <h2>Users List</h2>
    <ul>
        <?php
        while ($row = $user_list_result->fetch_assoc()) {
            echo "<li>{$row['username']}</li>";
        }
        ?>
    </ul>
    <h2>Admins List</h2>
    <ul>
        <?php
        if ($admin_list_result) { // Controleer of $admin_list_result niet null is
            while ($row = $admin_list_result->fetch_assoc()) {
                echo "<li>{$row['username']}</li>";
            }
        }
        ?>
    </ul>
    <a href="../admin/admin_panel.php">Back to Admin Panel</a>
</body>
</html>
