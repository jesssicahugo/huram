<?php
// Start session
session_start();

// Include database connection
include 'db_connect.php';

// Assuming user is logged in and their ID is stored in the session
$user_id = $_SESSION['user_id'];

// Fetch notifications for the logged-in user
$sql = "SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}
echo json_encode($notifications); // Return JSON for AJAX to fetch later
?>

<script>
$(document).ready(function() {
    // Fetch notifications
    function loadNotifications() {
        $.ajax({
            url: 'notif.php', // Fetch notifications from notif.php
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                var notifList = $('#notif-list');
                var notifCount = data.length; // Count of notifications
                
                $('#notif-count').text(notifCount > 0 ? notifCount : ''); // Update the badge
                
                notifList.empty(); // Clear any existing notifications

                if (notifCount > 0) {
                    // Loop through notifications and append to the dropdown
                    $.each(data, function(index, notification) {
                        notifList.append(`
                            <a class="dropdown-item" href="#">
                                <small>${notification.created_at}</small><br/>
                                ${notification.message}
                            </a>
                        `);
                    });
                } else {
                    notifList.append('<a class="dropdown-item text-center">No new notifications</a>');
                }
            }
        });
    }

    // Call function to load notifications when the dropdown is clicked
    $('#notifDropdown').on('click', function() {
        loadNotifications();
    });
});
</script>
