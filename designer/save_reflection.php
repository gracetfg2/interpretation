<?php

session_start();
if(!$_SESSION['designer_id']){ header('Location: ../index.php');  die();}
if(!$_GET['design_id']){ header('Location: ../index.php');  die();}
$designer_id=$_SESSION['designer_id'];
$design_id=$_GET['design_id'];

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();
$isOkay= false;

//************Check Permission
$sql="SELECT * FROM Design WHERE DesignID=? AND f_DesignerID=?";
if($stmt=mysqli_prepare($conn,$sql))
{
	mysqli_stmt_bind_param($stmt,"ii",$design_id, $designer_id);
	mysqli_stmt_execute($stmt);
	$result = $stmt->get_result();
	while ($myrow = $result->fetch_assoc()) {
	    			$checkdesign[]=$myrow;
	 }

	if(count($checkdesign) > 0) {}
	else{ echo "Sorry. You don't have permission to visit this page."; die();} 		

}

//************ Get Designer Information
$sql="SELECT * FROM u_Designer WHERE DesignerID=?";
if($stmt=mysqli_prepare($conn,$sql))
{
	mysqli_stmt_bind_param($stmt,"i",$designer_id);
	mysqli_stmt_execute($stmt);
	$result = $stmt->get_result();
	$designer=$result->fetch_assoc() ;		 		

}

//************ Save Reflection

$sql="SELECT * FROM Reflection WHERE f_DesignerID=?";
if($stmt1=mysqli_prepare($conn,$sql))
{
	mysqli_stmt_bind_param($stmt1,"i",$designer_id);
	mysqli_stmt_execute($stmt1);
	$result = $stmt1->get_result();
	while ($myrow = $result->fetch_assoc()) {
	    $record[]=$myrow;
	 }

	if(count($record) > 0) {//Update Record
		
		$sql2 = "UPDATE `Reflection` SET `designconcept` =? , `good`=? , `bad`=?, `f_designID`=? WHERE `f_DesignerID`=?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "sssii", $concept, $good,$bad,$design_id,$designer_id);
			$concept=  $_POST['_designconcept'];
			$good= $_POST['_good'];
			$bad= $_POST['_bad'];
			mysqli_stmt_execute($stmt2);
		}
		else
		{ 
			echo $stmt2 ->error;
		}
	
	}
	else///New Record
	{	
		
		$stmt = $conn->prepare("INSERT INTO Reflection (f_DesignerID,subject_group,designconcept,good,bad,prepareTime,taskTime,numberOfPause ,numberOfDel,f_DesignID) VALUES ( ?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param("issssiiiii", $designer_id,$subject_group, $concept,$good,$bad,$prepareTime,$taskTime,$numberOfPause,$numberOfDel,$design_id);
			$concept=  $_POST['_designconcept'];
			$good= $_POST['_good'];
			$bad= $_POST['_bad'];	
		$subject_group=$designer['group'];
		$prepareTime=$_POST['prepareTime'];
		$taskTime=$_POST['taskTime'];
		$numberOfPause=$_POST['numberOfPause'];
		$numberOfDel=$_POST['numberOfDel'];
		$success = $stmt->execute();
		if(!$success){
			    echo "Error: " .$stmt->error; die();
		}
		
		
	}
}



$reflection_behavior="../behavior/".$designer['group']."/s".$designer_id."-reflection.txt";			
    
//***************Save behavior file
$sql="SELECT * FROM monitorbehavior WHERE f_DesignerID=?";
if($stmt1=mysqli_prepare($conn,$sql))
{
	mysqli_stmt_bind_param($stmt1,"i",$designer_id);
	mysqli_stmt_execute($stmt1);
	$result = $stmt1->get_result();
	while ($myrow = $result->fetch_assoc()) {
	    $record[]=$myrow;
	 }

	if(count($record) > 0) {//Update Record
		

		$sql2 = "UPDATE `monitorbehavior` SET `reflection_time` =? , `reflect_behavior`=? WHERE `f_DesignerID`=?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "isi", $taskTime, $reflection_behavior,$designer_id);
			$taskTime=$_POST['taskTime'];
			if(! is_null($myrow['reflection_time']))
			{
				$taskTime=$myrow['reflection_time']+$taskTime;
			}	
			
			$reflection_behavior="../behavior/".$designer['group']."/s".$designer_id."-reflection.txt";
			mysqli_stmt_execute($stmt2);
		}
		else
		{ 
			echo $stmt2 ->error;
		}
	
	}
	else///New Record
	{	
		
		$stmt = $conn->prepare("INSERT INTO monitorbehavior(f_DesignerID, subject_group, reflection_time, reflect_behavior) VALUES ( ?, ?, ?, ?)");
   	   $stmt->bind_param("isis",  $designer_id, $designer['group'], $taskTime, $reflection_behavior);
       $taskTime=$_POST['taskTime'];
       $reflection_behavior="../behavior/".$designer['group']."/s".$designer_id."-reflection.txt";			
       $success = $stmt->execute();    	
    	if(!$success){
        	echo $stmt->error;
     
    	}
		
	}
}

$myfile = fopen($reflection_behavior, "a");
$txt = "\n New Record\n".$_POST['_behavior']."\n";
fwrite($myfile, $txt);
fclose($myfile);

//************ Update Designer Status
if($designer['group']=='reflection' ||$designer['group']=='feedback-reflection' )
{	
	//Finished Task
	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
	if($stmt = mysqli_prepare($conn,$sql)){
		mysqli_stmt_bind_param($stmt, "ii", $process, $designer_id);
		$process=5;
		mysqli_stmt_execute($stmt);
	}	
	mysqli_stmt_close($stmt);
	mysqli_close($conn); 
	header('Location: second_stage.php');

}
else if ($designer['group']=='reflection-feedback')
{
	mysqli_close($conn); 
	header('Location: feedback.php');

}
else{
	header('Location: homepage.php');

}

?>
