<?php
// Include the database connection file
include 'db_connect.php';

// Get the specific category name from the URL
$specific_category_name = $_GET['specific_category_name'];

// Fetch the specific category ID using the name
$specific_sql = "SELECT id FROM category WHERE specific_category_name = '$specific_category_name'";
$specific_result = $conn->query($specific_sql);

// Check if the query was successful
if (!$specific_result) {
    die("Error fetching specific category: " . $conn->error);
}

$specific_category = $specific_result->fetch_assoc();
$specific_category_id = $specific_category['id'];

// Fetch all books under this specific category, including author information
$books_sql = "
    SELECT books.*, authors.author_name
    FROM books
    JOIN authors ON books.author_id = authors.id
    WHERE books.specific_category_id = $specific_category_id
    ORDER BY books.book_name ASC
";
$books_result = $conn->query($books_sql);

// Check if the query was successful
if (!$books_result) {
    die("Error fetching books: " . $conn->error);
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

    <title>Books in <?php echo htmlspecialchars($specific_category_name, ENT_QUOTES, 'UTF-8'); ?></title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for displaying books -->
    <style>
        .table-container {
            margin: 20px 0;
        }
        
        .table th, .table td {
            text-align: center;
            vertical-align: middle;
        }
        
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .action-buttons a {
            text-decoration: none;
            color: #007bff;
        }

        .action-buttons a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body id="page-top">
    <?php include 'index.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Books in <?php echo htmlspecialchars($specific_category_name, ENT_QUOTES, 'UTF-8'); ?></h1>

            <!-- Books Table -->
            <div class="table-container">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Book Name</th>
                            <th>Author</th>
                            <th>Publication Date</th>
                            <th>ISBN</th>
                            <th>Availability</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($books_result->num_rows > 0) {
                            while ($book = $books_result->fetch_assoc()) {
                                $book_name = htmlspecialchars($book['book_name'], ENT_QUOTES, 'UTF-8');
                                $author_name = htmlspecialchars($book['author_name'], ENT_QUOTES, 'UTF-8');
                                $publication_date = isset($book['publication_date']) ? htmlspecialchars($book['publication_date'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                $isbn = isset($book['isbn']) ? htmlspecialchars($book['isbn'], ENT_QUOTES, 'UTF-8') : 'N/A';
                                $availability = isset($book['availability']) ? htmlspecialchars($book['availability'], ENT_QUOTES, 'UTF-8') : 'Unknown';
                                $book_id = $book['id']; // Assuming you have an ID column in your books table
                                ?>
                                <tr>
                                    <td><?php echo $book_name; ?></td>
                                    <td><?php echo $author_name; ?></td>
                                    <td><?php echo $publication_date; ?></td>
                                    <td><?php echo $isbn; ?></td>
                                    <td><?php echo $availability; ?></td>
                                    <td class="action-buttons">
                                        <a href="edit_book.php?id=<?php echo $book_id; ?>">Edit</a> | 
                                        <a href="archive_book.php?id=<?php echo $book_id; ?>">Archive</a>
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            echo '<tr><td colspan="6" class="text-center">No books found under this category</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts -->
    <script src="js/sb-admin-2.min.js"></script>
</body>
</html>
