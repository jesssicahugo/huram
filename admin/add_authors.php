<?php
// Include the database connection file
include 'db_connect.php';

// Insert author into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = $conn->real_escape_string($_POST['author_name']);
    
    $sql = "INSERT INTO authors (author_name) VALUES ('$author_name')";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the Manage Authors page after successful addition
        header("Location: manage_authors.php?success=1");
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

    <title>Add Author</title>

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
            <h1 class="h3 mb-4 text-gray-800">Add Author</h1>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Add Author Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">New Author</h6>
                        </div>
                        <div class="card-body">
                            <form action="add_authors.php" method="post">
                                <div class="form-group">
                                    <label for="author_name">Author Name</label>
                                    <input type="text" class="form-control" id="author_name" name="author_name" placeholder="Enter author name" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Author</button>
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
