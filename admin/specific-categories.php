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
    header("Location: manage-categories.php");
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

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for displaying categories -->
    <style>
        .specific-category {
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

        .specific-category:hover {
            background-color: #e2e6ea;
        }

        .action-icons {
            position: absolute;
            right: 10px;
            top: 10px;
        }

        .action-icons i {
            margin-left: 10px;
            cursor: pointer;
        }

        .search-bar {
            margin-bottom: 20px;
        }
    </style>
</head>

<body id="page-top">
<?php include 'index.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">

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
            <div class="row">
                <?php
                if ($result_specific->num_rows > 0) {
                    while ($row = $result_specific->fetch_assoc()) {
                        $specific_category_id = $row['specific_category_id'];
                        $specific_category_name = $row['specific_category_name'];
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="specific-category" data-category-id="<?php echo $specific_category_id; ?>" data-category-name="<?php echo strtolower($specific_category_name); ?>">
                                <i class="fas fa-folder"></i> <?php echo $specific_category_name; ?>

                                <!-- Action icons for edit and delete -->
                                <div class="action-icons">
                                    <!-- Edit button -->
                                    <a href="edit_specific_category.php?category_id=<?php echo $specific_category_id; ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete button -->
                                    <a href="delete_specific_category.php?category_id=<?php echo $specific_category_id; ?>&general_category_id=<?php echo $general_category_id; ?>" 
                                    onclick="return confirm('Are you sure you want to delete this category?');">
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                </div>

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
        <!-- /.container-fluid -->
    </div>
    <!-- End of Main Content -->

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>

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
