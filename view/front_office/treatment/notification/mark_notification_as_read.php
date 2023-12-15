<?php
// Include your PDO connection here
require '../../../../model/db_connect_front.php';
require '../../../../model/sessions_start.php';  // Replace 'path_to_your_connection_file.php' with the actual path

// Check if the notification ID is received via POST method
if (isset($_POST['id'])) {
    $notificationId = $_POST['id'];

    try {
        // Prepare and execute a query to update the status of the notification to "read"
        $stmt = $pdo->prepare("UPDATE notification SET status = 'read' WHERE id = :id");
        $stmt->bindParam(':id', $notificationId);
        $stmt->execute();

        // Send a success response back
        echo json_encode(array('message' => 'Notification marked as read successfully'));
    } catch (PDOException $e) {
        // Handle exceptions if any
        echo json_encode(array('error' => 'Error marking notification as read: ' . $e->getMessage()));
    }
} else {
    // If the notification ID is not provided in the request
    echo json_encode(array('error' => 'Notification ID not provided'));
}
?>
