<?php
// Include the database connection file
include 'db_connect.php';

// Check if the 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete the author from the database
    $sql = "DELETE FROM authors WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the Manage Authors page with a success message
        header("Location: cards.php?success=Author deleted successfully");
        exit();
    } else {
        echo "Error deleting author: " . $conn->error;
    }
} else {
    // Redirect if 'id' is not set
    header("Location: cards.php?error=No author selected");
    exit();
}

$conn->close();
?>
