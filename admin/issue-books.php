<?php
// Include the database connection file
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $book_id = (int)$_POST['book_id'];
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];
    $fine = (float)$_POST['fine']; // Capture the fine amount

    // Sanitize dates
    $issue_date = $conn->real_escape_string($issue_date);
    $return_date = !empty($return_date) ? $conn->real_escape_string($return_date) : NULL;

    // Convert dates to timestamps for comparison
    $issue_date_timestamp = strtotime($issue_date);
    $return_date_timestamp = $return_date ? strtotime($return_date) : NULL;

    // Check if return date is valid
    if ($return_date_timestamp !== NULL && $return_date_timestamp < $issue_date_timestamp) {
        echo "Return date cannot be earlier than issue date.";
        exit;
    }

    // Prepare and execute the issuance query
    $sql = "INSERT INTO issuances (user_id, book_id, issue_date, return_date, fine)
            VALUES ($user_id, $book_id, '$issue_date', " . ($return_date ? "'$return_date'" : 'NULL') . ", $fine)";

    if ($conn->query($sql) === TRUE) {
        // Decrease available_for_borrowing by 1 for the issued book
        $update_book_sql = "UPDATE books SET available_for_borrowing = available_for_borrowing - 1 WHERE book_id = $book_id";
        $conn->query($update_book_sql); // Execute the update query

        header("Location: manage_issuance.php"); // Redirect to manage issuance page
        exit;
    } else {
        echo "Error: " . $conn->error;
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
    <title>Issue Book</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>
</head>
<body id="page-top">
    <?php include 'index.php'; ?>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Issue Book</h1>
            <div class="row">
                <div class="col-lg-6">
                    <!-- Issue Book Form -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Book Issuance</h6>
                        </div>
                        <div class="card-body">
                            <form action="issue-books.php" method="post">
                                <!-- Student Details -->
                                <div class="form-group">
                                    <label for="student_id">Student ID</label>
                                    <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student ID" required>
                                    <input type="hidden" id="user_id" name="user_id">
                                </div>
                                <div id="student_info" style="display: none;">
                                    <div class="form-group">
                                        <label for="fullname">Full Name</label>
                                        <input type="text" class="form-control" id="fullname" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="text" class="form-control" id="email" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="course">Course</label>
                                        <input type="text" class="form-control" id="course" readonly>
                                    </div>
                                </div>

                                <!-- Book Details -->
                                <div class="form-group">
                                    <label for="isbn">ISBN</label>
                                    <input type="text" class="form-control" id="isbn" name="isbn" placeholder="Enter ISBN" required>
                                    <input type="hidden" id="book_id" name="book_id">
                                </div>
                                <div id="book_info" style="display: none;">
                                    <div class="form-group">
                                        <label for="book_title">Book Title</label>
                                        <input type="text" class="form-control" id="book_title" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="author_name">Author</label>
                                        <input type="text" class="form-control" id="author_name" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="general_category_name">General Category</label>
                                        <input type="text" class="form-control" id="general_category_name" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="specific_category_name">Specific Category</label>
                                        <input type="text" class="form-control" id="specific_category_name" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="publication_date">Publication Date</label>
                                        <input type="text" class="form-control" id="publication_date" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="no_of_copies">Number of Copies</label>
                                        <input type="text" class="form-control" id="no_of_copies" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="availability">Availability</label>
                                        <input type="text" class="form-control" id="availability" readonly>
                                    </div>
                                </div>

                                <!-- Issuance Dates -->
                                <div class="form-group">
                                    <label for="issue_date">Issue Date</label>
                                    <input type="date" class="form-control" id="issue_date" name="issue_date" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                <div class="form-group">
                                    <label for="return_date">Return Date</label>
                                    <input type="date" class="form-control" id="return_date" name="return_date">
                                </div>

                                <!-- Fine Details -->
                                <div class="form-group">
                                    <label for="fine">Fine (if any)</label>
                                    <input type="number" class="form-control" id="fine" name="fine" value="0" step="0.01">
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Issue Book</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Page Wrapper -->

    <!-- AJAX Script to Fetch Data -->
    <script>
    $(document).ready(function() {
        // Fetch student information based on student ID
        $('#student_id').on('input', function() {
            var student_id = $(this).val();
            if (student_id.length > 2) {
                $.ajax({
                    url: 'fetch_student.php',
                    method: 'POST',
                    data: { student_id: student_id },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $('#user_id').val(data.id);
                            $('#fullname').val(data.fullname);
                            $('#email').val(data.email);
                            $('#course').val(data.course);
                            $('#student_info').show();
                        } else {
                            $('#student_info').hide();
                        }
                    }
                });
            } else {
                $('#student_info').hide();
            }
        });

        // Fetch book information based on ISBN
        $('#isbn').on('input', function() {
            var isbn = $(this).val();
            if (isbn.length > 2) {
                $.ajax({
                    url: 'fetch_book.php',
                    method: 'POST',
                    data: { isbn: isbn },
                    dataType: 'json',
                    success: function(data) {
                        if (data) {
                            $('#book_id').val(data.book_id);
                            $('#book_title').val(data.book_title);
                            $('#author_name').val(data.author_name);
                            $('#general_category_name').val(data.general_category);
                            $('#specific_category_name').val(data.specific_category);
                            $('#publication_date').val(data.publication_date);
                            $('#no_of_copies').val(data.no_of_copies);
                            $('#availability').val(data.available_for_borrowing);
                            $('#book_info').show();
                        } else {
                            $('#book_info').hide();
                        }
                    }
                });
            } else {
                $('#book_info').hide();
            }
        });
    });
    </script>
</body>
</html>
