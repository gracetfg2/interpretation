<?php
session_start();
$designer_id=$_SESSION['designer_id'];
$currentVersion=$_POST['_stage'];
//************* Check  Login ****************// 
if(!$designer_id) { header("Location: ../index.php"); die(); }
if(!$currentVersion) { header("Location: ../index.php"); die(); }
//************* End Check Login ****************// 

include_once('/webpage-utility/db_utility.php');
$conn = connect_to_db();


$confidence="";
$time="";
$effort="";
$quality="";

    	

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

			$sql = "UPDATE `monitorbehavior` SET `confidence_".$currentVersion."` =? ,`design_time_".$currentVersion."`=?, `effort_".$currentVersion."`=?, `quality_".$currentVersion."`=? WHERE `f_DesignerID`=?";
		
			if($stmt2 = mysqli_prepare($conn,$sql)) {	
				mysqli_stmt_bind_param($stmt2, "isiii", $confidence,$time,$effort,$quality, $designer_id);
				$designer_id=$_SESSION['designer_id'];
				$confidence=$_POST['confidence'];
				$time=$_POST['time'];
				$effort=$_POST['effort'];
				$quality=$_POST['design_quality'];
				//ECHO $confidence.$time;
				mysqli_stmt_execute($stmt2);
			}
			else
			{
				$isOkay=0;
				echo "error happens!";die();
			}
		}
		else
		{
		
			$stmt2 = $conn->prepare("INSERT INTO monitorbehavior(f_DesignerID, confidence_".$currentVersion.", design_time_".$currentVersion.", effort_".$currentVersion.", quality_".$currentVersion.") VALUES ( ?, ?, ?,?,?)");

			$stmt2->bind_param("iisii",  $designer_id, $confidence,$time,$effort,$quality);
			$designer_id=$_SESSION['designer_id'];
			$confidence=$_POST['confidence'];
			$time=$_POST['time'];
			$effort=$_POST['effort'];
			$quality=$_POST['design_quality'];
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