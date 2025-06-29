<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch Vehicles from Database
$result = $conn->query("SELECT * FROM vehicles");
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head> 
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Vehicles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
<div class="container mt-4">
    <h2>Manage Vehicles</h2>
    <a href="add_vehicle.php" class="btn btn-primary mb-3">Add New Vehicle</a>
    
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Vehicle Name</th>
                <th>Price</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['id']; ?></td>
                    <td><?= $row['name']; ?></td>
                    <td><?= $row['price']; ?></td>
                    <td><img src="<?= htmlspecialchars($row['image']); ?>" width="100" height="80"></td>

                    <td>
                        <a href="edit_vehicle.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-lg">Edit</a>
                        <a href="delete_vehicle.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-lg" 
   onclick="return confirm('Are you sure you want to delete this vehicle?');">Delete</a>

                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
