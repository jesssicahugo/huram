<?php
// Include the database connection file
include 'db_connect.php';

// Check if reservation_id is set
if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];

    // Fetch the reservation details
    $sql = "SELECT r.reservation_id, r.book_id, r.student_id, b.no_of_copies
            FROM reservations r
            JOIN books b ON r.book_id = b.book_id
            WHERE r.reservation_id = $reservation_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
        $book_id = $reservation['book_id'];
        $student_id = $reservation['student_id'];
        $no_of_copies = $reservation['no_of_copies'];

        // Check if there are available copies
        if ($no_of_copies > 0) {
            // Insert the reservation data into the issuance table
            $issue_date = date('Y-m-d H:i:s'); // Current date and time for the issue date
            $sql_insert = "INSERT INTO issuances (user_id, book_id, issue_date) 
                           VALUES ($student_id, $book_id, '$issue_date')";
            if ($conn->query($sql_insert) === TRUE) {
                // Update the number of available copies of the book
                $new_copies = $no_of_copies - 1;
                $sql_update_copies = "UPDATE books SET no_of_copies = $new_copies WHERE book_id = $book_id";
                $conn->query($sql_update_copies);

                // Delete or mark the reservation as accepted
                $sql_delete_reservation = "DELETE FROM reservations WHERE reservation_id = $reservation_id";
                $conn->query($sql_delete_reservation);

                // Redirect to the manage_issuance.php page
                header("Location: manage_issuance.php?success=1");
                exit();
            } else {
                echo "Error: " . $sql_insert . "<br>" . $conn->error;
            }
        } else {
            echo "No available copies for this book.";
        }
    } else {
        echo "Reservation not found.";
    }
} else {
    echo "No reservation ID provided.";
}
?>
