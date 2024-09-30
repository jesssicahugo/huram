<?php
session_start();
include 'db_connect.php'; // Include the database connection file

// Initialize error message
$login_error = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT id, fullname, password, student_id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if user exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $fullname, $hashed_password, $student_id); // Also fetch student_id
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['fullname'] = $fullname;
            $_SESSION['student_id'] = $student_id; // Set the student ID in session
            $_SESSION['user_logged_in'] = true; // Set user_logged_in session variable

            // Debug statement to ensure session variables are set
            echo "Login successful. Redirecting...";

            // Redirect to dashboard after setting session variables
            header("Location: dashboard.php");
            exit(); // Ensure no further code is executed after redirection
        } else {
            $login_error = "Invalid password!";
        }
    } else {
        $login_error = "No user found with that email address!";
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

  <title>Login</title>

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
  <?php include 'header.php'; ?>
  <!-- login section -->
  <section class="login_section layout_padding">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8">
          <div class="login-box">
            <h2 class="text-center mb-4">Log In</h2>

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
              <div class="text-center mt-2">
                <span>Don't have an account? <a href="register.php">Sign Up</a></span>
              </div>
              <?php if (!empty($login_error)) { echo "<div class='alert alert-danger text-center mt-3'>$login_error</div>"; } ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end login section -->
  <?php include 'footer.php'; ?>

  <script src="js/jquery-3.4.1.min.js"></script>
  <script src="js/bootstrap.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js">
  </script>
  <script src="js/custom.js"></script>
  <!-- Google Map -->
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap"></script>
  <!-- End Google Map -->
</body>

</html>
