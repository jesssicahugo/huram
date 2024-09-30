<?php
// Include the database connection file
include 'db_connect.php';

// Fetch archived books from the archived_books table
$sql_books = "SELECT ab.book_id, ab.book_title, a.author_name, gc.category_name AS general_category, sc.specific_category_name, ab.isbn, ab.no_of_copies, ab.available_for_borrowing, ab.publication_date, ab.availability 
              FROM archived_books ab
              JOIN authors a ON ab.author_id = a.author_id
              JOIN general_category gc ON ab.general_category_id = gc.category_id
              JOIN specific_category sc ON ab.specific_category_id = sc.specific_category_id
              ORDER BY ab.book_title ASC";

$result_books = $conn->query($sql_books);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Archived Books</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>
<style>
    .btn-spacing {
        margin-bottom: 5px; /* Adjust the spacing as needed */
    }
</style>

<body id="page-top">
    <?php include 'index.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">List of Archived Books</h1>

            <!-- Display success message if book restored -->
            <?php if (isset($_GET['message']) && $_GET['message'] == 'restored') : ?>
                <div class="alert alert-success">Book restored successfully!</div>
            <?php endif; ?>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Books Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Book Title</th>
                                    <th>Author</th>
                                    <th>General Category</th>
                                    <th>Specific Category</th>
                                    <th>ISBN</th>
                                    <th>No. of Copies</th>
                                    <th>Available Copies</th>
                                    <th>Publication Date</th>
                                    <th>Availability</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result_books->num_rows > 0) {
                                    while ($row = $result_books->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>{$row['book_title']}</td>";
                                        echo "<td>{$row['author_name']}</td>";
                                        echo "<td>{$row['general_category']}</td>";
                                        echo "<td>{$row['specific_category_name']}</td>";
                                        echo "<td>{$row['isbn']}</td>";
                                        echo "<td>{$row['no_of_copies']}</td>";
                                        echo "<td>{$row['available_for_borrowing']}</td>";
                                        echo "<td>{$row['publication_date']}</td>";
                                        echo "<td>{$row['availability']}</td>";
                                        echo "<td>
                                                <a href='restore-books.php?id={$row['book_id']}' class='btn btn-success btn-sm' 
                                                onclick='return confirm(\"Are you sure you want to restore this book?\");'>Restore</a>
                                              </td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='10'>No archived books found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
