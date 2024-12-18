<?php
// Set secure session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,            // 1-hour session
    'path' => '/',                 // Available throughout the website
    'domain' => '',                // Default to current domain
    'secure' => true,              // Only send over HTTPS
    'httponly' => true,            // Prevent JavaScript access
    'samesite' => 'Strict'         // CSRF protection
]);

session_start();

// Create a database connection
$con = new mysqli("localhost:3306", "root", "", "hostel");

// Check if the connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}


// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars(strip_tags(trim( $_POST['username'])), ENT_QUOTES, 'UTF-8');
    $password = $_POST['password'];

    // Query the database to get the stored hashed password for the given username
    $query = "SELECT * FROM admins WHERE username = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $username); // Bind the username as a string
    $stmt->execute();
    $result = $stmt->get_result();

   // Fetch the result as an associative array
   $admin = $result->fetch_assoc();

   // Verify password using password_verify
   if ($admin && password_verify($password, $admin['password'])) {
    // Regenerate session ID to prevent session fixation
    session_regenerate_id(true);

       // Set session variables
       $_SESSION['admin_logged_in'] = true;
       $_SESSION['username'] = $username;
       $_SESSION['role'] = $admin['role'];
       $_SESSION['last_activity'] = time(); // Set the last activity timestamp
       $_SESSION['timeout_duration'] = 3600; // Set the session timeout duration 

        // Set secure, HttpOnly cookies for the session
        setcookie(session_name(), session_id(), time() + 3600, "/", "", true, true); 

       // Redirect to admin page
       if ($admin['role'] === 'admin') {
        header('Location: ../newadmin.php'); 
    } else {
        header('Location: ../login.html'); 
    }
    exit();
   } else {
       echo "Invalid username or password!";
   }
}
$con->close();