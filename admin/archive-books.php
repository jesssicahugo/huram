<?php
// Include the database connection file
include 'db_connect.php';

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    // Fetch the book details that need to be archived
    $sql_select = "SELECT * FROM books WHERE book_id = ?";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bind_param('i', $book_id);
    $stmt_select->execute();
    $result = $stmt_select->get_result();

    if ($result->num_rows > 0) {
        // Fetch the book data
        $book = $result->fetch_assoc();

        // Insert the book into archived_books
        $sql_archive = "INSERT INTO archived_books (book_id, book_title, author_id, general_category_id, specific_category_id, isbn, no_of_copies, available_for_borrowing, publication_date, availability)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_archive = $conn->prepare($sql_archive);
        $stmt_archive->bind_param('isiisiisss', 
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

        // Execute the archive query
        if ($stmt_archive->execute()) {
            // Delete the book from the books table after archiving
            $sql_delete = "DELETE FROM books WHERE book_id = ?";
            $stmt_delete = $conn->prepare($sql_delete);
            $stmt_delete->bind_param('i', $book_id);
            $stmt_delete->execute();

            // Redirect to the page showing the list of books (or archived books)
            header("Location: archived-books.php");
            exit();
        } else {
            echo "Error archiving book: " . $conn->error;
        }

        // Close the statement
        $stmt_archive->close();
        $stmt_delete->close();
    }

    // Close the select statement
    $stmt_select->close();
}

// Close the database connection
$conn->close();
?>
