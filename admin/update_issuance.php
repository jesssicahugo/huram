<?php
// Include database connection
include 'db_connect.php';

// Check if form data is provided
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $issuance_id = intval($_POST['issuance_id']);
    $user_id = intval($_POST['user_id']);
    $book_id = intval($_POST['book_id']);
    $issue_date = $_POST['issue_date'];
    $return_date = $_POST['return_date'];
    $fine = floatval($_POST['fine']);
    $return_status = $_POST['return_status'];

    // Update the issuance record
    $sql = "UPDATE issuances 
            SET user_id = '$user_id', 
                book_id = '$book_id', 
                issue_date = '$issue_date', 
                return_date = '$return_date', 
                fine = '$fine', 
                return_status = '$return_status' 
            WHERE issuance_id = '$issuance_id'";

    if ($conn->query($sql) === TRUE) {
        echo "Issuance updated successfully.";
        header("Location: manage_issuance.php"); // Redirect to manage issuances page
        exit;
    } else {
        echo "Error updating issuance: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request.";
}
?>
