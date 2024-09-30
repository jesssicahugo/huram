<?php
// Include the database connection file
include 'db_connect.php';

// Get the specific category ID from the URL
$specific_category_id = isset($_GET['specific_category_id']) ? $_GET['specific_category_id'] : 0;

// Query to get books under the selected specific category along with author names
$books_query = "SELECT books.*, authors.author_name 
                FROM books 
                JOIN authors ON books.author_id = authors.author_id 
                WHERE specific_category_id = ? 
                ORDER BY book_title ASC";
$stmt = $conn->prepare($books_query);
$stmt->bind_param("i", $specific_category_id);
$stmt->execute();
$books_result = $stmt->get_result();

// Check if the query was successful
if ($books_result === false) {
    echo "Error: " . $conn->error;
} else {
    ?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Metas -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Books</title>

    <!-- Include stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        .book-container {
            cursor: pointer;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fc;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .book-container:hover {
            background-color: #e2e6ea;
        }

        .book-details {
            display: none;
            margin-top: 10px;
            font-weight: normal;
        }

        .category-wrapper {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .issuance-button {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 5px 10px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <!-- Include the header to match the dashboard -->
    <?php include 'header2.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Custom container for books -->
            <div class="category-wrapper mb-5">
                <h1 class="h3 mb-4 text-gray-800">Books in This Category</h1>

                <div class="row category-container">
                    <?php
                    if ($books_result->num_rows > 0) {
                        while ($row = $books_result->fetch_assoc()) {
                            $book_id = $row['book_id'];
                            $book_title = $row['book_title'];
                            $isbn = $row['isbn'];
                            $author_name = $row['author_name'];
                            $no_of_copies = $row['no_of_copies'];
                            $publication_date = $row['publication_date'];
                            $availability = $row['availability'];
                            ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <div class="book-container" onclick="toggleDetails(<?php echo $book_id; ?>)">
                                    <?php echo $book_title; ?>
                                    
                                    <!-- Issuance Button at the right corner -->
                                    <button class="btn btn-primary btn-sm issuance-button" onclick="issueBook(<?php echo $book_id; ?>, '<?php echo urlencode($book_title); ?>', '<?php echo urlencode($isbn); ?>', '<?php echo urlencode($author_name); ?>', event)">Reserve</button>
                                    
                                    <div class="book-details" id="details-<?php echo $book_id; ?>">
                                        <p><strong>ISBN:</strong> <?php echo $isbn; ?></p>
                                        <p><strong>Author:</strong> <?php echo $author_name; ?></p>
                                        <p><strong>Number of Copies:</strong> <?php echo $no_of_copies; ?></p>
                                        <p><strong>Publication Date:</strong> <?php echo $publication_date; ?></p>
                                        <p><strong>Availability:</strong> <?php echo $availability; ?></p>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div>No books found in this category.</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Include the footer to match the dashboard -->
    <?php include 'footer.php'; ?>

    <!-- JavaScript files -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom script for toggling details -->
    <script>
        function toggleDetails(bookId) {
            var details = document.getElementById('details-' + bookId);
            if (details.style.display === 'none' || details.style.display === '') {
                details.style.display = 'block';
            } else {
                details.style.display = 'none';
            }
        }

        function issueBook(bookId, bookTitle, isbn, author, event) {
            event.stopPropagation();
            window.location.href = 'reserve_book.php?book_id=' + bookId + '&book_title=' + bookTitle + '&isbn=' + isbn + '&author=' + author;
        }

    </script>
</body>

</html>

<?php
}
?>
