<!DOCTYPE html>
<html>

<head>
  <!-- Basic -->
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Mobile Metas -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <!-- Site Metas -->
  <meta name="keywords" content="" />
  <meta name="description" content="" />
  <meta name="author" content="" />

  <title>Inance</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
  <!-- font awesome style -->
  <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />

  <!-- Custom styles for this template -->
  <link href="css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="css/responsive.css" rel="stylesheet" />

  <style>
    .dashboard-container {
      margin-top: 50px;
    }

    .dashboard-box {
      background-color: #f8f9fa;
      border: 1px solid #dee2e6;
      padding: 20px;
      text-align: center;
      border-radius: 5px;
    }

    .dashboard-box h3 {
      margin-bottom: 20px;
    }

    .dashboard-box i {
      font-size: 50px;
      color: #800000;
      margin-bottom: 15px;
    }

    .row > .col-md-4 {
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
    <div class="hero_area">
        <!-- header section starts -->
        <header class="header_section">
          <div class="header_top">
            <div class="container-fluid">
              <div class="contact_nav">
                <a href="">
                  <i class="fa fa-phone" aria-hidden="true"></i>
                  <span>
                    Call : +01 123455678990
                  </span>
                </a>
                <a href="">
                  <i class="fa fa-envelope" aria-hidden="true"></i>
                  <span>
                    Email : demo@gmail.com
                  </span>
                </a>
              </div>
            </div>
          </div>
          <div class="header_bottom">
            <div class="container-fluid">
              <nav class="navbar navbar-expand-lg custom_nav-container ">
                <a class="navbar-brand" href="index.html">
                  <span>
                    Inance
                  </span>
                </a>
    
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class=""> </span>
                </button>
    
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ">
                    <li class="nav-item ">
                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                      <a class="nav-link" href="about.php"> About</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="service.php">Services</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="contact.php">Contact Us</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="login.php">Login</a>
                    </li>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </header>
        <!-- end header section -->
      </div>

  <div class="container dashboard-container">
    <div class="row">
      <div class="col-md-4">
        <div class="dashboard-box">
          <i class="fa fa-book" aria-hidden="true"></i>
          <h3>View Books</h3>
          <p>Check the list of available books in the library.</p>
          <a href="view_books.html" class="btn btn-primary">Go to View Books</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dashboard-box">
          <i class="fa fa-calendar" aria-hidden="true"></i>
          <h3>Due Date Books</h3>
          <p>View books that are due for return soon.</p>
          <a href="due_dates.html" class="btn btn-primary">Go to Due Dates</a>
        </div>
      </div>
      <div class="col-md-4">
        <div class="dashboard-box">
          <i class="fa fa-bookmark" aria-hidden="true"></i>
          <h3>Reserve Books</h3>
          <p>Reserve books that are currently unavailable.</p>
          <a href="reserve_books.html" class="btn btn-primary">Go to Reserve Books</a>
        </div>
      </div>
    </div>
  </div>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
</body>

</html>
