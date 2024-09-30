<?php
// Include the database connection file
include 'db_connect.php';

// Check if the 'id' is set in the query string
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the author details from the database
    $sql = "SELECT * FROM authors WHERE id = $id";
    $result = $conn->query($sql);

    // Check if the author exists
    if ($result->num_rows == 1) {
        $author = $result->fetch_assoc();
    } else {
        // Redirect if the author does not exist
        header("Location: cards.php.php?error=Author not found");
        exit();
    }
} else {
    // Redirect if 'id' is not set
    header("Location: cards.php.php?error=No author selected");
    exit();
}

// Handle the form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_name = $conn->real_escape_string($_POST['author_name']);

    // Update the author in the database
    $sql = "UPDATE authors SET author_name = '$author_name' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        // Redirect to the Manage Authors page with a success message
        header("Location: cards.php.php?success=Author updated successfully");
        exit();
    } else {
        echo "Error updating author: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Author</title>
    <!-- Add your CSS here -->
</head>
<body>
    <h1>Edit Author</h1>
    <form action="" method="post">
        <div>
            <label for="author_name">Author Name</label>
            <input type="text" id="author_name" name="author_name" value="<?php echo $author['author_name']; ?>" required>
        </div>
        <button type="submit">Update Author</button>
    </form>
    <a href="cards.php.php">Back to Manage Authors</a>
</body>
</html>
