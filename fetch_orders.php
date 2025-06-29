<?php
include "db_connection.php"; // Include database connection

$sql = "SELECT vehicle, name, phone, days, address, status FROM orders";
$result = $conn->query($sql);

$orders = array();
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

// Return JSON data
echo json_encode($orders);
$conn->close();
?>
