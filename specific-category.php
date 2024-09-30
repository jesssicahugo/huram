<?php
// Include the database connection file
include 'db_connect.php';

// Get the general category ID from the URL
if (isset($_GET['category_id'])) {
    $general_category_id = $_GET['category_id'];
    
    // Get the general category name
    $sql_general = "SELECT category_name FROM general_category WHERE category_id = ?";
    $stmt_general = $conn->prepare($sql_general);
    $stmt_general->bind_param('i', $general_category_id);
    $stmt_general->execute();
    $result_general = $stmt_general->get_result();
    $general_category = $result_general->fetch_assoc()['category_name'];

    // Get the specific categories for the selected general category
    $sql_specific = "SELECT * FROM specific_category WHERE general_category_id = ? ORDER BY specific_category_name ASC";
    $stmt_specific = $conn->prepare($sql_specific);
    $stmt_specific->bind_param('i', $general_category_id);
    $stmt_specific->execute();
    $result_specific = $stmt_specific->get_result();
} else {
    // If category_id is not set, redirect back to the manage categories page
    header("Location: added-books.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Specific Categories - <?php echo $general_category; ?></title>

    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Responsive style -->
    <link href="css/responsive.css" rel="stylesheet">

    <style>
        .specific-category {
            cursor: pointer;
            font-weight: bold;
            margin: 10px 0;
            padding: 10px;
            background-color: #f8f9fc;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .specific-category:hover {
            background-color: #e2e6ea;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .category-container {
            display: flex;
            flex-wrap: wrap;
        }

        .category-container .specific-category {
            flex: 1 0 100%;
        }

        @media (min-width: 576px) {
            .category-container .specific-category {
                flex: 1 0 50%;
            }
        }

        @media (min-width: 768px) {
            .category-container .specific-category {
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

<body id="page-top">

    <!-- Include the header to match the dashboard -->
    <?php include 'header2.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <!-- Custom container for specific categories -->
            <div class="category-wrapper">
                <!-- Page Heading -->
                <h1 class="h3 mb-4 text-gray-800">Specific Categories under "<?php echo $general_category; ?>"</h1>

                <!-- Display Success Message (Optional) -->
                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success">
                        <?php echo $_GET['success']; ?>
                    </div>
                <?php } ?>

                <!-- Search Bar -->
                <div class="row search-bar">
                    <div class="col-lg-12">
                        <input type="text" id="search-input" class="form-control" placeholder="Search for specific categories...">
                    </div>
                </div>

                <!-- Specific Categories Container -->
                <div class="row category-container">
                    <?php
                    if ($result_specific->num_rows > 0) {
                        while ($row = $result_specific->fetch_assoc()) {
                            $specific_category_id = $row['specific_category_id'];
                            $specific_category_name = $row['specific_category_name'];
                            ?>
                            <div class="col-lg-4 col-md-6 mb-4">
                                <a href="added-books.php?category_id=<?php echo $specific_category_id; ?>" class="text-decoration-none">
                                    <div class="specific-category" data-category-id="<?php echo $specific_category_id; ?>" data-category-name="<?php echo strtolower($specific_category_name); ?>">
                                        <i class="fa fa-folder-open"></i> <?php echo $specific_category_name; ?>
                                    </div>
                                </a>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<div>No specific categories found</div>';
                    }
                    ?>
                </div>
            </div>
            <!-- End of custom container for specific categories -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Include the footer to match the dashboard -->
    <?php include 'footer.php'; ?>

    <!-- jQuery and Bootstrap scripts -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.js"></script>

    <!-- Custom script to handle search functionality -->
    <script>
        $(document).ready(function() {
            // Filter specific categories based on search input
            $('#search-input').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();

                $('.specific-category').each(function() {
                    var categoryName = $(this).data('category-name');
                    if (categoryName.indexOf(searchTerm) > -1) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>

</body>

</html>
