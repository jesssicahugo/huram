<?php
$servername = "localhost";  // usually 'localhost' when using XAMPP
$username = "root";         // default username for XAMPP is 'root'
$password = "";             // default password for XAMPP is an empty string
$dbname = "borrow";  // make sure this matches your actual database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
