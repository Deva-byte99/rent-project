<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "farming_rental";

// ✅ Create a database connection
$conn = new mysqli($servername, $username, $password, $database);

// ✅ Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ✅ Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ✅ Get and sanitize user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // ✅ Prevent empty login attempt
    if (empty($email) || empty($password)) {
        $_SESSION["error"] = "Please enter both email and password!";
        header("Location: admin_login.html");
        exit();
    }

    // ✅ Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // ✅ Check if admin exists
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // ✅ Check password (if hashed in the database)
        if ($password === $admin["password"]) {
        
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin["id"];
            header("Location: admin.php");
            exit();
        } else {
            $_SESSION["error"] = "Invalid email or password!";
        }
    } else {
        $_SESSION["error"] = "Admin not found!";
    }

    // ✅ Redirect back to login page with error message
    header("Location: admin_login.html");
    exit();
}

// ✅ Close connection
$conn->close();
?>
