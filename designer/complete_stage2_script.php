<?php
session_start();
$designer_id=$_SESSION['designer_id'];
$currentVersion=$_POST['_stage'];

//************* Check  Login ****************// 
if(!$designer_id) { header("Location: ../index.php"); die(); }
if(!$currentVersion) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();


$confidence="";
$time="";
$effort="";
$design_quality="";

$degreeOfChange="";
$explain_revision="";
$feedback_useful="";
$reflection_useful="";

$explain_reflectionuse="";
$explain_feedbackuse="";

$explain_process="";
$control_useful="";

/*Todo :check availibility
if($designer['process']<=3 && $currentVersion=2)  
	header("Location: ../reflection/index.php"); die();
else $currentVersion=2;
*/

$isOkay=1;

	$sql="SELECT * FROM monitorbehavior WHERE f_DesignerID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$designer_id);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		while ($myrow = $result->fetch_assoc()) {
		    			$record[]=$myrow;
		 }


		if(count($record)>0)
		{

			$sql = "UPDATE `monitorbehavior` SET `subject_group`=?, `confidence_".$currentVersion."` =? ,`design_time_".$currentVersion."`=?, `effort_".$currentVersion."`=?, `quality_".$currentVersion."`=?, `degreeOfChange`=?, `feedback_useful`=?,`reflection_useful`=?,`explain_revision`=?,`explain_feedbackuse`=?,`explain_reflectionuse`=?, `explain_process`=?,`control_useful`=?   WHERE `f_DesignerID`=?";
		
			if($stmt2 = mysqli_prepare($conn,$sql)) {	
				mysqli_stmt_bind_param($stmt2, "siiiiiiissssii", $subject_group, $confidence,$time,$effort,$quality,$degreeOfChange,$feedback_useful,$reflection_useful,$explain_revision,$explain_feedbackuse,$explain_reflectionuse,$explain_process,$control_useful, $designer_id);
				$subject_group=$_POST['_group'];
				$designer_id=$_SESSION['designer_id'];
				$confidence=$_POST['confidence'];
				$time=$_POST['time'];
				$effort=$_POST['effort'];
				$quality=$_POST['design_quality'];
				$degreeOfChange=$_POST['degreeOfChange'];
				$feedback_useful=$_POST['feedback'];
				$reflection_useful=$_POST['reflection'];
				$explain_revision=$_POST['mainChange'];
				
				$explain_reflectionuse=$_POST['ex_reflection'];
				$explain_feedbackuse=$_POST['ex_feedback'];

				$explain_process=$_POST['explain_process'];
				$control_useful=$_POST['control_useful'];

				
				//ECHO $confidence.$time;
				mysqli_stmt_execute($stmt2);
			}
			else
			{
				$isOkay=0;
				echo "error happens!".mysqli_stmt_error($stmt2);die();
			}
		}
		else
		{
		
			$stmt2 = $conn->prepare("INSERT INTO monitorbehavior(f_DesignerID, subject_group, confidence_".$currentVersion.", design_time_".$currentVersion.", effort_".$currentVersion.", quality_".$currentVersion.", degreeOfChange, feedback_useful, reflection_useful, explain_revision, explain_reflectionuse, explain_feedbackuse, explain_process, control_useful) VALUES ( ?,?, ?, ?,?,?,?,?,?,?,?,?,?,?)");

			$stmt2->bind_param("iisiiiiisss",  $designer_id, $subject_group, $confidence,$time,$effort,$quality,$degreeOfChange,$feedback_useful,$reflection_useful,$explain_revision,$explain_reflectionuse,$explain_feedbackuse,$explain_process,$control_useful);
			$subject_group=$_POST['_group'];
			$designer_id=$_SESSION['designer_id'];
			$confidence=$_POST['confidence'];
			$time=$_POST['time'];
			$effort=$_POST['effort'];
			$quality=$_POST['design_quality'];
			$degreeOfChange=$_POST['degreeOfChange'];
			$feedback_useful=$_POST['feedback'];
			$reflection_useful=$_POST['reflection'];
			$explain_revision=$_POST['mainChange'];
			$explain_reflectionuse=$_POST['ex_reflection'];
			$explain_feedbackuse=$_POST['ex_feedback'];

				$explain_process=$_POST['explain_process'];
				$control_useful=$_POST['control_useful'];



		    $success = $stmt2->execute();
		    if(!$success){  
		        echo $stmt2->error;
		        $isOkay = 0;
		        die();
		    }	


		}
	}
	else
	{
		echo "error happens 2!";die();
	}



if($isOkay==1)
{
	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
	if($stmt3 = mysqli_prepare($conn,$sql)){

		mysqli_stmt_bind_param($stmt3, "ii", $process, $designer_id);
		if($currentVersion==1)	$process=3;
		else if ($currentVersion==2) $process=6;
		mysqli_stmt_execute($stmt3);
	}	
	else
	{
		echo "error happens 3!";die();
	}
}



mysqli_close($conn);//""
header( "Location: homepage.php");

?>