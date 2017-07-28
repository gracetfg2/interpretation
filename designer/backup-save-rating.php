<?php


session_start();
if(!$_SESSION['designer_id']){ header('Location: ../index.php');  die();}
if(!$_GET['design_id']){ header('Location: ../index.php');  die();}
$designer_id=$_SESSION['designer_id'];
$design_id=$_GET['design_id'];

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

//***************Save behavior file
$review_time=$_POST['taskTime'];
$review_behavior="../behavior/".$designer['group']."/review-s".$designer_id.".txt";
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
			
			if(! is_null($current_record['review_time']))
			{
				$review_time=$current_record['review_time']+$review_time;
			}	
			
			mysqli_stmt_bind_param($stmt2, "isi", $review_time, $review_behavior,$designer_id);
			mysqli_stmt_execute($stmt2);
		}
		else
		{ 
			echo $stmt2 ->error;
		}
	
	}
	else///New Record
	{	
		echo "here";
		$stmt = $conn->prepare("INSERT INTO monotorbehavior(f_DesignerID, subject_group, review_time, review_behavior) VALUES ( ?, ?, ?, ?)");
   	   $stmt->bind_param("isis",  $designer_id, $designer['group'], $review_time, $review_behavior);
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
$txt = "\n Reflection Record\n".$_POST['_behavior']."\n";
fwrite($myfile, $txt);
fclose($myfile);






//************Check Permission
	if ($stmt1 = mysqli_prepare($conn, "SELECT file From Design WHERE DesignID = ? AND f_DesignerID = ?")) {
	    mysqli_stmt_bind_param($stmt1, "ii", $design_id,$designer_id);
	    mysqli_stmt_execute($stmt1);
	    $stmt1->store_result();
		if($stmt1->num_rows > 0) {
		    mysqli_stmt_bind_result($stmt1, $filename);
		    mysqli_stmt_fetch($stmt1);
		   
		}
		else
		{	
			mysqli_stmt_close($stmt1);
			echo "You don't have the permission to view this page. If you have any questions, please contact Grace (yyen4@illinois.edu) with error code: SAVERATING1";
			die();
		}
	}
	else 
	{
			echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SAVERATING2";
		    mysqli_stmt_close($stmt1);
		    die();
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
    if (strpos($key,'a') !== false) {// action
    	//echo $key."and".$value."\n";
    	$sql = "UPDATE `Feedback` SET `action`=? WHERE `FeedbackID`=? ";
    	if($stmt = mysqli_prepare($conn,$sql)){
    		mysqli_stmt_bind_param($stmt, "ss",htmlspecialchars($value), substr($key,1));
	   		mysqli_stmt_execute($stmt);
  		}

	}
	else // perceived quality
	{
		//echo $key."and".$value."\n";
		$sql = "UPDATE `Feedback` SET `designer_rating` =? WHERE `FeedbackID`=?";
		if($stmt = mysqli_prepare($conn,$sql)){
    		mysqli_stmt_bind_param($stmt, "ss",htmlspecialchars($value), htmlspecialchars($key));
	   		mysqli_stmt_execute($stmt);
  		}
		
	}
	
} 




//************ Update Designer Status
if($designer['group']=='feedback' ||$designer['group']=='reflection-feedback' )
{
	
	//Finished Task
	$sql = "UPDATE `u_Designer` SET `process` =? WHERE `DesignerID`=?";
	if($stmt = mysqli_prepare($conn,$sql)){
		$process=5;
		mysqli_stmt_bind_param($stmt, "ii", $process, $designer_id);
		mysqli_stmt_execute($stmt);
	}	
	mysqli_stmt_close($stmt);
	mysqli_close($conn); 
	header('Location: homepage.php');

}
else if ($designer['group']=='feedback-reflection')
{
	mysqli_close($conn); 
	header('Location: reflection.php');

}

?>