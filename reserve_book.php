<?php
// Include the database connection file and start session
include 'db_connect.php';
session_start(); // Start the session

// Initialize variables for messages and student information
$message = '';
$student_id = '';
$isbn = '';
$book_id = '';
$book_title = '';
$author = '';
$student_name = '';
$user_id = ''; // For storing the primary key 'id' from the users table

// Check if the user is logged in and retrieve the student ID from the session
if (isset($_SESSION['student_id'])) {
    $student_id = $_SESSION['student_id'];

    // Fetch the student name (fullname) and id (primary key) using the student ID
    $student_query = "SELECT id, fullname FROM users WHERE student_id = ?";
    $stmt = $conn->prepare($student_query);
    $stmt->bind_param("s", $student_id);  // Assuming student_id is a string
    $stmt->execute();
    $student_result = $stmt->get_result();

    if ($student_result->num_rows > 0) {
        $student_row = $student_result->fetch_assoc();
        $user_id = $student_row['id'];  // Get the 'id' column (primary key)
        $student_name = $student_row['fullname'];
    } else {
        $message = "Student not found.";
    }
}

// Get the book details from the URL
if (isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    $book_title = urldecode($_GET['book_title']);
    $isbn = urldecode($_GET['isbn']);
    $author = urldecode($_GET['author']);
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate input fields
    if (!empty($user_id) && !empty($isbn)) {
        // Check if the book is available for reservation
        $book_query = "SELECT book_id, no_of_copies, availability FROM books WHERE isbn = ? AND no_of_copies > 0 AND availability = 'For Borrowing'";
        $stmt = $conn->prepare($book_query);
        $stmt->bind_param("s", $isbn);
        $stmt->execute();
        $book_result = $stmt->get_result();

        if ($book_result->num_rows > 0) {
            // Fetch book details
            $book_row = $book_result->fetch_assoc();
            $book_id = $book_row['book_id'];

            // Insert the reservation into the reservations table
            $reserve_query = "INSERT INTO reservations (student_id, book_id, isbn, reservation_date) VALUES (?, ?, ?, NOW())";
            $reserve_stmt = $conn->prepare($reserve_query);
            $reserve_stmt->bind_param("iis", $user_id, $book_id, $isbn); // Use 'user_id' (the primary key 'id' from users)

            if ($reserve_stmt->execute()) {
                // Update the number of copies for the book
                $update_copies_query = "UPDATE books SET no_of_copies = no_of_copies - 1 WHERE book_id = ?";
                $update_stmt = $conn->prepare($update_copies_query);
                $update_stmt->bind_param("i", $book_id);
                $update_stmt->execute();

                $message = "Book reserved successfully!";
            } else {
                $message = "Error reserving the book: " . $conn->error;
            }
        } else {
            $message = "Book is not available for reservation.";
        }
    } else {
        $message = "Please enter the ISBN.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Book</title>

    <!-- Include Bootstrap and other styles -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/style.css" rel="stylesheet" />
    <style>
        /* Optional: Increase shadow and padding for the card */
        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 50px;
        }
    </style>
</head>

<body>
    <?php include 'header2.php'; ?>

    <div class="container mt-5"> <!-- Main container starts here -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <h2 class="mt-3 mb-3 text-center">Reserve Book</h2>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-info"><?php echo $message; ?></div>
                    <?php endif; ?>

                    <form method="post" action="">
                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" name="student_id" id="student_id" class="form-control" value="<?php echo htmlspecialchars($student_id); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="student_name">Student Name</label>
                            <input type="text" name="student_name" id="student_name" class="form-control" value="<?php echo htmlspecialchars($student_name); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="book_title">Book Title</label>
                            <input type="text" name="book_title" id="book_title" class="form-control" value="<?php echo htmlspecialchars($book_title); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="isbn">Book ISBN</label>
                            <input type="text" name="isbn" id="isbn" class="form-control" value="<?php echo htmlspecialchars($isbn); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" id="author" class="form-control" value="<?php echo htmlspecialchars($author); ?>" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Reserve</button>
                    </form>
                </div>
            </div>
        </div>
    </div> <!-- Main container ends here -->

    <?php include 'footer.php'; ?>

    <!-- JavaScript files -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>
</body>

</html>
