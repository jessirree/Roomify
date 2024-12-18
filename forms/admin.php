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
session_start();
//database connection
$con=new mysqli("localhost:3306","root","", "hostel");

// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}
// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
  header('Location: login.html'); // Redirect to login page if not logged in
  exit();
}
// Enforce RBAC
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header('Location: login.html'); // Redirect if not authorized
  exit();
}
// Check for session timeout
$timeout_duration = 3600; // Set timeout duration (in seconds)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
  session_unset();
  session_destroy();
  header('Location: login.html'); // Redirect to login page if session has expired
  exit();
}

// Update last activity time
$_SESSION['last_activity'] = time();

// Check if admin form has been submitted
if (isset($_POST['admin_submit'])){ 
  // Get form data
//validate inputs
  $fname = trim($_POST['fname']);
  $lname = trim($_POST['lname']);
  $email = trim($_POST['email']);
  $num = trim($_POST['num']);
  $room = trim($_POST['room']);
  $action = $_POST['action'];

  if (empty($fname) || empty($lname) || empty($email) || empty($num) || empty($room) || empty($action)) {
    echo "All fields are required.";
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}

if (!is_numeric($num)) {
  echo "Phone number must be numeric.";
  exit;
}

  // Check if admin wants to add or remove data
  if ($action === 'add') {
    // Add data to database
    $stmt = $con->prepare("INSERT INTO booking (fname, lname, email, num, room) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $fname, $lname, $email, $num, $room);

     if ($stmt->execute()) {
            echo "Data added successfully.";
        } else {
            echo "Error adding data: " . $stmt->error;
        }

        $stmt->close();

  } elseif ($_POST['action'] == 'remove') {
    // Remove data from database
    $stmt = $con->prepare("DELETE FROM booking WHERE email = ?");
        $stmt->bind_param("s", $email);

        if ($stmt->execute()) {
          echo "Data removed successfully.";
      } else {
          echo "Error removing data: " . $stmt->error;
      }

      $stmt->close();
  } else {
      echo "Invalid action specified.";}
} else {
  echo "Invalid request.";
}
$con->close();
