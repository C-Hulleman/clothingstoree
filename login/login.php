<?php
session_start();
include '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Controleer eerst of de gebruiker een admin is
    $admin_sql = "SELECT * FROM admin_credentials WHERE username = '$username'";
    $admin_result = $conn->query($admin_sql);

    if ($admin_result && $admin_result->num_rows == 1) {
        $admin_row = $admin_result->fetch_assoc();
        $hashed_password = $admin_row['password']; // Haal het gehashte wachtwoord uit de database
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $admin_row['id'];
            $_SESSION['username'] = $admin_row['username'];
            header("Location: ../index/index.php");
            exit();
        }
    }

    // Controleer in de gebruikerstabel met niet-gehasht wachtwoord
    $user_sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $user_result = $conn->query($user_sql);

    if ($user_result->num_rows == 1) {
        $user_row = $user_result->fetch_assoc();
        $_SESSION['user_id'] = $user_row['id'];
        $_SESSION['username'] = $user_row['username'];
        header("Location: ../index/index.php");
        exit();
    } else {
        // Controleer in de gebruikerstabel met gehasht wachtwoord
        $user_sql_hashed = "SELECT * FROM users WHERE username = '$username'";
        $user_result_hashed = $conn->query($user_sql_hashed);

        if ($user_result_hashed->num_rows == 1) {
            $user_row_hashed = $user_result_hashed->fetch_assoc();
            $hashed_password_hashed = $user_row_hashed['password'];
            if (password_verify($password, $hashed_password_hashed)) {
                $_SESSION['user_id'] = $user_row_hashed['id'];
                $_SESSION['username'] = $user_row_hashed['username'];
                header("Location: ../index/index.php");
                exit();
            }
        }

        $login_error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
<div class="container">
    <h1>Inloggen</h1>
    <?php
    if (isset($login_error)) {
        echo "<p class='error-message'>$login_error</p>";
    }
    ?>
    <form method="POST">
        <label for="username">gebruikersnaam:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">wachtwoord:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
    <a href="../login/register.php">Don't have an account? Register here.</a>
    <a href="../index/index.php">home</a>
</div>
</body>
</html>
