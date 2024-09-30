<?php
// Include the database connection file
include 'db_connect.php';

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Insert book into the database
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_title = $conn->real_escape_string($_POST['book_title']);
    $author_id = $conn->real_escape_string($_POST['author_id']);
    $general_category_id = $conn->real_escape_string($_POST['general_category_id']);
    $specific_category_id = $conn->real_escape_string($_POST['specific_category_id']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $no_of_copies = $conn->real_escape_string($_POST['no_of_copies']);
    $available_for_borrowing = $conn->real_escape_string($_POST['available_for_borrowing']);
    $publication_date = $conn->real_escape_string($_POST['publication_date']);
    $availability = $conn->real_escape_string($_POST['availability']);

    $sql = "INSERT INTO books (book_title, author_id, general_category_id, specific_category_id, isbn, no_of_copies, available_for_borrowing, publication_date, availability) 
            VALUES ('$book_title', '$author_id', '$general_category_id', '$specific_category_id', '$isbn', '$no_of_copies', '$available_for_borrowing', '$publication_date', '$availability')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the Manage Books page after successful addition
        header("Location: added-books.php?success=1");
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

    <title>Add Book</title>

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
            <h1 class="h3 mb-4 text-gray-800">Add Book</h1>

            <div class="row">
                <div class="col-lg-6">
                    <!-- Add Book Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">New Book</h6>
                        </div>
                        <div class="card-body">
                            <form action="add-book.php" method="post">
                                <div class="form-group">
                                    <label for="book_title">Book Title</label>
                                    <input type="text" class="form-control" id="book_title" name="book_title" placeholder="Enter book title" required>
                                </div>
                                <div class="form-group">
                                    <label for="author_id">Author</label>
                                    <select class="form-control" id="author_id" name="author_id" required>
                                        <option value="">Select Author</option>
                                        <?php
                                        // Fetch authors from database
                                        $result = $conn->query("SELECT author_id, author_name FROM authors");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['author_id']}'>{$row['author_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="general_category_id">General Category</label>
                                    <select class="form-control" id="general_category_id" name="general_category_id" required>
                                        <option value="">Select General Category</option>
                                        <?php
                                        // Fetch general categories from database
                                        $result = $conn->query("SELECT category_id, category_name FROM general_category");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['category_id']}'>{$row['category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="specific_category_id">Specific Category</label>
                                    <select class="form-control" id="specific_category_id" name="specific_category_id" required>
                                        <option value="">Select Specific Category</option>
                                        <?php
                                        // Fetch specific categories from database
                                        $result = $conn->query("SELECT specific_category_id, specific_category_name FROM specific_category");
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<option value='{$row['specific_category_id']}'>{$row['specific_category_name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="isbn">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN" required>
                                </div>
                                <div class="form-group">
                                    <label for="no_of_copies">Number of Copies</label>
                                    <input type="number" class="form-control" id="no_of_copies" name="no_of_copies" placeholder="Enter number of copies" required>
                                </div>
                                <div class="form-group">
                                    <label for="available_for_borrowing">Quantity Available for Borrowing</label>
                                    <input type="number" class="form-control" id="available_for_borrowing" name="available_for_borrowing" placeholder="Enter available quantity" required>
                                </div>
                                <div class="form-group">
                                    <label for="publication_date">Publication Date</label>
                                    <input type="date" class="form-control" id="publication_date" name="publication_date" required>
                                </div>
                                <div class="form-group">
                                    <label for="availability">Availability</label>
                                    <select class="form-control" id="availability" name="availability" required>
                                        <option value="For Borrowing">For Borrowing</option>
                                        <option value="Only In Library">Only In Library</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Book</button>
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
 