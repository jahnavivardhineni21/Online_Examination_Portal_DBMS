<?php
include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
//delete feedback
if(isset($_SESSION['key'])){
if(@$_GET['fdid'] && $_SESSION['key']=='harry19') {
$id=@$_GET['fdid'];
$result = mysqli_query($con,"DELETE FROM comment WHERE id='$id' ") or die('Error');
header("location:dash.php?q=3");
}
}

//delete user
if(isset($_SESSION['key'])){
if(@$_GET['demail'] && $_SESSION['key']=='harry19') {
$demail=@$_GET['demail'];
$r1 = mysqli_query($con,"DELETE FROM rank WHERE email='$demail' ") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM previous_results WHERE email='$demail' ") or die('Error');
$result = mysqli_query($con,"DELETE FROM user WHERE email='$demail' ") or die('Error');
header("location:dash.php?q=1");
}
}
//remove quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'rmquiz' && $_SESSION['key']=='harry19') {
$e_id=@$_GET['e_id'];
$result = mysqli_query($con,"SELECT * FROM questions WHERE e_id='$e_id' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$q_id = $row['q_id'];
$r1 = mysqli_query($con,"DELETE FROM options WHERE q_id='$q_id'") or die('Error');
$r2 = mysqli_query($con,"DELETE FROM answer WHERE q_id='$q_id' ") or die('Error');
}
$r3 = mysqli_query($con,"DELETE FROM questions WHERE e_id='$e_id' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM quiz WHERE e_id='$e_id' ") or die('Error');
$r4 = mysqli_query($con,"DELETE FROM previous_results WHERE e_id='$e_id' ") or die('Error');

header("location:dash.php?q=5");
}
}

//add quiz
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addtest' && $_SESSION['key']=='harry19') {
$name_of_exam = $_POST['name_of_exam'];
$name_of_exam= ucwords(strtolower($name_of_exam));
$score = $_POST['score'];
$no_of_correct = $_POST['no_of_correct'];
$no_of_incorrect = $_POST['no_of_incorrect'];
$time = $_POST['time'];
$description = $_POST['description'];
$id=uniqid();
$q3=mysqli_query($con,"INSERT INTO quiz VALUES  ('$id','$name_of_exam' , '$no_of_correct' , '$no_of_incorrect','$score','$time' ,'$description',NOW())");

header("location:dash.php?q=4&step=2&e_id=$id&n=$score");
}
}

//add question
if(isset($_SESSION['key'])){
if(@$_GET['q']== 'addqns' && $_SESSION['key']=='harry19') {
$n=@$_GET['n'];
$e_id=@$_GET['e_id'];
$ch=@$_GET['ch'];

for($i=1;$i<=$n;$i++)
 {
 $q_id=uniqid();
 $questions=$_POST['questions'.$i];
$q3=mysqli_query($con,"INSERT INTO questions VALUES  ('$e_id','$q_id','$questions' , '$ch' , '$i')");
$oaid=uniqid();
$obid=uniqid();
$ocid=uniqid();
$odid=uniqid();
$a=$_POST[$i.'1'];
$b=$_POST[$i.'2'];
$c=$_POST[$i.'3'];
$d=$_POST[$i.'4'];
$qa=mysqli_query($con,"INSERT INTO options VALUES  ('$q_id','$a','$oaid')") or die('Error61');
$qb=mysqli_query($con,"INSERT INTO options VALUES  ('$q_id','$b','$obid')") or die('Error62');
$qc=mysqli_query($con,"INSERT INTO options VALUES  ('$q_id','$c','$ocid')") or die('Error63');
$qd=mysqli_query($con,"INSERT INTO options VALUES  ('$q_id','$d','$odid')") or die('Error64');
$e=$_POST['ans'.$i];
switch($e)
{
case 'a':
$ansid=$oaid;
break;
case 'b':
$ansid=$obid;
break;
case 'c':
$ansid=$ocid;
break;
case 'd':
$ansid=$odid;
break;
default:
$ansid=$oaid;
}


$qans=mysqli_query($con,"INSERT INTO answer VALUES  ('$q_id','$ansid')");

 }
header("location:dash.php?q=0");
}
}

//quiz start
if(@$_GET['q']== 'quiz' && @$_GET['step']== 2) {
$e_id=@$_GET['e_id'];
$sn=@$_GET['n'];
$score=@$_GET['t'];
$ans=$_POST['ans'];
$q_id=@$_GET['q_id'];
$q=mysqli_query($con,"SELECT * FROM answer WHERE q_id='$q_id' " );
while($row=mysqli_fetch_array($q) )
{
$ansid=$row['ansid'];
}
if($ans == $ansid)
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE e_id='$e_id' " );
while($row=mysqli_fetch_array($q) )
{
$no_of_correct=$row['no_of_correct'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO previous_results VALUES('$email','$e_id' ,'0','0','0')")or die('Error');
}
$q=mysqli_query($con,"SELECT * FROM previous_results WHERE e_id='$e_id' AND email='$email' ")or die('Error115');

while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$r=$row['no_of_correct'];
}
$r++;
$s=$s+$no_of_correct;
$q=mysqli_query($con,"UPDATE `previous_results` SET `score`=$s,`no_of_correct`=$r WHERE  email = '$email' AND e_id = '$e_id'")or die('Error124');

} 
else
{
$q=mysqli_query($con,"SELECT * FROM quiz WHERE e_id='$e_id' " )or die('Error129');

while($row=mysqli_fetch_array($q) )
{
$no_of_incorrect=$row['no_of_incorrect'];
}
if($sn == 1)
{
$q=mysqli_query($con,"INSERT INTO previous_results VALUES('$email','$e_id' ,'0','0','0' )")or die('Error137');
}
$q=mysqli_query($con,"SELECT * FROM previous_results WHERE e_id='$e_id' AND email='$email' " )or die('Error139');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
$w=$row['no_of_incorrect'];
}
$w++;
$s=$s-$no_of_incorrect;
$q=mysqli_query($con,"UPDATE `previous_results` SET `score`=$s,`no_of_incorrect`=$w WHERE  email = '$email' AND e_id = '$e_id'")or die('Error147');
}
if($sn != $score)
{
$sn++;
header("location:account.php?q=quiz&step=2&e_id=$e_id&n=$sn&t=$score")or die('Error152');
}
else if( $_SESSION['key']!='harry19')
{
$q=mysqli_query($con,"SELECT score FROM previous_results WHERE e_id='$e_id' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
$rowcount=mysqli_num_rows($q);
if($rowcount == 0)
{
$q2=mysqli_query($con,"INSERT INTO rank VALUES('$email','$s',NOW())")or die('Error165');
}
else
{
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$s+$sun;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
}
header("location:account.php?q=result&e_id=$e_id");
}
else
{
header("location:account.php?q=result&e_id=$e_id");
}
}

//restart quiz
if(@$_GET['q']== 'quizre' && @$_GET['step']== 25 ) {
$e_id=@$_GET['e_id'];
$n=@$_GET['n'];
$t=@$_GET['t'];
$q=mysqli_query($con,"SELECT score FROM previous_results WHERE e_id='$e_id' AND email='$email'" )or die('Error156');
while($row=mysqli_fetch_array($q) )
{
$s=$row['score'];
}
$q=mysqli_query($con,"DELETE FROM `previous_results` WHERE e_id='$e_id' AND email='$email' " )or die('Error184');
$q=mysqli_query($con,"SELECT * FROM rank WHERE email='$email'" )or die('Error161');
while($row=mysqli_fetch_array($q) )
{
$sun=$row['score'];
}
$sun=$sun-$s;
$q=mysqli_query($con,"UPDATE `rank` SET `score`=$sun ,time=NOW() WHERE email= '$email'")or die('Error174');
header("location:account.php?q=quiz&step=2&e_id=$e_id&n=1&t=$t");
}

?>


