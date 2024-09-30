<?php
// Include the database connection file
include 'db_connect.php';

// Check if ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die('Book ID is missing.');
}

$book_id = intval($_GET['id']);

// Fetch book details
$sql = "SELECT * FROM books WHERE book_id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('No book found.');
}

$book = $result->fetch_assoc();

// Fetch authors
$sql_authors = "SELECT author_id, author_name FROM authors";
$result_authors = $conn->query($sql_authors);

// Fetch general categories
$sql_general_categories = "SELECT category_id, category_name FROM general_category";
$result_general_categories = $conn->query($sql_general_categories);

// Fetch specific categories based on the selected general category
$general_category_id = $book['general_category_id'];
$sql_specific_categories = "SELECT specific_category_id, specific_category_name FROM specific_category WHERE general_category_id = $general_category_id";
$result_specific_categories = $conn->query($sql_specific_categories);

// Update book
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and fetch POST data
    $book_title = $conn->real_escape_string($_POST['book_title']);
    $author_id = $conn->real_escape_string($_POST['author_id']);
    $general_category_id = $conn->real_escape_string($_POST['general_category_id']);
    $specific_category_id = $conn->real_escape_string($_POST['specific_category_id']);
    $isbn = $conn->real_escape_string($_POST['isbn']);
    $no_of_copies = $conn->real_escape_string($_POST['no_of_copies']);
    $available_for_borrowing = $conn->real_escape_string($_POST['available_for_borrowing']);
    $publication_date = $conn->real_escape_string($_POST['publication_date']);
    $availability = $conn->real_escape_string($_POST['availability']);

    $sql_update = "UPDATE books SET book_title='$book_title', author_id='$author_id', 
                   general_category_id='$general_category_id', specific_category_id='$specific_category_id',
                   isbn='$isbn', no_of_copies='$no_of_copies', available_for_borrowing='$available_for_borrowing',
                   publication_date='$publication_date', availability='$availability' 
                   WHERE book_id = $book_id";

    if ($conn->query($sql_update) === TRUE) {
        // Redirect with the category_id to maintain the category filter
        header("Location: added-books.php?category_id=$general_category_id&success=1");
        exit();
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include necessary meta tags and styles -->
    <title>Edit Book</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body>
<?php include 'index.php'; ?>
    <div class="container">
        <h2>Edit Book</h2>
        <form method="post">
            <div class="form-group">
                <label for="book_title">Book Title</label>
                <input type="text" class="form-control" id="book_title" name="book_title" value="<?php echo htmlspecialchars($book['book_title']); ?>" required>
            </div>
            <div class="form-group">
                <label for="author_id">Author</label>
                <select class="form-control" id="author_id" name="author_id" required>
                    <?php
                    while ($author = $result_authors->fetch_assoc()) {
                        $selected = ($author['author_id'] == $book['author_id']) ? 'selected' : '';
                        echo "<option value='{$author['author_id']}' $selected>{$author['author_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="general_category_id">General Category</label>
                <select class="form-control" id="general_category_id" name="general_category_id" required onchange="fetchSpecificCategories(this.value)">
                    <?php
                    while ($general_category = $result_general_categories->fetch_assoc()) {
                        $selected = ($general_category['category_id'] == $book['general_category_id']) ? 'selected' : '';
                        echo "<option value='{$general_category['category_id']}' $selected>{$general_category['category_name']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="specific_category_id">Specific Category</label>
                <select class="form-control" id="specific_category_id" name="specific_category_id" required>
                    <?php
                    while ($specific_category = $result_specific_categories->fetch_assoc()) {
                        $selected = ($specific_category['specific_category_id'] == $book['specific_category_id']) ? 'selected' : '';
                        echo "<option value='{$specific_category['specific_category_id']}' $selected>{$specific_category['specific_category_name']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="isbn">ISBN</label>
                <input type="text" class="form-control" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
            </div>
            <div class="form-group">
                <label for="no_of_copies">Number of Copies</label>
                <input type="number" class="form-control" id="no_of_copies" name="no_of_copies" value="<?php echo htmlspecialchars($book['no_of_copies']); ?>" required>
            </div>
            <div class="form-group">
                <label for="available_for_borrowing">Available for Borrowing</label>
                <input type="number" class="form-control" id="available_for_borrowing" name="available_for_borrowing" value="<?php echo htmlspecialchars($book['available_for_borrowing']); ?>" required>
            </div>
            <div class="form-group">
                <label for="publication_date">Publication Date</label>
                <input type="date" class="form-control" id="publication_date" name="publication_date" value="<?php echo htmlspecialchars($book['publication_date']); ?>" required>
            </div>
            <div class="form-group">
                <label for="availability">Availability</label>
                <select class="form-control" id="availability" name="availability" required>
                    <option value="For Borrowing" <?php echo ($book['availability'] == 'For Borrowing') ? 'selected' : ''; ?>>For Borrowing</option>
                    <option value="Only In Library" <?php echo ($book['availability'] == 'Only In Library') ? 'selected' : ''; ?>>Only In Library</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Book</button>
        </form>
    </div>

    <script>
        function fetchSpecificCategories(generalCategoryId) {
            $.ajax({
                url: 'fetch_specific_categories.php',
                type: 'POST',
                data: { general_category_id: generalCategoryId },
                success: function(response) {
                    $('#specific_category_id').html(response);
                }
            });
        }
    </script>
</body>
</html>
