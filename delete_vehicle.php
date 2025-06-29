<?php
session_start();
include "db_connection.php";

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

//  Check if vehicle ID is provided
if (isset($_GET['id'])) {
    $vehicle_id = $_GET['id'];

    //  Fetch the vehicle image path before deleting
    $stmt = $conn->prepare("SELECT image FROM vehicles WHERE id = ?");
    $stmt->bind_param("i", $vehicle_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vehicle = $result->fetch_assoc();

    if ($vehicle) {
        //  Delete the image file from the server
        $image_path = $vehicle['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        //  Delete the vehicle from the database
        $stmt = $conn->prepare("DELETE FROM vehicles WHERE id = ?");
        $stmt->bind_param("i", $vehicle_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Vehicle deleted successfully!";
        } else {
            $_SESSION['error'] = "Error deleting vehicle!";
        }
    } else {
        $_SESSION['error'] = "Vehicle not found!";
    }
} else {
    $_SESSION['error'] = "Vehicle ID is missing!";
}

//  Redirect back to manage vehicles page
header("Location: manage_vehicles.php");
exit();
?>
