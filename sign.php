<?php
include_once 'dbConnection.php';
ob_start();
$username = $_POST['username'];
$username= ucwords(strtolower($username));
$gender = $_POST['gender'];
$email = $_POST['email'];
$roll_number = $_POST['roll_number'];
$mobile_number = $_POST['mobile_number'];
$password = $_POST['password'];
$username = stripslashes($username);
$username = addslashes($username);
$username = ucwords(strtolower($username));
$gender = stripslashes($gender);
$gender = addslashes($gender);
$email = stripslashes($email);
$email = addslashes($email);
$roll_number = stripslashes($roll_number);
$roll_number = addslashes($roll_number);
$mobile_number = stripslashes($mobile_number);
$mobile_number = addslashes($mobile_number);

$password = stripslashes($password);
$password = addslashes($password);
$password = md5($password);

$q3=mysqli_query($con,"INSERT INTO user VALUES  ('$username' , '$gender' , '$roll_number','$email' ,'$mobile_number', '$password')");
if($q3)
{
session_start();
$_SESSION["email"] = $email;
$_SESSION["username"] = $username;

header("location:account.php?q=1");
}
else
{
header("location:index.php?q7=Email Already Registered!!!");
}
ob_end_flush();
?>