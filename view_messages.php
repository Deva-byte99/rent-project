<?php
session_start();
include "db_connection.php"; // Make sure this file correctly connects to the database

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

// Handle reply submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reply_message'])) {
    $message_id = $_POST['message_id'];
    $reply_text = $_POST['reply_text'];

    if (!empty($reply_text)) {
        $stmt = $conn->prepare("UPDATE messages SET reply = ? WHERE id = ?");
        $stmt->bind_param("si", $reply_text, $message_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Reply sent successfully!";
        } else {
            $_SESSION['error'] = "Failed to send reply!";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Reply cannot be empty!";
    }
}

// Fetch messages from the database
$sql = "SELECT * FROM contact_messages ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Messages</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>View Messages</h2>

    <?php if (isset($_SESSION['success'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php } ?>

    <?php if (isset($_SESSION['error'])) { ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php } ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Reply</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['message']}</td>
                        <td>" . (!empty($row['reply']) ? $row['reply'] : "No reply yet") . "</td>
                        <td>
                            <button class='btn btn-primary btn-sm' onclick='showReplyForm({$row['id']})'>Reply</button>
                        </td>
                    </tr>";
                    echo "<tr id='replyForm{$row['id']}' style='display: none;'>
                        <td colspan='6'>
                            <form method='POST'>
                                <input type='hidden' name='message_id' value='{$row['id']}'>
                                <textarea name='reply_text' class='form-control' placeholder='Type your reply here...'></textarea>
                                <button type='submit' name='reply_message' class='btn btn-success btn-sm mt-2'>Send Reply</button>
                                <button type='button' class='btn btn-secondary btn-sm mt-2' onclick='hideReplyForm({$row['id']})'>Cancel</button>
                            </form>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No messages found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script>
function showReplyForm(id) {
    document.getElementById('replyForm' + id).style.display = 'table-row';
}
function hideReplyForm(id) {
    document.getElementById('replyForm' + id).style.display = 'none';
}
</script>

</body>
</html>

<?php $conn->close(); ?>
