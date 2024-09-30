<?php
// Include the database connection file
include 'db_connect.php';

$sql = "SELECT * FROM general_category ORDER BY category_name ASC";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    // Display the SQL error for debugging
    echo "Error: " . $conn->error;
} else {
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Manage Categories</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for displaying categories -->
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

        .folder:hover {
            background-color: #e2e6ea;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .category-container {
            display: flex;
            flex-wrap: wrap;
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
    </style>
</head>

<body id="page-top">
    <?php include 'index.php'; ?>

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Begin Page Content -->
        <div class="container-fluid">

            <!-- Page Heading -->
            <h1 class="h3 mb-4 text-gray-800">Manage Categories</h1>

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

            <!-- Categories Container -->
            <div class="row category-container">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $general_category_id = $row['category_id'];
                        $category_name = $row['category_name'];
                        ?>
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="folder" onclick="navigateToSpecificCategory(<?php echo $general_category_id; ?>)" data-category-id="<?php echo $general_category_id; ?>" data-category-name="<?php echo strtolower($category_name); ?>">
                                <i class="fas fa-folder"></i> <?php echo $category_name; ?>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo '<div>No categories found</div>';
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

    <!-- Custom script to handle folder clicks and search functionality -->
    <script>
        $(document).ready(function() {
            // Handle folder click (general category)
            $('.folder').click(function(event) {
                var categoryId = $(this).data('category-id');
                window.location.href = 'books.php?category_id=' + categoryId;
            });

            // Filter categories based on search input
            $('#search-input').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();

                $('.folder').each(function() {
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
<?php
}
?>
