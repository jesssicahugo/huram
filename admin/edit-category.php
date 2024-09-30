<?php
// Include the database connection file
include 'db_connect.php';

// Check if the form was submitted
if (isset($_POST['submit'])) {
    $category_id = $_POST['category_id'];
    $category_name = $_POST['category_name'];

    // Update the category in the database
    $sql = "UPDATE general_category SET category_name = '$category_name' WHERE category_id = $category_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: category-folder.php?success=Category updated successfully");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Check if a category ID was provided
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Fetch the current category data
    $sql = "SELECT * FROM general_category WHERE category_id = $category_id";
    $result = $conn->query($sql);
    $category = $result->fetch_assoc();
} else {
    header("Location: category-folder.php");
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

    <title>Edit Category</title>

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
            <h1 class="h3 mb-4 text-gray-800">Edit Category</h1>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Edit Category Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Category</h6>
                        </div>
                        <div class="card-body">
                            <form action="edit-category.php" method="post">
                                <input type="hidden" name="category_id" value="<?php echo $category['category_id']; ?>">

                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name" value="<?php echo $category['category_name']; ?>" required>
                                </div>

                                <button type="submit" name="submit" class="btn btn-primary">Update Category</button>
                                <a href="category-folder.php" class="btn btn-secondary">Cancel</a>
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
