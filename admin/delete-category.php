<?php
// Include the database connection file
include 'db_connect.php';

// Check if a category ID was provided
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    // Delete the category from the database
    $sql = "DELETE FROM general_category WHERE category_id = $category_id";
    if ($conn->query($sql) === TRUE) {
        header("Location: category-folder.php?success=Category deleted successfully");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: category-folder.php");
}
?>
