<?php 
	
	session_start();	
	//check session
	$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"]=1;
	if(!$DESIGNER) { header("Location: ".$_SERVER['SCRIPT_URI']."/reflection/index.php"); die(); }
		
	
	include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
   	

	$sql="SELECT * FROM u_Designer WHERE DesignerID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$designer=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	

	}
	
  mysqli_close($conn);
?>
<html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	<?php include('../webpage-utility/ele_header.php');?>
    <title>Home </title>
    <!-- Custom styles for this template -->
<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:400,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="../step-indicator/css/reset.css"> <!-- CSS reset -->
	<link rel="stylesheet" href="../step-indicator/css/style.css"> <!-- Resource style -->
	<script src="js/modernizr.js"></script> <!-- Modernizr -->

 </head>
 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>
<div class="main-section">


<div class="container">


<ol class="cd-breadcrumb triangle custom-icons">
	<li class="visited"><a href="#0">Sign Up</a></li>
	<li ><a href="#0">First Stage - Initial Design </a></li>
	<li ><a href="#0"> Wait... </a></li>
	<li class="current"><em>Second Stage - Reflection and Revise </em></li>
	<li><em>Final Survey</em></li>
</ol>

<?php
switch ($designer['process']){

		case 0: //probelm in consent form or anything else
		case 1: 
			//include('background_survey.php'); break;
		case 2: //finish background survey->initial design
			include("include_first_stage.php"); break;
			//include('first_stage.php'); break;
		case 3: //Waiting stage
			header("Location: waiting.php"); break;
		case 4: //collected feedback
			switch ($designer['group']){
				case 'feedback':	header("Location: feedback.php"); break;
				case 'reflection':	header("Location: reflection.php"); break;
				case 'reflection-feedback':	header("Location: rfeedback.php"); break;
				case 'feedback-reflection':	header("Location: feedbackr.php"); break;
				default: echo "Oops! There is some problem in the stage. please contact yyen4@illinoi.edu and gave her error code: STAGE3GROUP"; die();
			}			
			break;
		case 5: //After finish the intenvention
			header("Location: second_stage.php"); break;
		case 6:
			header('final_survey.php');break;
		default: echo "Oops! There is some problem in the stage. please contact yyen4@illinoi.edu and gave her error code: CONDITION DEFAULT"; die();

		}

?>



</div>


 </body>



</html>



