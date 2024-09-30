<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_logged_in'])) {
    header("Location: login.php");
    exit;
}

// Include database connection
include 'db_connect.php';

// Fetch reserved books data, with pickup date calculated as 24 hours after reservation date
$sql = "SELECT r.reservation_id, b.book_title, u.fullname, 
        DATE_FORMAT(r.reservation_date, '%Y-%m-%d %h:%i %p') AS reservation_date, 
        DATE_FORMAT(DATE_ADD(r.reservation_date, INTERVAL 1 DAY), '%Y-%m-%d %h:%i %p') AS pickup_date
        FROM reservations r
        JOIN books b ON r.book_id = b.book_id
        JOIN users u ON r.student_id = u.id";

$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Books</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        .table-container {
            margin-top: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f8f9fa;
        }
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <?php include 'header2.php'; ?>

    <div class="container table-container">
        <h2>Reserved Books</h2>
        <div class="card">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Book Title</th>
                        <th>Reserved By</th>
                        <th>Reservation Date</th>
                        <th>Pickup Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result && $result->num_rows > 0) {
                        $no = 1;
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row['book_title'] . "</td>";
                            echo "<td>" . $row['fullname'] . "</td>";
                            echo "<td>" . $row['reservation_date'] . "</td>";
                            echo "<td>" . $row['pickup_date'] . "</td>";  // This is now 24 hours after reservation_date
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No reserved books found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table> 
        </div>
    </div>

    <?php include 'footer.php'; ?>
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
