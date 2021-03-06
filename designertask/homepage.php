<?php 
	
	session_start();	
	//check session
	$DESIGNER= $_SESSION['designer_id'];
	$experimentID= $_SESSION['experimentID'];
	//if($experimentID!=3){ header("Location: ../index.php"); die(); }
	
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
		
	include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');

	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
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


	$sql="SELECT * FROM Design WHERE f_DesignerID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$DESIGNER);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		while ($myrow = $result->fetch_assoc()) {
		    $record[]=$myrow;
		 }
		 $design_number=count($record);	
	    mysqli_stmt_close($stmt);	

	}
	$stage=$designer['process'];
	$group=$designer['group'];

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
	<script src="../step-indicator/js/modernizr.js"></script> <!-- Modernizr -->
 </head>
 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_nav.php');?>
<div class="main-section">


<div class="container">

<ol class="cd-multi-steps text-center custom-icon">
	<li class="visited"><em>Sign Up  </em></li>
	<li class="<?php if($stage<=2) echo "current"; else if($stage>1) echo "visited";?>"><em>First Stage  </em></li>
	<li class="<?php if($stage==3) echo "current"; else if($stage>3) echo "visited";?>"><em>Preparation  </em></li>
	<li class="<?php if($stage==4 ||$stage==5 ) echo "current"; else if($stage>5) echo "visited";?>"><em>Second Stage  </em></li>
	<li class="<?php if($stage==6) echo "current"; else if($stage>6) echo "visited";?>"><em>Completion</em></li>
</ol>



<div class="jumbotron" style='width:80%; height:auto ;margin:0px auto;' >

  <div class="container" style="line-height: 180%;font-family: 'Palatino Linotype', 'Book Antiqua', Palatino, serif'">
<?php 
/*
$headline=array("","Hi ".$designer['name']."<br> You will need to complete the first stage of the study by <span style='color:red'>May 30th. Look forward to your submission and good luck with your design!</span>",
"Hi ".$designer['name']."<br> You will need to complete the first stage of the study by <span style='color:red'>May 30th. Look forward to your submission and good luck with your design!</span>",
"Awesome! You have completed the first stage of the study! We will contact you once the second stage of the study is ready to go!","ss","ssd"
);*/

switch ($stage){
	case 0: 
	case 1:
	case 2:
			echo "<p style='text-align:center;font-weight:bold'> Welcome to the design study! </p>
 				 <p>In the first phase of the study, you will need to create and submit a flyer by <span style='color:red'>".$first_deadline.".</span> 
 				 <p> Now, please click 'Next' to read the design task. We hope you enjoy the task and look forward to seeing your creative solutions!
 				  </p><p><a class='btn btn-primary btn-lg' href='first_stage.php' role='button'>Next</a></p>";	
		
		break;
	case 3:
		echo "
			<p style='text-align:center;font-weight:bold'>You have completed the first phase of the study! </p>
	
		<p> The two designers will provide feedback on your design. Once the material for the second phase is ready, we will notify you through your contact email. This will take around three days. </p>
		";
		break;
	case 4:
		//$group="reflection-feedback";
		$inst_design="Revise your initial design.";
		$inst_review="Review feedback from the target audience.";
		$inst_explain="Restate the meaning of each feedback using your own words.";
		$inst_reflect="Reflect on the set of feedback.";
		$inst_complete="Complete a survey asking about your design process.";
		$next_page="";
		
		if ($group==NULL)
		{
			echo "<p style='text-align:center;font-weight:bold'>We are still preparing for your second phase study. </p>
			<p>If you haven't heard from us for more than a week, please contact us.</p>";
			die();	
		}
		echo "<p style='text-align:center;font-weight:bold'>Hi ".$designer['name'].", Welcome back to the study!</p><p> In this phase, you need to complete the following steps by 
			 <span style='color:red'>".$designer['second_deadline']."</span>. </p>  
	 			";
	 
		switch ($group){
			case 'self_explain':
				echo "<p>	 				
	 				 1) ".$inst_review." <br>
	 				 2) ".$inst_explain."<br>
	 				 3) ".$inst_design." <br>
	 				 4) ".$inst_complete." <br>
	 				</p>";
				$next_page="explain_initial.php";
	 			break;
			case 'reflection':
				echo "<p>	 				
	 				 1) ".$inst_review."<br>
	 				 2) ".$inst_reflect."<br>
	 				 3) ".$inst_design."<br>
	 				 4) ".$inst_complete."<br>
	 				</p>";
				$next_page="reflection.php";
				break;
			case 'explain_reflect':
				echo "<p>	 				
	 				1) ".$inst_review." <br>
	 				2) ".$inst_explain." <br>
	 				3) ".$inst_reflect." <br>
	 				4) ".$inst_design." <br>
	 				5) ".$inst_complete." <br>
	 				</p>";
				$next_page="explain_initial.php";
				break;
	 		case 'control':
	 			echo "<p>	 				
	 				 1) ".$inst_review." <br>
	 				 2) ".$inst_design." <br>
	 				 3) ".$inst_complete." <br>
	 				</p>";
				$next_page="feedback.php";
 				break;
			default:
				echo "Something Goes wrong";die();
				break;
		}
		echo "<p>Please have your initial design ready in the tool, and we will step you through the second phase. More importantly, we hope you will enjoy the task!</p>";
		echo "<p><a class='btn btn-primary btn-lg' href='".$next_page."' role='button'>Next</a></p>";
		break;
	case 5:
		echo "<p>Hi ".$designer['name'].", </p>
 				 <p>Please SUBMIT your revised design by <span style='color:red'>".$designer['second_deadline']."</span>.</p>";		
		echo "<p><a class='btn btn-primary btn-lg' href='second_stage.php' role='button'>Next</a></p>"; 
		break;
	case 6:
		echo "<p style='text-align:center;font-weight:bold'>Thank you for participating! </p>
		<p>The compensation for the study ($30) will be sent to your Paypal account <span style='color:blue'>".$designer['paypal']."</span> shortly.";
		echo "
			If you do not receive the payment by ".$pay_deadline.", please contact Grace Yen at <span style='text-decoration:underline'> ".$admin_email." </span>. </p><p>The winners of the competition will receive a notification through the contact email by ".$contest_deadline.". Wish you the best luck ! </p><br>
		<p style='font-size:16px'><span style='font-weight:bold'>Best Regards,</span><br> Grace Y. Yen, PhD Candidate<br>Department of Computer Sciecne<br>University of Illinois @ Urbana-Champaign</p>
		";
		break;
	default:
		echo "Design Study ";
		break;
}

?>
</div>

</div>

<?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/footer.php'); ?>

</div>

 </div>
 </body>



</html>