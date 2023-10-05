<?php
include '../config/config.php';

// Insert a sample admin account with hashed password
$hashedPassword = password_hash('hierdoenwenietaan1972', PASSWORD_DEFAULT);

$sql = "INSERT INTO admin_credentials (username, password) VALUES ('pareltje1972', ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("Database query error: " . mysqli_error($conn));
}

$stmt->bind_param("s", $hashedPassword);

if ($stmt->execute()) {
    echo "Admin account inserted successfully.";
} else {
    echo "Error inserting admin account: " . $stmt->error;
}

// Close the prepared statement and the database connection
$stmt->close();
$conn->close();
?>
