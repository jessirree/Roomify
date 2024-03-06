<?php
session_start();
$con=mysqli_connect("localhost:3306","root","", "hostel");
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$num = $_POST['num'];
$room = $_POST['room'];
// Check connection
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

// Check if admin form has been submitted
if (isset($_POST['admin_submit'])) 
  // Get form data
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $num = $_POST['num'];
  $room = $_POST['room'];

  // Check if admin wants to add or remove data
  if ($_POST['action'] == 'add') {
    // Add data to database
    $mysqli = "INSERT INTO booking (fname, lname, email, num, room)
    VALUES ('$fname', '$fname', '$email', '$num','$room')";

    if ($con->query($mysqli) === TRUE) {
      echo "Data added successfully";
    } else {
      echo "Error: " . $mysqli . "<br>" . $con->error;
    }
  } elseif ($_POST['action'] == 'remove') {
    // Remove data from database
    $mysqli = "DELETE FROM booking WHERE email='$email'";

    if ($con->query($mysqli) === TRUE) {
      echo "Data removed successfully";
    } else {
      echo "Error: " . $mysqli . "<br>" . $conn->error;
    }
}