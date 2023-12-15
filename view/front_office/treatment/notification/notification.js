$(document).ready(function() {
    // Function to fetch notifications
    function fetchNotifications() {
        $.ajax({
            url: '../notification/fetch_notification.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                // Process the received notifications and display them in the UI
               console.log(response);
                displayNotifications(response);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:');
                console.log('XHR:', xhr);
                console.log('Status:', status);
                console.log('Error:', error);
            }
        });
    }

    // Function to display notifications as pop-ups and mark them as read
// Function to display notifications as pop-ups and provide a close button to remove them
function displayNotifications(notifications) {
    var notificationsContainer = document.getElementById('notifications-container');

    for (var i = 0; i < notifications.length; i++) {
        (function(index) {
            var notificationDiv = document.createElement('div');
            notificationDiv.classList.add('notification-item');

            var notificationContent = document.createElement('span');
            notificationContent.textContent = notifications[index].message_content;

            var closeButton = document.createElement('span');
            closeButton.textContent = '❌'; // Unicode character for a cross mark

            // Add a click event listener to the close button
            closeButton.addEventListener('click', function() {
                markNotificationAsRead(notifications[index].id); // Mark the notification as read
                notificationDiv.remove(); // Remove the notification on close button click
            });

            notificationDiv.appendChild(notificationContent);
            notificationDiv.appendChild(closeButton);
            notificationsContainer.appendChild(notificationDiv);

            setTimeout(function() {
                markNotificationAsRead(notifications[index].id);
                notificationDiv.remove(); // Remove the notification after a certain time
            }, 50000); // Adjust the time as needed (in milliseconds)
        })(i);
    }
}



    // Function to mark a notification as "read"
    function markNotificationAsRead(notificationId) {
        $.ajax({
            url: '../notification/mark_notification_as_read.php',
            method: 'POST',
            data: { id: notificationId },
            success: function(response) {
               
                // Handle the success response after marking the notification as read
                console.log('Notification marked as read:', response);
            },
            error: function(error) {
                console.error('Error marking notification as read:', error);
            }
        });
    }

    // Fetch notifications when the Nurse or Patient interface loads
    fetchNotifications();
});
