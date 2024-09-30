<?php
// Include the database connection file
include 'db_connect.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $specific_category_id = $_POST['specific_category_id'];
    $specific_category_name = $_POST['specific_category_name'];

    // Update the specific category in the database
    $sql = "UPDATE specific_category SET specific_category_name = ? WHERE specific_category_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $specific_category_name, $specific_category_id);

    if ($stmt->execute()) {
        header("Location: specific-categories.php?category_id=" . $_POST['general_category_id'] . "&success=Category updated successfully");
    } else {
        echo "Error updating category.";
    }
} else {
    // Get specific category info
    if (isset($_GET['category_id'])) {
        $specific_category_id = $_GET['category_id'];

        // Fetch the specific category data
        $sql = "SELECT * FROM specific_category WHERE specific_category_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $specific_category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $specific_category = $result->fetch_assoc();
    } else {
        header("Location: manage-categories.php");
        exit();
    }
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

    <title>Edit Specific Category</title>

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
            <h1 class="h3 mb-4 text-gray-800">Edit Specific Category</h1>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Edit Specific Category Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Specific Category</h6>
                        </div>
                        <div class="card-body">
                            <form action="edit_specific_category.php" method="POST">
                                <input type="hidden" name="specific_category_id" value="<?php echo $specific_category['specific_category_id']; ?>">
                                <input type="hidden" name="general_category_id" value="<?php echo $specific_category['general_category_id']; ?>">

                                <div class="form-group">
                                    <label for="specific_category_name">Specific Category Name</label>
                                    <input type="text" class="form-control" id="specific_category_name" name="specific_category_name" value="<?php echo $specific_category['specific_category_name']; ?>" required>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Update Category</button>
                                <a href="specific-categories.php?category_id=<?php echo $specific_category['general_category_id']; ?>" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
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

<?php
// Close the database connection
$conn->close();
?>
