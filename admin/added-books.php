<?php
// Include the database connection file
include 'db_connect.php';

// Check if a category_id is passed
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

$sql_books = "SELECT b.book_id, b.book_title, a.author_name, gc.category_name AS general_category, sc.specific_category_name, b.isbn, b.no_of_copies, b.available_for_borrowing, b.publication_date, b.availability 
              FROM books b
              JOIN authors a ON b.author_id = a.author_id
              JOIN general_category gc ON b.general_category_id = gc.category_id
              JOIN specific_category sc ON b.specific_category_id = sc.specific_category_id";

// If a specific category is selected, filter by that category
if ($category_id) {
    $sql_books .= " WHERE b.specific_category_id = ?";
}

$sql_books .= " ORDER BY b.book_title ASC";

// Prepare the statement
$stmt = $conn->prepare($sql_books);

// Bind the category_id if it exists
if ($category_id) {
    $stmt->bind_param("i", $category_id);
}

$stmt->execute();
$result_books = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- (head content here) -->
</head>
<body id="page-top">
    <?php include 'index.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <h1 class="h3 mb-4 text-gray-800">List of Books</h1>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Books Information</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th>General Category</th>
                                    <th>Specific Category</th>
                                    <th>ISBN</th>
                                    <th>No. of Copies</th>
                                    <th>Available</th>
                                    <th>Publication Date</th>
                                    <th>Availability</th>
                                    <th>Actions</th> <!-- New column for action buttons -->
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($book = $result_books->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($book['book_title']); ?></td>
                                        <td><?php echo htmlspecialchars($book['author_name']); ?></td>
                                        <td><?php echo htmlspecialchars($book['general_category']); ?></td>
                                        <td><?php echo htmlspecialchars($book['specific_category_name']); ?></td>
                                        <td><?php echo htmlspecialchars($book['isbn']); ?></td>
                                        <td><?php echo htmlspecialchars($book['no_of_copies']); ?></td>
                                        <td><?php echo htmlspecialchars($book['available_for_borrowing']); ?></td>
                                        <td><?php echo htmlspecialchars($book['publication_date']); ?></td>
                                        <td><?php echo htmlspecialchars($book['availability']); ?></td>
                                        <td>
                                            <!-- Action buttons -->
                                            <a href="edit-books.php?id=<?php echo $book['book_id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                            <a href="archive-books.php?id=<?php echo $book['book_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to archive this book?');">Archive</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
