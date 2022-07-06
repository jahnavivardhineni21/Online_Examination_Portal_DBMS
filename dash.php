<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>NITC ADMIN LOGIN</title>
<link rel="stylesheet" type="text/css" href="css/grid.css">
        <link rel="stylesheet" type="text/css" href="css/ionicons.min.css">
        <link rel="stylesheet" type="text/css" href="css/normalize.css">
    <link  rel="stylesheet" href="css/bootstrap.min.css"/>
 <link  rel="stylesheet" href="css/bootstrap-theme.min.css"/>    
 <link rel="stylesheet" href="css/main.css">
 <link  rel="stylesheet" href="css/font.css">
 <script src="js/jquery.js" type="text/javascript"></script>

  <script src="js/bootstrap.min.js"  type="text/javascript"></script>
 	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>

<script>
$(function () {
    $(document).on( 'scroll', function(){
        console.log('scroll top : ' + $(window).scrollTop());
        if($(window).scrollTop()>=$(".logo").height())
        {
             $(".navbar").addClass("navbar-fixed-top");
        }

        if($(window).scrollTop()<$(".logo").height())
        {
             $(".navbar").removeClass("navbar-fixed-top");
        }
    });
});</script>
</head>

<body style="background:#eee;">
<div class="header">

<?php
 include_once 'dbConnection.php';
session_start();
$email=$_SESSION['email'];
  if(!(isset($_SESSION['email']))){
header("location:index.php");

}
else
{
$username = $_SESSION['username'];;

include_once 'dbConnection.php';
echo '<span class="pull-right top title1" ><span class="log1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;</span> <a href="account.php" class="log log1">'.$username.'</a>&nbsp;|&nbsp;<a href="logout.php?q=account.php" class="log"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;Logout</button></a></span>';
}?>

</div></div>
<!-- admin start-->
<div class="bg">
<!--navigation menu-->
<nav class="navbar navbar-default title1">
  <div class="container-fluid">
    <!--  toggle -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="dash.php?q=0"><b>Dashboard</b></a>
    </div>
    <!-- nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li <?php if(@$_GET['q']==0) echo'class="active"'; ?>><a href="dash.php?q=0">Home<span class="sr-only">(current)</span></a></li>
        <li <?php if(@$_GET['q']==1) echo'class="active"'; ?>><a href="dash.php?q=1">Student's Profile</a></li>
		<li <?php if(@$_GET['q']==2) echo'class="active"'; ?>><a href="dash.php?q=2">Rank</a></li>
		<li <?php if(@$_GET['q']==3) echo'class="active"'; ?>><a href="dash.php?q=3">Comments</a></li>
        <li class="dropdown <?php if(@$_GET['q']==4 || @$_GET['q']==5) echo'active"'; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quiz<span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="dash.php?q=4">Add Test</a></li>
            <li><a href="dash.php?q=5">Remove Test</a></li>
			
          </ul>
        </li><li class="pull-right"> <a href="logout.php?q=account.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span>&nbsp;&nbsp;&nbsp;&nbsp;Logout</a></li>
		
      </ul>
          </div>
  </div>
</nav>

<div class="container">
<div class="row">
<div class="col-md-12">
<!--home start-->

<?php if(@$_GET['q']==0) {

$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr style="color:#62a1b5;"><td><b>Sl No</b></td><td><b>Name of Test</b></td><td><b>Total no.of questions</b></td><td><b>Score</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$name_of_exam = $row['name_of_exam'];
	$score = $row['score'];
	$no_of_correct = $row['no_of_correct'];
    $time = $row['time'];
	$e_id = $row['e_id'];
$q12=mysqli_query($con,"SELECT score FROM previous_results WHERE e_id='$e_id' AND email='$email'" )or die('Error98');
$rowcount=mysqli_num_rows($q12);	
if($rowcount == 0){
	echo '<tr><td>'.$c++.'</td><td>'.$name_of_exam.'</td><td>'.$score.'</td><td>'.$no_of_correct*$score.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="account.php?q=quiz&step=2&eid='.$e_id.'&n=1&t='.$score.'" </a></b></td></tr>';
}
else
{
echo '<tr style="color:lightblue"><td>'.$c++.'</td><td>'.$name_of_exam.'&nbsp;<span title="This quiz is already solved" class="glyphicon glyphicon-ok" aria-hidden="true"></span></td><td>'.$score.'</td><td>'.$no_of_correct*$score.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=quizre&step=25&e_id='.$e_id.'&n=1&t='.$score.'" class="pull-right btn sub1" style="margin:0px;background:#62a1b5"><span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Retake</b></span></a></b></td></tr>';
}
}
$c=0;
echo '</table></div></div>';

}

//rank start
if(@$_GET['q']== 2) 
{
$q=mysqli_query($con,"SELECT * FROM rank  ORDER BY score DESC " )or die('Error223');
echo  '<div class="panel title"><div class="table-responsive">
<table class="table table-striped title1" >
<tr style="color:#62a1b5"><td><b>Rank</b></td><td><b>UserName</b></td><td><b>Gender</b></td><td><b>Roll Number</b></td><td><b>Score</b></td></tr>';
$c=0;
while($row=mysqli_fetch_array($q) )
{
$e=$row['email'];
$s=$row['score'];
$q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e' " )or die('Error231');
while($row=mysqli_fetch_array($q12) )
{
$username=$row['username'];
$gender=$row['gender'];
$roll_number=$row['roll_number'];
}
$c++;
echo '<tr><td style="color:#62a1b5"><b>'.$c.'</b></td><td>'.$username.'</td><td>'.$gender.'</td><td>'.$roll_number.'</td><td>'.$s.'</td><td>';
}
echo '</table></div></div>';}

?>


<!--home closed-->
    
<!--users start-->
<?php if(@$_GET['q']==1) {

$result = mysqli_query($con,"SELECT * FROM user") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr style="color:#62a1b5;"><td><b>Sl No</b></td><td><b>UserName</b></td><td><b>Gender</b></td><td><b>Roll Number</b></td><td><b>Email</b></td><td><b>Mobile Number</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$username = $row['username'];
	$mobile_number = $row['mobile_number'];
	$gender = $row['gender'];
    $email = $row['email'];
	$roll_number = $row['roll_number'];

	echo '<tr><td>'.$c++.'</td><td>'.$username.'</td><td>'.$gender.'</td><td>'.$roll_number.'</td><td>'.$email.'</td><td>'.$mobile_number.'</td>
	<td><a title="Remove User" href="update.php?demail='.$email.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td></tr>';
}
$c=0;
echo '</table></div></div>';

}?>
<!--user end-->

<!--comment start-->
<?php if(@$_GET['q']==3) {
$result = mysqli_query($con,"SELECT * FROM `comment` ORDER BY `comment`.`date` DESC") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr style="color:#62a1b5;"><td><b>Sl No</b></td><td><b>Email</b></td><td><b>Date</b></td><td><b></b></td><td></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$date = $row['date'];
	$date= date("d-m-Y",strtotime($date));
	$username = $row['username'];
	$email = $row['email'];
	$id = $row['id'];
	 echo '<tr><td>'.$c++.'</td>';
	echo '<td><a title="View Comment" href="dash.php?q=3&fid='.$id.'">'.$email.'</a></td><td>'.$date.'</td><td>'.$username.'</td><td>'.$username.'</td>
	<td><a title="Open Comment" href="dash.php?q=3&fid='.$id.'"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></b></a></td>';
	echo '<td><a title="Delete Comment" href="update.php?fdid='.$id.'"><b><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></b></a></td>

	</tr>';
}
echo '</table></div></div>';
}
?>
<!--comment closed-->

<!--reading comment-->
<?php if(@$_GET['fid']) {
echo '<br />';
$id=@$_GET['fid'];
$result = mysqli_query($con,"SELECT * FROM comment WHERE id='$id' ") or die('Error');
while($row = mysqli_fetch_array($result)) {
	$username = $row['username'];
	$date = $row['date'];
	$date= date("d-m-Y",strtotime($date));
	$feedback = $row['feedback'];
	
echo '<div class="panel"<a title="Archive" href="update.php?q1=2"><b><span class="glyphicon glyphicon-level-up" aria-hidden="true"></span></b></a><h2 style="text-align:center; margin-top:-15px;font-family: "Lato", sans-serif;"></h1>';
 echo '<div class="mCustomScrollbar" data-mcs-theme="dark" style="margin-left:10px;margin-right:10px; max-height:450px; line-height:35px;padding:5px;"><span style="line-height:35px;padding:5px;">-&nbsp;<b>DATE:</b>&nbsp;'.$date.'</span>
<span style="line-height:35px;padding:5px;">&nbsp;<b>By:</b>&nbsp;'.$username.'</span><br />'.$feedback.'</div></div>';}
}?>
<!--reading comment closed-->

<!--add quiz-->
<?php
if(@$_GET['q']==4 && !(@$_GET['step']) ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Add Test</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6">   <form class="form-horizontal title1" name="form" action="update.php?q=addtest"  method="POST">
<fieldset>


<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="name_of_exam"></label>  
  <div class="col-md-12">
  <input id="name_of_exam" name="name_of_exam" placeholder="Name of the Test" class="form-control input-md" type="text">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="score"></label>  
  <div class="col-md-12">
  <input id="score" name="score" placeholder="Enter total number of questions" class="form-control input-md" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="no_of_correct"></label>  
  <div class="col-md-12">
  <input id="no_of_correct" name="no_of_correct" placeholder="Enter marks on right answer" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="no_of_incorrect"></label>  
  <div class="col-md-12">
  <input id="no_of_incorrect" name="no_of_incorrect" placeholder="Enter minus marks on wrong answer without sign" class="form-control input-md" min="0" type="number">
    
  </div>
</div>

<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="time"></label>  
  <div class="col-md-12">
  <input id="time" name="time" placeholder="Enter time limit for test in minute" class="form-control input-md" min="1" type="number">
    
  </div>
</div>



<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="description"></label>  
  <div class="col-md-12">
  <textarea rows="8" cols="8" name="description" class="form-control" placeholder="Description"></textarea>  
  </div>
</div>


<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Add" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';



}
?>


<!--add quiz step2 -->
<?php
if(@$_GET['q']==4 && (@$_GET['step'])==2 ) {
echo ' 
<div class="row">
<span class="title1" style="margin-left:40%;font-size:30px;"><b>Enter Question Details</b></span><br /><br />
 <div class="col-md-3"></div><div class="col-md-6"><form class="form-horizontal title1" name="form" action="update.php?q=addqns&n='.@$_GET['n'].'&e_id='.@$_GET['e_id'].'&ch=4 "  method="POST">
<fieldset>
';
 
 for($i=1;$i<=@$_GET['n'];$i++)
 {
echo '<b>Question number&nbsp;'.$i.'&nbsp;:</><br /><!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="questions'.$i.' "></label>  
  <div class="col-md-12">
  <textarea rows="3" cols="5" name="questions'.$i.'" class="form-control" placeholder="question number '.$i.'"></textarea>  
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'1"></label>  
  <div class="col-md-12">
  <input id="'.$i.'1" name="'.$i.'1" placeholder="option a:" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'2"></label>  
  <div class="col-md-12">
  <input id="'.$i.'2" name="'.$i.'2" placeholder="option b" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'3"></label>  
  <div class="col-md-12">
  <input id="'.$i.'3" name="'.$i.'3" placeholder="option c" class="form-control input-md" type="text">
    
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-12 control-label" for="'.$i.'4"></label>  
  <div class="col-md-12">
  <input id="'.$i.'4" name="'.$i.'4" placeholder="option d" class="form-control input-md" type="text">
    
  </div>
</div>
<br />
<b>Correct answer</b>:<br />
<select id="ans'.$i.'" name="ans'.$i.'" placeholder="Choose correct option " class="form-control input-md" >
   <option value="a">Select answer for question '.$i.'</option>
  <option value="a">option a</option>
  <option value="b">option b</option>
  <option value="c">option c</option>
  <option value="d">option d</option> </select><br /><br />'; 
 }
    
echo '<div class="form-group">
  <label class="col-md-12 control-label" for=""></label>
  <div class="col-md-12"> 
    <input  type="submit" style="margin-left:45%" class="btn btn-primary" value="Submit" class="btn btn-primary"/>
  </div>
</div>

</fieldset>
</form></div>';



}
?>

<!--remove quiz-->
<?php if(@$_GET['q']==5) {

$result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC") or die('Error');
echo  '<div class="panel"><div class="table-responsive"><table class="table table-striped title1">
<tr style="color:#62a1b5;"><td><b>Sl No</b></td><td><b>Topic</b></td><td><b>Total question</b></td><td><b>Marks</b></td><td><b>Time limit</b></td><td></td></tr>';
$c=1;
while($row = mysqli_fetch_array($result)) {
	$name_of_exam = $row['name_of_exam'];
	$score = $row['score'];
	$no_of_correct = $row['no_of_correct'];
    $time = $row['time'];
	$e_id = $row['e_id'];
	echo '<tr><td>'.$c++.'</td><td>'.$name_of_exam.'</td><td>'.$score.'</td><td>'.$no_of_correct*$score.'</td><td>'.$time.'&nbsp;min</td>
	<td><b><a href="update.php?q=rmquiz&e_id='.$e_id.'" class="pull-right btn sub1" style="margin:0px;background:#62a1b5;font-size:20%"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;<span class="title1"><b>Remove</b></span></a></b></td></tr>';
}
$c=0;
echo '</table></div></div>';

}
?>


</div>
</div></div>
</body>
</html>
