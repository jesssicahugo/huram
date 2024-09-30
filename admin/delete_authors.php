<?php
// Include the database connection file
include 'db_connect.php';

// Get the author ID from the URL
$author_id = isset($_GET['author_id']) ? (int)$_GET['author_id'] : 0;

// Check if a valid author ID is provided
if ($author_id > 0) {
    // Delete the author from the database
    $sql = "DELETE FROM authors WHERE author_id = $author_id";
    
    if ($conn->query($sql) === TRUE) {
        // Redirect to the manage authors page with a success message
        header("Location: manage_authors.php?success=Author deleted successfully");
        exit();
    } else {
        // If an error occurs, display the error message
        echo "Error deleting author: " . $conn->error;
    }
} else {
    // Redirect to manage authors page if no valid author ID is provided
    header("Location: manage_authors.php?error=Invalid author ID");
    exit();
}

$conn->close();
?>
