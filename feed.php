<?php
include_once 'dbConnection.php';
$ref=@$_GET['q'];
$username = $_POST['username'];
$email = $_POST['email'];
$id=uniqid();
$date=date("Y-m-d");
$feedback = $_POST['feedback'];
$q=mysqli_query($con,"INSERT INTO comment VALUES  ('$id' , '$username', '$email' , '$feedback' , '$date' )")or die ("Error");
header("location:$ref?q=Thank you");
?>