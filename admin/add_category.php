<?php
// Include the database connection file
include 'db_connect.php';

// Insert general category into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $category_name = $conn->real_escape_string($_POST['category_name']);
    
    // Insert into general_category table
    $sql = "INSERT INTO general_category (category_name) VALUES ('$category_name')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the Manage Categories page after successful addition
        header("Location: category-folder.php?success=1");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    
    $conn->close();
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

    <title>Add General Category</title>

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
            <h1 class="h3 mb-4 text-gray-800">Add General Category</h1>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Add Category Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">New General Category</h6>
                        </div>
                        <div class="card-body">
                            <form action="add_category.php" method="post">
                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter General Category name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add General Category</button>
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
