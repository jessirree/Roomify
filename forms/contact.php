<?php
session_start();
//database connection
$con=new mysqli("localhost:3306","root","", "hostel");
// Check if the connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
//get form data
$fname = trim($_POST['fname']);
$lname = trim($_POST['lname']);
$email = trim($_POST['email']);
$num = trim($_POST['num']);
$room = trim($_POST['room']);

// Validate inputs
if (empty($fname) || empty($lname) || empty($email) || empty($num) || empty($room)) {
    echo "All fields are required.";
    exit;
}
// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}
// Validate phone number (must be numeric)
if (!is_numeric($num)) {
    echo "Phone number must be numeric.";
    exit;
}
// Sanitize inputs to prevent SQL injection 
$fname = htmlspecialchars($fname, ENT_QUOTES, 'UTF-8');
$lname = htmlspecialchars($lname, ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$num = htmlspecialchars($num, ENT_QUOTES, 'UTF-8');
$room = htmlspecialchars($room, ENT_QUOTES, 'UTF-8');


// Check if the email already exists in the database
$query = $con->prepare("SELECT * FROM booking WHERE email = ?");
$query->bind_param("s", $email);
$query->execute();
$query_result = $query->get_result();

if ($query_result->num_rows > 0) {
    echo "This email is already associated with a booking.";
} else {
    // Insert data into the database if no duplicate email is found
    $stmt = $con->prepare("INSERT INTO booking (fname, lname, email, num, room) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $fname, $lname, $email, $num, $room);

    if ($stmt->execute()) {
        echo "Booking successful";
    } else {
        // Log error and display a generic message
        error_log("Error inserting booking: " . $stmt->error);
        echo "Error submitting booking. Please try again.";
    }

    $stmt->close();
}

$query->close();
$con->close();
