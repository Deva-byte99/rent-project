

<?php
session_start();
include "db_connection.php"; // Database connection
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.html");
    exit();
}

// Count total vehicles
$result = $conn->query("SELECT COUNT(*) AS total_vehicles FROM vehicles");
$total_vehicles = $result->fetch_assoc()['total_vehicles'];

// Count total orders
$result = $conn->query("SELECT COUNT(*) AS total_orders FROM orders");
$total_orders = $result->fetch_assoc()['total_orders'];

// Count total messages
$result = $conn->query("SELECT COUNT(*) AS total_messages FROM contact_messages");
$total_messages = $result->fetch_assoc()['total_messages'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            color: white;
            padding-top: 20px;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            font-size: 18px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            padding: 20px;
        }
        .card {
            border-radius: 10px;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block sidebar">
            <h3 class="text-center">Admin Panel</h3>
            <a href="admin.php">Dashboard</a>
            <a href="manage_vehicles.php">Manage Vehicles</a>
            <a href="orders.php">View Orders</a>
            <a href="view_messages.php">Messages</a>
            <a href="logout.php">Logout</a>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 content">
            <div class="container mt-5">
    <h2>Admin Dashboard</h2>
    <div class="row">
        <!-- Vehicles Card -->
        <div class="col-md-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h4>Total Vehicles</h4>
                    <h2><?php echo $total_vehicles; ?></h2>
                </div>
            </div>
        </div>
        
        <!-- Orders Card -->
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h4>Total Orders</h4>
                    <h2><?php echo $total_orders; ?></h2>
                </div>
            </div>
        </div>

        <!-- Messages Card -->
        <div class="col-md-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h4>Total Messages</h4>
                    <h2><?php echo $total_messages; ?></h2>
                </div>
            </div>
        </div>
    </div>

        </main>
    </div>
</div>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
