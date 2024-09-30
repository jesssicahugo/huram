<?php
// Start session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Include the database connection file
include 'db_connect.php';

// Check for a notification in the session and display it
if (isset($_SESSION['notification'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['notification'] . "</div>";
    // Remove the notification from the session after displaying it
    unset($_SESSION['notification']);
}

// Fetch reservation data
$sql = "SELECT r.reservation_id, u.fullname, b.book_title, r.reservation_date,
        DATE_FORMAT(r.reservation_date, '%Y-%m-%d %h:%i %p') AS reservation_date, 
        DATE_FORMAT(DATE_ADD(r.reservation_date, INTERVAL 12 HOUR), '%Y-%m-%d %h:%i %p') AS pickup_date
        FROM reservations r
        JOIN users u ON r.student_id = u.id
        JOIN books b ON r.book_id = b.book_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Manage Reservations</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <?php include 'index.php'; ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Manage Reservations</h1>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Reservations Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Reserved Books</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Reservation ID</th>
                                            <th>Student Name</th>
                                            <th>Book Title</th>
                                            <th>Reservation Date</th>
                                            <th>Pickup Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['reservation_id'] . "</td>";
                                                echo "<td>" . $row['fullname'] . "</td>";
                                                echo "<td>" . $row['book_title'] . "</td>";
                                                echo "<td>" . $row['reservation_date'] . "</td>";
                                                echo "<td>" . ($row['pickup_date'] ?? 'Not Set') . "</td>";
                                                echo "<td>";
                                                echo "<a href='accept_reservation.php?reservation_id=" . $row['reservation_id'] . "' class='btn btn-success btn-sm'>Accept</a> ";
                                                echo "<a href='reject.php?reservation_id=" . $row['reservation_id'] . "' class='btn btn-danger btn-sm'>Reject</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='6'>No records found.</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Page Wrapper -->
</body>
</html>
