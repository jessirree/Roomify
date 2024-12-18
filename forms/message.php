<?php
session_start();
$con=new mysqli("localhost:3306","root","", "hostel");

//check if connection was successful
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
//get form data
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$subject = trim($_POST['subject']);
$message = trim($_POST['message']);

// Validate inputs
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo "All fields are required.";
    exit;
}
// Validate email format
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "Invalid email format.";
    exit;
}
// Sanitize message to prevent XSS
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

//$S = "select* from contacts where email = '$email'";
#result variable to store this query
//$result = mysqli_query($con,$S);

#number variable to count number of rowsthis name appears  in the database
//$num = mysqli_num_rows($result);
//if($num == 1){
  //  echo"Email already exists";
//}else
$stmt = $con->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo "Message successful";
} else {
    // Log error and display a generic message
    error_log("Error inserting message: " . $stmt->error);
    echo "Error submitting message. Please try again.";
}

$stmt->close();
$con->close();

