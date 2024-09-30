<?php
// Include the database connection file
include 'db_connect.php';

// Fetch issuance data with availability and return status for each book
$sql = "SELECT i.issuance_id, u.fullname, b.book_title, i.issue_date, i.return_date, i.fine, i.return_status, b.available_for_borrowing
        FROM issuances i
        JOIN users u ON i.user_id = u.id
        JOIN books b ON i.book_id = b.book_id";
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
    <title>Manage Issuance</title>
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
            <h1 class="h3 mb-4 text-gray-800">Manage Issuance</h1>
            <div class="row">
                <div class="col-lg-12">
                    <!-- Issuance Table -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Issued Books</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Issuance ID</th>
                                            <th>Student Name</th>
                                            <th>Book Title</th>
                                            <th>Issue Date</th>
                                            <th>Return Date</th>
                                            <th>Fine</th>
                                            <th>Return Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                echo "<tr>";
                                                echo "<td>" . $row['issuance_id'] . "</td>";
                                                echo "<td>" . $row['fullname'] . "</td>";
                                                echo "<td>" . $row['book_title'] . "</td>";
                                                echo "<td>" . $row['issue_date'] . "</td>";
                                                echo "<td>" . ($row['return_date'] ?? 'Not Returned') . "</td>";
                                                echo "<td>" . number_format($row['fine'], 2) . "</td>";
                                                echo "<td>" . ucfirst($row['return_status']) . "</td>"; // Display the return status
                                                echo "<td>";
                                                echo "<a href='edit_issuance.php?issuance_id=" . $row['issuance_id'] . "' class='btn btn-primary btn-sm'>Edit</a>";
                                                echo "</td>";
                                                echo "</tr>";
                                            }
                                        } else {
                                            echo "<tr><td colspan='8'>No records found.</td></tr>";
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