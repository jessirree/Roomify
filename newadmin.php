<?php
// Start the session securely
session_set_cookie_params([
  'lifetime' => 3600,             // 1-hour session
  'path' => '/',                  // Available throughout the website
  'domain' => '',                 // Default to current domain
  'secure' => true,               // Only send over HTTPS
  'httponly' => true,             // Prevent JavaScript access
  'samesite' => 'Strict'          // CSRF protection
]);
session_start(); // Start the session

// Check if admin is logged in
//if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  if (!isset($_SESSION['admin_logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.html'); // Redirect to login page if not logged in
    exit();
}

// Check if session has expired 
$timeout_duration = 3600; // Set timeout duration (in seconds)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    // If session has expired, destroy the session and redirect to login
    session_unset();
    session_destroy();
    header('Location: login.html');
    exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Roomify Hostels</title>
  <meta content="" name="Roomify">
  <meta content="" name="roomify, student hostels accomodation">

  <!-- Favicons -->
  <link href="assets/img/letter.jpg" rel="icon">
  <link href="assets/img/letter.jpg" rel="apple-touch-icon">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Link to Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
  <section id="contact" class="paralax-mf footer-paralax bg-image sect-mt4 route"
    style="background-image: url(assets/img/overlay-bg.jpg)">
    <div class="overlay-mf"></div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="contact-mf">
            <div id="contact" class="box-shadow-full">
              <div class="row">
                <div class="col-md-6">
                  <div class="title-box-2">
                    <h5 class="title-left">
                      Admin
                    </h5>
                  </div>
                  <div>
                    <form action="forms/admin.php" method="post">
                      <div class="row">
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="text" name="fname" class="form-control" id="fname" placeholder="First Name"
                              required>
                          </div>
                          <div class="form-group">
                            <input type="text" name="lname" class="form-control" id="lname" placeholder="Last Name"
                              required>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                              required>
                          </div>
                        </div>
                        <div class="col-md-12 mb-3">
                          <div class="form-group">
                            <input type="num" class="form-control" name="num" id="num" placeholder="Phone Number"
                              required>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <select name="room">
                              <option value="single" selected>Single Room</option>
                              <option value="double">Double Room</option>
                              <option value="tripple">Tripple Room</option>
                            </select>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <input type="radio" name="action" value="add" checked> Add Data<br>
                            <input type="radio" name="action" value="remove"> Remove Data<br>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12 text-center">
                        <button type="submit" class="button button-a button-big button-rouded"
                          name="admin_submit">Submit</button>
                      </div>
                      <div class="col-md-12">
                        <div class="title-box-2 pt-4 pt-md-0">
                          <div class="col-md-12 text-center">
                            <a class="button button-a button-big button-rouded" href="forms/view.php">View Students</a>
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>

</html>