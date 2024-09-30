<?php
// Include the database connection file
include 'db_connect.php';

// Fetch general and specific categories from the database
$sql_general = "SELECT id, category_name, created_at FROM general_category ORDER BY id DESC";
$sql_specific = "SELECT sc.id, sc.specific_category_name, gc.category_name AS general_category_name, sc.created_at 
                 FROM specific_category sc 
                 JOIN general_category gc ON sc.general_category_id = gc.id 
                 ORDER BY sc.id DESC";

$result_general = $conn->query($sql_general);
$result_specific = $conn->query($sql_specific);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Categories</title>

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
            <h1 class="h3 mb-4 text-gray-800">Manage Categories</h1>

            <!-- Display success message if a category is added, edited, or deleted -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success">
                    <?php echo $_GET['success']; ?>
                </div>
            <?php endif; ?>

            <!-- General Categories Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">General Categories</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Category Name</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_general->num_rows > 0): ?>
                                    <?php while($row = $result_general->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['category_name']; ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td>
                                                <a href="edit-category.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete-category.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this category?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4">No general categories found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="add_category.php" class="btn btn-primary">Add New General Category</a>
                </div>
            </div>

            <!-- Specific Categories Table -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Specific Categories</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Specific Category Name</th>
                                    <th>General Category Name</th>
                                    <th>Date Added</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_specific->num_rows > 0): ?>
                                    <?php while($row = $result_specific->fetch_assoc()): ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['specific_category_name']; ?></td>
                                            <td><?php echo $row['general_category_name']; ?></td>
                                            <td><?php echo $row['created_at']; ?></td>
                                            <td>
                                                <a href="edit-specific-category.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete-specific-category.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this specific category?');">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5">No specific categories found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <a href="add_specific_category.php" class="btn btn-primary">Add New Specific Category</a>
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
