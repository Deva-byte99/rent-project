<?php
$uname1 = $_POST['uname1'];
$email = $_POST['email'];
$unum = $_POST['unum'];
$upswd1 = $_POST['upswd1'];
$upswd2 = $_POST['upswd2'];

if (empty($uname1) || empty($email) || empty($unum) || empty($upswd1) || empty($upswd2)) {
    die("Please fill all the fields.");
}

if ($upswd1 !== $upswd2) {
    die("Passwords do not match.");
}

// Hash both passwords
$hashed_password1 = password_hash($upswd1, PASSWORD_DEFAULT);
$hashed_password2 = password_hash($upswd2, PASSWORD_DEFAULT);

$host = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "farming_rental";

$conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

if ($conn->connect_errno) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if email already exists
$check = $conn->prepare("SELECT email FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "<script>alert('Email already registered. Please login.'); window.location.href='login.html';</script>";
    $check->close();
    $conn->close();
    exit();
}
$check->close();

// Insert both hashed passwords
$stmt = $conn->prepare("INSERT INTO users (uname1, email, unum, upswd1, upswd2) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $uname1, $email, $unum, $hashed_password1, $hashed_password2);
$stmt->execute();

echo "<script>alert('New record inserted'); window.location.href='login.html';</script>";

$stmt->close();
$conn->close();
?>
