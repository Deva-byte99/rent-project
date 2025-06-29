<?php
$email = $_POST['email'];
$password = $_POST['upswd1'];

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "farming_rental";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    
    if ($password === $row['upswd1']) {
        echo "<script>alert('Login successful! Welcome " . htmlspecialchars($row['uname1']) . "'); window.location.href='index.html';</script>";
    } else {
        echo "<script>alert('Incorrect password'); window.history.back();</script>";
    }
    
} else {
    echo "<script>alert('Email not found'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
?>
