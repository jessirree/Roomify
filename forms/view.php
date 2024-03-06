<?php

// create a database connection
$con=mysqli_connect("localhost:3306","root","", "hostel");

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
    echo "First Name: " . $row["fname"]. " - Last Name: " . $row["lname"]. " - Email: " . $row["email"]. " - Phone: " . $row["num"]. " - Room: " . $row["room"]. "<br>";
  }
} else {
  echo "0 results";
}

// close the database connection
$con->close();

?>