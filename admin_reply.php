<?php
include "db_connection.php";

if (isset($_POST['reply_submit'])) {
    $message_id = $_POST['message_id'];
    $reply_text = $_POST['reply'];

    // Update the contact_messages table with the admin reply
    $query = $conn->prepare("UPDATE contact_messages SET reply = ? WHERE id = ?");
    $query->bind_param("si", $reply_text, $message_id);
    
    if ($query->execute()) {
        echo "<script>alert('Reply sent successfully!'); window.location='contact_messages.php';</script>";
    } else {
        echo "<script>alert('Error sending reply.'); window.location='contact_messages.php';</script>";
    }
}
?>
