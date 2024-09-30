<?php
// Include database connection
include 'db_connect.php';

// Check if issuance_id is provided
if (!isset($_GET['issuance_id']) || empty($_GET['issuance_id'])) {
    die('Issuance ID is missing.');
}

$issuance_id = intval($_GET['issuance_id']);

// Fetch issuance details
$sql = "SELECT * FROM issuances WHERE issuance_id = $issuance_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die('No issuance found.');
}

$issuance = $result->fetch_assoc();

// Fetch users (students)
$sql_users = "SELECT id, fullname FROM users";
$result_users = $conn->query($sql_users);

// Fetch books
$sql_books = "SELECT book_id, book_title FROM books";
$result_books = $conn->query($sql_books);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Issuance</title>
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">
<?php include 'index.php'; ?>
    <div class="container-fluid">
        <h1 class="h3 mb-4 text-gray-800">Edit Issuance</h1>
        <form action="update_issuance.php" method="post">
            <input type="hidden" name="issuance_id" value="<?php echo $issuance['issuance_id']; ?>">
            
            <!-- Student Details -->
            <div class="form-group">
                <label for="user_id">Student Name</label>
                <select class="form-control" id="user_id" name="user_id" required>
                    <?php
                    while ($user = $result_users->fetch_assoc()) {
                        $selected = ($user['id'] == $issuance['user_id']) ? 'selected' : '';
                        echo "<option value='{$user['id']}' $selected>{$user['fullname']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Book Details -->
            <div class="form-group">
                <label for="book_id">Book Title</label>
                <select class="form-control" id="book_id" name="book_id" required>
                    <?php
                    while ($book = $result_books->fetch_assoc()) {
                        $selected = ($book['book_id'] == $issuance['book_id']) ? 'selected' : '';
                        echo "<option value='{$book['book_id']}' $selected>{$book['book_title']}</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Issuance Dates -->
            <div class="form-group">
                <label for="issue_date">Issue Date</label>
                <input type="date" class="form-control" id="issue_date" name="issue_date" value="<?php echo $issuance['issue_date']; ?>" required>
            </div>
            <div class="form-group">
                <label for="return_date">Return Date</label>
                <input type="date" class="form-control" id="return_date" name="return_date" value="<?php echo $issuance['return_date']; ?>">
            </div>

            <!-- Fine Details -->
            <div class="form-group">
                <label for="fine">Fine (if any)</label>
                <input type="number" class="form-control" id="fine" name="fine" value="<?php echo $issuance['fine']; ?>" step="0.01">
            </div>

            <!-- Return Status -->
            <div class="form-group">
                <label for="return_status">Return Status</label>
                <select class="form-control" id="return_status" name="return_status" required>
                    <option value="not returned" <?php echo ($issuance['return_status'] == 'not returned') ? 'selected' : ''; ?>>Not Returned</option>
                    <option value="returned" <?php echo ($issuance['return_status'] == 'returned') ? 'selected' : ''; ?>>Returned</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Issuance</button>
        </form>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
</body>

</html>
