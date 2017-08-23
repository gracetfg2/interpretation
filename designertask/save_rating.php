<?php


session_start();
if(!$_SESSION['designer_id']){ header('Location: ../index.php');  die();}
if(!$_GET['design_id']){ header('Location: ../index.php');  die();}
$designer_id=$_SESSION['designer_id'];
$design_id=$_GET['design_id'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();



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
	else{ echo "Sorry. You don't have permission to visit this page."; die();
	} 		

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
$designer_id=$designer['DesignerID'];

//************ Save Ratings
foreach ($_POST as $key => $value)
{	
    /*if (strpos($key,'a') !== false) {// action
    	//echo $key."and".$value."\n";
    	$sql = "UPDATE `Feedback` SET `action`=? WHERE `FeedbackID`=? ";
    	if($stmt = mysqli_prepare($conn,$sql)){
    		mysqli_stmt_bind_param($stmt, "ss",, substr($key,1));
    		$value=htmlspecialchars($value);
	   		mysqli_stmt_execute($stmt);
  		}

	}
	else // perceived quality
	{*/
		//echo $key."and".$value."\n";
		$sql = "UPDATE `Feedback` SET `designer_rating` =? WHERE `FeedbackID`=?";
		if($stmt = mysqli_prepare($conn,$sql)){
    		mysqli_stmt_bind_param($stmt, "ii",$value, $key);
	   		mysqli_stmt_execute($stmt);
  		}
		
	
	
} 



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
		
		$sql2 = "UPDATE `monitorbehavior` SET `review_time` =? , `review_behavior`=? WHERE `f_DesignerID`=?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "isi", $review_time, $review_behavior,$designer_id);			
			$review_time=$_POST['taskTime'];
			if(! is_null($current_record['review_time']))
			{
				$review_time=$current_record['review_time']+$review_time;
			}				
			//$review_behavior="../behavior/".$designer['group']."/s".$designer_id."-review.txt";
			mysqli_stmt_execute($stmt2);
		}
		else
		{ 
			echo $stmt2 ->error;
		}
	
	}
	else///New Record
	{	
		
		$stmt = $conn->prepare("INSERT INTO monitorbehavior(f_DesignerID, subject_group, review_time, review_behavior) VALUES ( ?, ?, ?, ?)");
   	   $stmt->bind_param("isis",  $designer_id, $designer['group'], $review_time, $review_behavior);
   	   $review_time=$_POST['taskTime'];
	   $review_behavior="../behavior/".$designer['group']."/s".$designer_id."-review.txt";
       $success = $stmt->execute();
    	
    	if(!$success){
        	echo $stmt->error;
     
    	}
	

	/*	$stmt = $conn->prepare("INSERT INTO MonitorBehavior (f_DesignerID, subject_group,review_time, review_behavior) VALUES (?, ? ,?, ?)");
		$stmt->bind_param("isis", $designer_id, $designer['group'], $review_time, $review_behavior);
		$stmt->execute();
		$stmt->close();
	
	*/	
		
	}
}
$myfile = fopen($review_behavior, "a");
$txt = "\n New Record\n".$_POST['_behavior']."\n";
fwrite($myfile, $txt);
fclose($myfile);



//************ Update Designer Status
	
	//Finished Task
	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
	if($stmt = mysqli_prepare($conn,$sql)){
		$process=5;
		mysqli_stmt_bind_param($stmt, "ii", $process, $designer_id);
		mysqli_stmt_execute($stmt);
	}	
	mysqli_stmt_close($stmt);
	mysqli_close($conn); 
	header('Location: second_stage.php');



?>