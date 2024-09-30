
<!DOCTYPE html>
<html>

<head>
  <!-- Basic meta information omitted for brevity -->
  <title>Inance</title>

  <!-- Stylesheets omitted for brevity -->
</head>

<body>
  <div class="hero_area">
    <!-- header section starts -->
    <header class="header_section">
      <div class="header_top">
        <div class="container-fluid">
          <div class="contact_nav">
            <a href="mailto:evsucc.library2018@gmail.com">
              <i class="fa fa-envelope" aria-hidden="true"></i>
              <span>Email : evsucc.library2018@gmail.com</span>
            </a>
          </div>
        </div>
      </div>
      <div class="header_bottom">
        <div class="container-fluid">
          <nav class="navbar navbar-expand-lg custom_nav-container ">
            <a class="navbar-brand" href="index.html">
              <span>HURAM: Book Borrowing</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class=""> </span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <!-- Profile Section with Dropdown -->
                <li class="nav-item dropdown">
                  <?php
                  if (isset($_SESSION['users'])) {
                      $users = $_SESSION['users'];
                  } else {
                      $users = 'Guest';
                  }
                  ?>
                  <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <?php echo $users; ?>
                  </a>
                  <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
                </li>
              </ul>
            </div>
          </nav>
        </div>
      </div>
    </header>
    <!-- end header section -->
  </div>
</body>
</html>
