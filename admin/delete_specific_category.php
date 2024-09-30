<?php
// Include the database connection file
include 'db_connect.php';

// Check if the specific category ID is set
if (isset($_GET['category_id'])) {
    $specific_category_id = $_GET['category_id'];
    $general_category_id = $_GET['general_category_id']; // Keep track of the general category ID

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Delete the specific category from the `specific_category` table
        $sql_specific_category = "DELETE FROM specific_category WHERE specific_category_id = ?";
        $stmt_specific_category = $conn->prepare($sql_specific_category);
        $stmt_specific_category->bind_param('i', $specific_category_id);
        $stmt_specific_category->execute();

        // Delete any related records in other tables (example: books, authors, etc.)
        // Example for books related to the specific category:
        $sql_books = "DELETE FROM books WHERE specific_category_id = ?";
        $stmt_books = $conn->prepare($sql_books);
        $stmt_books->bind_param('i', $specific_category_id);
        $stmt_books->execute();

        // You can add more DELETE statements here for other related tables if necessary
        // Example: $sql_related = "DELETE FROM related_table WHERE specific_category_id = ?";
        // Add additional DELETE queries for other tables as needed

        // If everything is successful, commit the transaction
        $conn->commit();

        // Redirect back to the category folder page with a success message
        header("Location: category-folder.php?category_id=" . $general_category_id . "&success=Category and related records deleted successfully");
        exit();
    } catch (Exception $e) {
        // If an error occurs, roll back the transaction
        $conn->rollback();
        echo "Error deleting category: " . $e->getMessage();
    }

} else {
    // If no category ID is set, redirect to the manage categories page
    header("Location: manage-categories.php");
    exit();
}
?>
