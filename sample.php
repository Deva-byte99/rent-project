<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include "db_connection.php";

// Verify the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Prepare and execute the SQL statement
$sql = "SELECT id, customer_name, vehicle_name, status FROM orders";
$orders = $conn->query($sql);

// Check if the query executed successfully
if (!$orders) {
    die("Error in SQL query: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Orders</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Vehicle</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Check if there are orders to display
            if ($orders->num_rows > 0) {
                while ($order = $orders->fetch_assoc()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($order['id']) . "</td>
                            <td>" . htmlspecialchars($order['customer_name']) . "</td>
                            <td>" . htmlspecialchars($order['vehicle_name']) . "</td>
                            <td>" . htmlspecialchars($order['status']) . "</td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No orders found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
