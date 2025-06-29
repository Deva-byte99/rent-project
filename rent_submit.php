<?php
// Include database connection
include "db_connection.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle = $_POST["vehicle"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $days = $_POST["days"];
    $address = $_POST["address"];
    $status = "Pending"; // Default status for new rental requests

    // Insert into database
    $sql = "INSERT INTO orders (vehicle, name, phone, days, address, status) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssiss", $vehicle, $name, $phone, $days, $address, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Rental request submitted successfully!'); window.location.href='order.html';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.history.back();</script>";
}
?>
