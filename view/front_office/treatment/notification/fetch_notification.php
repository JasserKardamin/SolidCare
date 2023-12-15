<?php
require '../../../../model/db_connect_front.php';
require '../../../../model/sessions_start.php';  

// Check if the role cookie is set
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];

    // Fetch notifications based on the role
    $notificationQuery = $pdo->prepare("SELECT * FROM notification WHERE cin_recipent = :cin AND status = 'unread'");
    
    // Adjust the query based on the role (assuming 'cin' is the column representing the user's identifier)
    if ($role === 'nurse') {
        $notificationQuery->bindParam(':cin', $_SESSION['cin']);
    } elseif ($role === 'patient') {
        $notificationQuery->bindParam(':cin', $_SESSION['cin']);
    }

    $notificationQuery->execute();
    $notifications = $notificationQuery->fetchAll(PDO::FETCH_ASSOC);

    // Return notifications as JSON
    echo json_encode($notifications);
} else {
    // Redirect or handle unauthorized access
    header('Location: ../../user/login.html');
}
?>
