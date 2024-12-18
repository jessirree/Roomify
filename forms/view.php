<?php

// create a database connection
$con=new mysqli("localhost:3306","root","", "hostel");

// check if the connection was successful
if ($con->connect_error) {
  die("Connection failed: " . $con->connect_error);
}

// SQL query to retrieve data from the database
$sql = "SELECT * FROM booking";

// execute the query and store the result
$result = $con->query($sql);

// check if any data was retrieved
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    // Sanitize output to prevent XSS attacks
    $fname = htmlspecialchars($row["fname"], ENT_QUOTES, 'UTF-8');
    $lname = htmlspecialchars($row["lname"], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($row["email"], ENT_QUOTES, 'UTF-8');
    $num = htmlspecialchars($row["num"], ENT_QUOTES, 'UTF-8');
    $room = htmlspecialchars($row["room"], ENT_QUOTES, 'UTF-8');
    //display data
    echo "First Name: $fname - Last Name: $lname - Email: $email - Phone: $num - Room: $room<br>";
  }
} else {
  echo "No bookings found.";
}

// close the database connection
$con->close();

