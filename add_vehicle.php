<?php
session_start();
include "db_connection.php"; // Ensure your database connection file is correct

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_name = $_POST["vehicle_name"];
    $price = $_POST["price"];

    // ✅ Handling Image Upload
    $target_dir = "uploads/"; 
    $image_name = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;

    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // ✅ Create "uploads" folder if not exists
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        // ✅ Insert into database
        $stmt = $conn->prepare("INSERT INTO vehicles (name, price, image) VALUES (?, ?, ?)");
        if ($stmt) {
            $stmt->bind_param("sds", $vehicle_name, $price, $target_file);
            if ($stmt->execute()) {
                $_SESSION['success'] = "Vehicle added successfully!";
            } else {
                $_SESSION['error'] = "Database error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $_SESSION['error'] = "Prepare statement failed: " . $conn->error;
        }
    } else {
        $_SESSION['error'] = "Image upload failed!";
    }

    header("Location: manage_vehicles.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Vehicle</h2>

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>

    <form action="add_vehicle.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Vehicle Name</label>
            <input type="text" name="vehicle_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Vehicle</button>
        <a href="manage_vehicles.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
