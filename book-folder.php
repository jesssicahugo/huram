<?php
// Include the database connection file
include 'db_connect.php';

// Enable error reporting to help troubleshoot
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$sql = "SELECT * FROM general_category ORDER BY category_name ASC";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === false) {
    // Display the SQL error for debugging
    echo "Error: " . $conn->error;
} else {
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <title>View Books - General Categories</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
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

<body id="page-top">

  <!-- Include the header to match the dashboard -->
  <?php include 'header2.php'; ?>

  <!-- Page Wrapper -->
  <div id="wrapper">
    <div class="container-fluid">
      <div class="category-wrapper mb-5">
        <h1 class="h3 mb-4 text-gray-800">Categories</h1>

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
          if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                  $category_id = $row['category_id'];
                  $category_name = $row['category_name'];
                  ?>
                  <div class="col-lg-4 col-md-6 mb-4">
                      <div class="folder" onclick="navigateToSpecificCategory(<?php echo $category_id; ?>)" data-category-id="<?php echo $category_id; ?>" data-category-name="<?php echo strtolower($category_name); ?>">
                      <i class="fa fa-folder" style="font-size:24px"></i><?php echo $category_name; ?>
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
    </div>
  </div>

  <!-- Include the footer -->
  <?php include 'footer.php'; ?>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>

  <script>
      $(document).ready(function() {
          $('.folder').click(function(event) {
              var categoryId = $(this).data('category-id');
              window.location.href = 'book-list.php?category_id=' + categoryId;
          });

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
