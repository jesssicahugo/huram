<?php
// Buffer output to avoid header issues
ob_start(); 

// Start the session and include the database connection
session_start();
include 'db_connect.php';

if (isset($_GET['reservation_id'])) {
    $reservation_id = $_GET['reservation_id'];
    echo "Reservation ID: " . $reservation_id . "<br>";

    // First, check if the reservation ID exists in the database
    $sql_check = "SELECT * FROM reservations WHERE reservation_id = ?";
    if ($stmt_check = $conn->prepare($sql_check)) {
        $stmt_check->bind_param("i", $reservation_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            // Reservation exists, proceed with rejection

            // Prepare the SQL query to reject the reservation
            $sql = "UPDATE reservations SET status = 'rejected' WHERE reservation_id = ?";

            // Prepare the statement
            if ($stmt = $conn->prepare($sql)) {
                // Bind the parameter to the SQL query
                $stmt->bind_param("i", $reservation_id);

                // Execute the query
                if ($stmt->execute()) {
                    echo "Reservation ID $reservation_id has been rejected.<br>";
                    // If the update is successful, set a notification message in the session
                    $_SESSION['notification'] = "Reservation ID $reservation_id has been rejected.";
                } else {
                    // Handle query execution errors
                    echo "Query Execution Error: " . $stmt->error . "<br>";
                    $_SESSION['notification'] = "Error: Could not reject reservation. " . $stmt->error;
                }

                // Close the statement
                $stmt->close();
            } else {
                // Handle SQL preparation errors
                echo "SQL Preparation Error: " . $conn->error . "<br>";
                $_SESSION['notification'] = "Error preparing the SQL statement: " . $conn->error;
            }
        } else {
            // Reservation ID not found
            echo "Error: Reservation ID $reservation_id not found.<br>";
            $_SESSION['notification'] = "Error: Reservation ID not found.";
        }

        // Close the check statement
        $stmt_check->close();
    } else {
        // Handle SQL preparation errors for checking reservation
        echo "SQL Preparation Error (check): " . $conn->error . "<br>";
        $_SESSION['notification'] = "Error preparing the SQL statement (check): " . $conn->error;
    }

} else {
    // If no reservation ID is provided, output error and redirect
    echo "Error: No reservation ID provided.<br>";
    $_SESSION['notification'] = "Error: No reservation ID provided.";
}

// Redirect back to the manage reservations page after 2 seconds for debugging
header("refresh:2;url=manage_pendings.php");
exit();

ob_end_flush(); // Flush the buffer and send output
?>
