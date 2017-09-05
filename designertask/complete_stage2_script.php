<?php
session_start();
$designer_id=$_SESSION['designer_id'];
$currentVersion=$_POST['_stage'];

//************* Check  Login ****************// 
if(!$designer_id) { header("Location: ../index.php"); die(); }
if(!$currentVersion) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
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

$explain_useful="";
$explain_selfexplain="";

/*Todo :check availibility
if($designer['process']<=3 && $currentVersion=2)  
	header("Location: ../reflection/index.php"); die();
else $currentVersion=2;
*/

$isOkay=1;

	/*****Save Data Info***********/
    if (!($stmt = mysqli_prepare($conn, "INSERT INTO monitorbehavior ( f_DesignerID, subject_group , confidence_".$currentVersion.", design_time_".$currentVersion.", effort_".$currentVersion.", quality_".$currentVersion.", degreeOfChange, feedback_useful, reflection_useful, explain_revision, explain_reflectionuse, explain_feedbackuse, explain_process, control_useful, explain_useful, explain_selfexplain) VALUES (?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,? )
    ON DUPLICATE KEY UPDATE
    
    f_DesignerID = VALUES(f_DesignerID), 
    subject_group = VALUES(subject_group), 
    confidence_".$currentVersion." = VALUES( confidence_".$currentVersion." ),
    effort_".$currentVersion." = VALUES(effort_".$currentVersion."),
    design_time_".$currentVersion." = VALUES(design_time_".$currentVersion."),
    quality_".$currentVersion." = VALUES(quality_".$currentVersion."),
    degreeOfChange = VALUES(degreeOfChange), 
    feedback_useful = VALUES(feedback_useful),
    reflection_useful = VALUES(reflection_useful),
    explain_revision = VALUES(explain_revision),
    explain_reflectionuse = VALUES(explain_reflectionuse), 
    explain_feedbackuse = VALUES(explain_feedbackuse),
    explain_process = VALUES(explain_process),
    control_useful = VALUES(control_useful),
    explain_useful = VALUES(explain_useful),
    explain_selfexplain = VALUES(explain_selfexplain)
    "))) {
        echo "SendData final survey prepare failed: (" . $conn->errno . ") " . $conn->error;
    }

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

	$explain_useful=$_POST['explain'];
	$explain_selfexplain=$_POST['ex_selfexplain'];	

    $stmt->bind_param("isiisiiiissssiis", $designer_id,$subject_group,$confidence,$time,$effort, $quality, $degreeOfChange, $feedback_useful, $reflection_useful, $explain_revision,$explain_reflectionuse,	$explain_feedbackuse,$explain_process, 	$control_useful, $explain_useful, $explain_selfexplain);
 	$success = $stmt->execute();
    if(!$success){  
        echo $stmt->error;
        $isOkay = 0;
        die();
    }	

    mysqli_stmt_close($stmt);
 	
 


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