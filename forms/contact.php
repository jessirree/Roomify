<?php
session_start();
$con=mysqli_connect("localhost:3306","root","", "hostel");
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$email = $_POST['email'];
$num = $_POST['num'];
$room = $_POST['room'];


$S = "select* from booking where email = '$email'";
#result variable to store this query
$result = mysqli_query($con,$S);

#number variable to count number of rowsthis name appears  in the database
$numb = mysqli_num_rows($result);
if($numb == 1){
    echo"Email already exists";
}else
{
    $reg ="insert into booking(fname,lname,email,num,room)values('$fname','$lname','$email','$num','$room')";
    mysqli_query($con,$reg);
    echo"Booking successful";
}
