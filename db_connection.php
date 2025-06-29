<?php
$servername = "localhost";
$username = "root"; // Change if you use a different username
$password = ""; // Keep empty for XAMPP
$database = "farming_rental"; // Ensure this matches your database name

$conn = new mysqli($servername, $username, $password, $database);

// Fix: Check if the connection is successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
