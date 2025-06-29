<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Check if vehicle ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "Vehicle ID is missing!";
    header("Location: manage_vehicles.php");
    exit();
}

$vehicle_id = $_GET['id'];

// Fetch existing vehicle details
$stmt = $conn->prepare("SELECT * FROM vehicles WHERE id = ?");
$stmt->bind_param("i", $vehicle_id);
$stmt->execute();
$result = $stmt->get_result();
$vehicle = $result->fetch_assoc();
$stmt->close();

// If no vehicle is found
if (!$vehicle) {
    $_SESSION['error'] = "Vehicle not found!";
    header("Location: manage_vehicles.php");
    exit();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $vehicle_name = $_POST["name"];
    $price = $_POST["price"];
    $image = $_FILES["image"]["name"];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);

    // Update database with new details
    if (!empty($image)) { // If user uploaded a new image
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $stmt = $conn->prepare("UPDATE vehicles SET name=?, price=?, image=? WHERE id=?");
            $stmt->bind_param("sssi", $vehicle_name, $price, $target_file, $vehicle_id);
        } else {
            $_SESSION['error'] = "Image upload failed!";
            header("Location: edit_vehicle.php?id=" . $vehicle_id);
            exit();
        }
    } else { // Update without changing the image
        $stmt = $conn->prepare("UPDATE vehicles SET name=?, price=? WHERE id=?");
        $stmt->bind_param("ssi", $vehicle_name, $price, $vehicle_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success'] = "Vehicle updated successfully!";
        header("Location: manage_vehicles.php");
    } else {
        $_SESSION['error'] = "Error updating vehicle!";
    }

    $stmt->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Vehicle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Vehicle</h2>

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>
    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>

    <form action="edit_vehicle.php?id=<?php echo $vehicle_id; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Vehicle Name</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($vehicle['name']); ?>" required>

        </div>
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($vehicle['price']); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="<?php echo $vehicle['image']; ?>" width="150" alt="Vehicle Image">
        </div>
        <div class="mb-3">
            <label class="form-label">Upload New Image (optional)</label>
            <input type="file" name="image" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Vehicle</button>
        <a href="manage_vehicles.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>
