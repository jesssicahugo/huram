<?php
// Include the database connection file
include 'db_connect.php';

if (isset($_POST['general_category_id'])) {
    $general_category_id = intval($_POST['general_category_id']);

    // Fetch specific categories based on the selected general category
    $sql_specific_categories = "SELECT specific_category_id, specific_category_name FROM specific_category WHERE general_category_id = ?";
    $stmt = $conn->prepare($sql_specific_categories);
    $stmt->bind_param('i', $general_category_id);
    $stmt->execute();
    $result_specific_categories = $stmt->get_result();

    // Generate options for the specific category dropdown
    if ($result_specific_categories->num_rows > 0) {
        while ($row = $result_specific_categories->fetch_assoc()) {
            echo "<option value='{$row['specific_category_id']}'>{$row['specific_category_name']}</option>";
        }
    } else {
        echo "<option value=''>No specific categories available</option>";
    }
}
?>
