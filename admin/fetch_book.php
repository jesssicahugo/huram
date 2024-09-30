<?php
// Include the database connection file
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isbn = $_POST['isbn'];

    // Query to fetch book details based on ISBN
    $sql = "SELECT book_id, book_title, author_id, general_category_id, specific_category_id, no_of_copies, publication_date, availability 
            FROM books WHERE isbn = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $isbn);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        
        // Fetch author name using author_id
        $author_sql = "SELECT author_name FROM authors WHERE author_id = ?";
        $author_stmt = $conn->prepare($author_sql);
        $author_stmt->bind_param('i', $book['author_id']);
        $author_stmt->execute();
        $author_result = $author_stmt->get_result();
        $author = $author_result->fetch_assoc();

        // Fetch general category using general_category_id
        $general_category_sql = "SELECT category_name FROM general_category WHERE category_id = ?";
        $general_category_stmt = $conn->prepare($general_category_sql);
        $general_category_stmt->bind_param('i', $book['general_category_id']);
        $general_category_stmt->execute();
        $general_category_result = $general_category_stmt->get_result();
        $general_category = $general_category_result->fetch_assoc();

        // Fetch specific category using specific_category_id
        $specific_category_sql = "SELECT specific_category_name FROM specific_category WHERE specific_category_id = ?";
        $specific_category_stmt = $conn->prepare($specific_category_sql);
        $specific_category_stmt->bind_param('i', $book['specific_category_id']);
        $specific_category_stmt->execute();
        $specific_category_result = $specific_category_stmt->get_result();
        $specific_category = $specific_category_result->fetch_assoc();

        // Return the book details along with the author name and categories
        echo json_encode([
            'book_id' => $book['book_id'],
            'book_title' => $book['book_title'],
            'author_name' => $author['author_name'],
            'general_category' => $general_category['category_name'],
            'specific_category' => $specific_category['specific_category_name'],
            'no_of_copies' => $book['no_of_copies'],
            'publication_date' => $book['publication_date'],
            'available_for_borrowing' => $book['availability']
        ]);
    } else {
        echo json_encode(null); // No book found
    }

    $stmt->close();
    $conn->close();
}
