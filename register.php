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

  <!-- Custom styles for the registration box -->
  <style>
    .registration-box {
      background-color: #f7f7f7;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    .registration-box h2 {
      font-size: 24px;
      margin-bottom: 20px;
    }

    .registration-box .btn-primary {
      background-color: #007bff;
      border: none;
    }

    .registration-box .btn-primary:hover {
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
                    HURAM: Book Borrowing
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

    <!-- Registration Section -->
    <section class="registration_section layout_padding">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-6 col-md-8">
            <div class="registration-box">
              <h2 class="text-center mb-4">Sign Up</h2>

              <!-- PHP Script to Handle Form Submission -->
              <?php
              // Include database connection
              include 'db_connect.php';

              // Handle form submission
              if ($_SERVER["REQUEST_METHOD"] == "POST") {
                  $fullname = $_POST['fullname'];
                  $email = $_POST['email'];
                  $phone = $_POST['phone'];
                  $course = $_POST['course'];
                  $student_id = $_POST['student_id']; // Added field
                  $password = $_POST['password'];
                  $confirm_password = $_POST['confirm_password'];

                  // Password confirmation
                  if ($password !== $confirm_password) {
                      echo "<div class='alert alert-danger'>Passwords do not match!</div>";
                  } else {
                      // Hash the password before storing it
                      $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                      // Prepare and bind
                      $stmt = $conn->prepare("INSERT INTO users (fullname, email, phone, course, student_id, password) VALUES (?, ?, ?, ?, ?, ?)");
                      $stmt->bind_param("ssssss", $fullname, $email, $phone, $course, $student_id, $hashed_password);

                      // Execute the statement
                      if ($stmt->execute()) {
                          echo "<div class='alert alert-success'>Registration successful! Redirecting to login page...</div>";
                          header("Refresh: 2; url=login.php"); // Redirect to login page after 2 seconds
                      } else {
                          echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
                      }

                      $stmt->close();
                  }
              }

              $conn->close();
              ?>

              <form action="" method="post">
                <div class="form-group">
                  <label for="fullname">Full Name</label>
                  <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Enter your full name" required>
                </div>
                <div class="form-group">
                  <label for="email">Email address</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" pattern="[a-zA-Z0-9._%+-]+@evsu\.edu\.ph" title="Email must be in the format: username@edu.edu.ph" required>
                </div>
                <div class="form-group">
                  <label for="phone">Phone Number</label>
                  <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                </div>
                <div class="form-group">
                  <label for="course">Course</label>
                  <input type="text" class="form-control" id="course" name="course" placeholder="Enter your course" required>
                </div>
                <div class="form-group">
                  <label for="student_id">Student ID</label>
                  <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter your student ID" required>
                </div>
                <div class="form-group">
                  <label for="password">Password</label>
                  <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                  <label for="confirm_password">Confirm Password</label>
                  <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                <div class="text-center mt-3">
                  <span>Already have an account? <a href="login.php">Log In</a></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Registration Section -->

    <!-- footer section -->
    <footer class="footer_section">
      <div class="container">
        <p>
          &copy; <span id="displayDateYear"></span> All Rights Reserved By
          <a href="https://html.design/">Free Html Templates</a>
        </p>
      </div>
    </footer>
</body>
</html>
