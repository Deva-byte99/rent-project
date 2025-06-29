<?php
session_start();
include "db_connection.php";

// Get logged-in user's email
$user_email = $_SESSION['user_email'];  

$query = $conn->prepare("SELECT * FROM contact_messages WHERE email = ?");
$query->bind_param("s", $user_email);
$query->execute();
$result = $query->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Your Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Your Messages</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Message</th>
                <th>Admin Reply</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['message']; ?></td>
                    <td><?php echo $row['reply'] ? $row['reply'] : '<span class="text-danger">No reply yet</span>'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
