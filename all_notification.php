<?php
// Start session
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <title>All Notifications</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>All Notifications</h1>
    <ul>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<li>" . $row['message'] . " - " . $row['created_at'] . "</li>";
            }
        } else {
            echo "<p>No notifications found.</p>";
        }
        ?>
    </ul>
</body>
</html>
