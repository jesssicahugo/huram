<?php
// Include the database connection file
include 'db_connect.php';

// Get the general category ID from the URL
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;

// Query to get the general category name
$general_category_query = "SELECT category_name FROM general_category WHERE category_id = ?";
$stmt = $conn->prepare($general_category_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$stmt->bind_result($general_category_name);
$stmt->fetch();
$stmt->close();

// Query to get specific categories under the selected general category
$specific_categories_query = "SELECT * FROM specific_category WHERE general_category_id = ? ORDER BY specific_category_name ASC";
$stmt = $conn->prepare($specific_categories_query);
$stmt->bind_param("i", $category_id);
$stmt->execute();
$specific_categories_result = $stmt->get_result();

// Check if the query was successful
if ($specific_categories_result === false) {
    echo "Error: " . $conn->error;
} else {
    ?>

<!DOCTYPE html>
<html>

<head>
    <!-- Basic Metas -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Specific Categories - <?php echo htmlspecialchars($general_category_name); ?></title>

    <!-- Include stylesheets -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        .folder {
            cursor: pointer;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fc;
            border: 1px solid #ddd;
            border-radius: 5px;
            position: relative;
            transition: background-color 0.3s ease;
        }
        .folder i {
            margin-right: 20px;
        }
        .folder:hover {
            background-color: #e2e6ea;
        }
        .search-bar {
          margin-bottom: 20px;
      }

      .category-container {
          display: flex;
          flex-wrap: wrap;
          margin-bottom: 100px;
      }

      .category-container .folder {
          flex: 1 0 100%;
      }

      @media (min-width: 576px) {
          .category-container .folder {
              flex: 1 0 50%;
          }
      }

      @media (min-width: 768px) {
          .category-container .folder {
              flex: 1 0 33.33%;
          }
      }

      /* Custom container for categories */
      .category-wrapper {
          background-color: #ffffff;
          padding: 30px;
          border-radius: 10px;
          box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
          margin-top: 20px;
      }
    </style>
</head>

<body>
    <!-- Include the header to match the dashboard -->
    <?php include 'header2.php'; ?>
<!-- Page Wrapper -->
<div id="wrapper">
    <!-- Begin Page Content -->
    <div class="container-fluid">
        <!-- Custom container for categories -->
        <div class="category-wrapper mb-5"> <!-- Added 'mb-5' class here -->
            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Specific Categories under "<?php echo htmlspecialchars($general_category_name); ?>"</h1>

            <!-- Display Success Message (Optional) -->
            <?php if (isset($_GET['success'])) { ?>
            <div class="alert alert-success">
                <?php echo $_GET['success']; ?>
            </div>
            <?php } ?>

            <!-- Search Bar -->
            <div class="row search-bar">
                <div class="col-lg-12">
                    <input type="text" id="search-input" class="form-control" placeholder="Search for categories...">
                </div>
            </div>

            <div class="row category-container">
                <?php
                if ($specific_categories_result->num_rows > 0) {
                    while ($row = $specific_categories_result->fetch_assoc()) {
                        $specific_category_id = $row['specific_category_id'];
                        $specific_category_name = $row['specific_category_name'];
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="folder" onclick="navigateToBooks(<?php echo $specific_category_id; ?>)">
                                <i class="fa fa-folder" style="font-size:24px"></i><?php echo $specific_category_name; ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div>No specific categories found</div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Include the footer to match the dashboard -->
<?php include 'footer.php'; ?>

<!-- JavaScript files -->
<script src="js/jquery-3.4.1.min.js"></script>
<script src="js/bootstrap.js"></script>

<!-- Custom script for navigation -->
<script>
    function navigateToBooks(specificCategoryId) {
        window.location.href = 'view_books.php?specific_category_id=' + specificCategoryId;
    }
</script>

</body>

</html>

<?php
}
?>
