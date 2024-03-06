<?php
session_start();
$con=mysqli_connect("localhost:3306","root","", "hostel");
$name = $_POST['name'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];


$S = "select* from contacts where email = '$email'";
#result variable to store this query
$result = mysqli_query($con,$S);

#number variable to count number of rowsthis name appears  in the database
$num = mysqli_num_rows($result);
if($num == 1){
    echo"Email already exists";
}else
{
    $reg ="insert into contacts(name,email,subject,message)values('$name','$email','$subject','$message')";
    mysqli_query($con,$reg);
    echo"Message successful";
}
