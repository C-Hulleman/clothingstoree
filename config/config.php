<?php
$servername = "localhost";
$username = "bit_academy";
$password = "bit_academy";
$dbname = "clothingstore";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
