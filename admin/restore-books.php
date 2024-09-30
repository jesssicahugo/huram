<?php
// Include the database connection
include 'db_connect.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Get the book details from the archived_books table
    $sql_get_book = "SELECT * FROM archived_books WHERE book_id = ?";
    $stmt_get = $conn->prepare($sql_get_book);
    $stmt_get->bind_param("i", $book_id);
    $stmt_get->execute();
    $result = $stmt_get->get_result();
    $book = $result->fetch_assoc();

    if ($book) {
        // Insert the book back into the books table
        $sql_restore = "INSERT INTO books (book_id, book_title, author_id, general_category_id, specific_category_id, isbn, no_of_copies, available_for_borrowing, publication_date, availability)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Corrected the bind_param type string
        // 'isiiiissss' means:
        // i - integer, s - string
        $stmt_restore = $conn->prepare($sql_restore);
        $stmt_restore->bind_param(
            "isiiiissss", 
            $book['book_id'], 
            $book['book_title'], 
            $book['author_id'], 
            $book['general_category_id'], 
            $book['specific_category_id'], 
            $book['isbn'], 
            $book['no_of_copies'], 
            $book['available_for_borrowing'], 
            $book['publication_date'], 
            $book['availability']
        );
        
        if ($stmt_restore->execute()) {
            // Delete the book from archived_books after restoring
            $sql_delete_archived = "DELETE FROM archived_books WHERE book_id = ?";
            $stmt_delete = $conn->prepare($sql_delete_archived);
            $stmt_delete->bind_param("i", $book_id);
            $stmt_delete->execute();

            // Redirect to archived books list with a success message
            header("Location: added-books.php?message=restored");
            exit();
        } else {
            // Error handling
            echo "Error restoring the book: " . $conn->error;
        }
    }

    $stmt_get->close();
    $stmt_restore->close();
}

$conn->close();
?>