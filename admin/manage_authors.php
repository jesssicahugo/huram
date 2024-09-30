<?php
// Include the database connection file
include 'db_connect.php';

// Set the number of authors per page
$authors_per_page = 10;

// Get the current page number from the URL, if not set default to 1
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

// Calculate the starting row for the query
$start = ($page - 1) * $authors_per_page;

// Fetch the total number of authors in the database to calculate total pages
$sql_total = "SELECT COUNT(*) as total_authors FROM authors";
$result_total = $conn->query($sql_total);
$total_authors = $result_total->fetch_assoc()['total_authors'];

// Calculate the total number of pages needed
$total_pages = ceil($total_authors / $authors_per_page);

// Fetch authors for the current page
$sql = "SELECT * FROM authors ORDER BY author_id DESC LIMIT $start, $authors_per_page";
$result = $conn->query($sql);

// Error handling for query
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Authors</title>

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
        <div class="container-fluid">

            <h1 class="h3 mb-4 text-gray-800">Manage Authors</h1>

            <!-- Display success message if an author is added, edited, or deleted -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_GET['success']; ?>
                </div>
            <?php endif; ?>

            <!-- Authors Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Authors List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Author Name</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php
                                    $counter = $start + 1; // Start counter at the current page's first item
                                    while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $counter++; ?></td> <!-- Increment counter -->
                                            <td><?php echo $row['author_name']; ?></td>
                                            <td>
                                                <a href="edit_authors.php?id=<?php echo $row['author_id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete_authors.php?author_id=<?php echo $row['author_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this author?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3">No authors found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Controls -->
                    <nav aria-label="Pagination">
                        <ul class="pagination justify-content-center">
                            <!-- Previous Page Link -->
                            <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="<?php if ($page > 1) echo '?page=' . ($page - 1); ?>">Previous</a>
                            </li>

                            <!-- Page Numbers -->
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Page Link -->
                            <li class="page-item <?php if ($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="<?php if ($page < $total_pages) echo '?page=' . ($page + 1); ?>">Next</a>
                            </li>
                        </ul>
                    </nav>

                    <a href="add_authors.php" class="btn btn-primary">Add New Author</a>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>

<?php
$conn->close();
?>
