<?php
session_start();
include 'db_connect.php'; // Include the database connection file

// Initialize error message
$login_error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query for admins
    $stmt = $conn->prepare("SELECT id, fullname, password FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if admin exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashed_password);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id;
            $_SESSION['admin_fullname'] = $fullname;
            // Redirect to admin dashboard
            header("Location: admin/admindashboard.php");
            exit(); // Ensure no further code is executed after redirection
        } else {
            $login_error = "Invalid password!";
        }
    } else {
        $login_error = "No admin found with that email address!";
    }

    $stmt->close();
}

$conn->close();
?>
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

  <title>Inance - Admin Login</title>

  <!-- slider stylesheet -->
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
  <!-- bootstrap core css -->
  <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css" />
  <!-- font awesome style -->
  <link rel="stylesheet" type="text/css" href="assets/css/font-awesome.min.css" />

  <!-- Custom styles for this template -->
  <link href="assets/css/style.css" rel="stylesheet" />
  <!-- responsive style -->
  <link href="assets/css/responsive.css" rel="stylesheet" />

  <!-- Custom styles for the login box -->
  <style>
    .login-box {
      background-color: #f7f7f7;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .login-box h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .login-box .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .login-box .btn-primary:hover {
      background-color: #0056b3;
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
                HURAM: Book Borrowing System
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
                <li class="nav-item">
                  <a class="nav-link" href="about.php"> About</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="service.php">Services</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="contact.php">Contact Us</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link" href="admin_login.php">Admin Login</a>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- end header section -->
  </div>

  <!-- login section -->
  <section class="login_section layout_padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="login-box">
            <h2 class="text-center mb-4">Admin Log In</h2>

            <form action="" method="post">
              <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
              </div>
              <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="rememberMe">
                <label class="form-check-label" for="rememberMe">Remember me</label>
              </div>
              <button type="submit" class="btn btn-primary btn-block">Log In</button>
              <div class="text-center mt-3">
                <a href="#">Forgot Password?</a>
              </div>
              <?php if (!empty($login_error)) { echo "<div class='alert alert-danger text-center mt-3'>$login_error</div>"; } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end login section -->

  <!-- footer section -->
  <footer class="footer_section">
    <div class="container">
      <p>
        &copy; <span id="displayDateYear"></span> All Rights Reserved By
        <a href="https://html.design/">Free Html Templates</a>
      </p>
    </div>
  </footer>
  <!-- end footer section -->

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
  <script src="js/custom.js"></script>
</body>

</html>
