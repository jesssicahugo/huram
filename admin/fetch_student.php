<?php
include 'db_connect.php';

if (isset($_POST['student_id'])) {
    $student_id = $conn->real_escape_string($_POST['student_id']);
    $query = $conn->query("SELECT * FROM users WHERE student_id = '$student_id' LIMIT 1");

    if ($query->num_rows > 0) {
        $data = $query->fetch_assoc();
        echo json_encode($data);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(["error" => "Student ID not set"]);
}
?>
