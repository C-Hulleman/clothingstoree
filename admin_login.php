<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query the database to fetch the hashed password for the given username
    $sql = "SELECT username, password FROM admin_credentials WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Database query error: " . mysqli_error($conn));
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $hashedPassword = $row['password'];

        // Verify the submitted password against the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Successful login
            $_SESSION['admin'] = true;
            header("Location: admin_panel.php");
            exit();
        } else {
            // Invalid password
            header("Location: admin.php?error=1");
            exit();
        }
        
    }

    // Invalid credentials
    header("Location: admin.php?error=1"); // Redirect back to login with an error flag
    exit();
}

$conn->close();
?>
