<?php
// Include the database connection file
include 'db_connect.php';

// Get the author ID from the URL
$author_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $author_name = $conn->real_escape_string($_POST['author_name']);

    // Update the author in the database
    $sql = "UPDATE authors SET author_name = '$author_name' WHERE author_id = $author_id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the manage authors page with a success message
        header("Location: manage_authors.php?success=Author updated successfully");
        exit();
    } else {
        echo "Error updating author: " . $conn->error;
    }
}

// Fetch the current author details from the database
$sql = "SELECT * FROM authors WHERE author_id = $author_id LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $author = $result->fetch_assoc();
} else {
    // If no author found, redirect back to the manage authors page
    header("Location: manage_authors.php?error=Author not found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Author</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
<?php include 'index.php'; ?>

    <div id="wrapper">
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">Edit Author</h1>
            <div class="row">
                <div class="col-lg-6">
                    <!-- Edit Author Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Author</h6>
                        </div>
                        <div class="card-body">
                            <form action="edit_authors.php?id=<?php echo $author_id; ?>" method="post">
                                <div class="form-group">
                                    <label for="author_name">Author Name</label>
                                    <input type="text" class="form-control" id="author_name" name="author_name" value="<?php echo $author['author_name']; ?>" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Author</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
</body>

</html>

<?php
$conn->close();
?>
