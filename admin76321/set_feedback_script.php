<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

foreach ($_POST as $key => $value)
{


  if (strpos($key,'f') !== false) {// process
		$sql2 = "UPDATE ExpertFeedback SET `ok_to_use` ='".htmlspecialchars($value)."' WHERE FeedbackID=".substr($key,1);
		if (mysqli_query($conn, $sql2)) {
		    //echo $sql2."</br>";
		} else {
		    echo "Error updating record: " . mysqli_error($conn);
		}
	}else if (strpos($key,'a') !== false) {// process
		
		$sql2 = "UPDATE `ExpertFeedback` SET `edited_content` =? WHERE `FeedbackID`=?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "si", $edit,$feedback_id);
			$edit=$value;
			$feedback_id=substr($key,1);
			
			mysqli_stmt_execute($stmt2);
		}



	}else if (strpos($key,'o') !== false) {// process
		
		$sql2 = "UPDATE `Feedback` SET `category` =? WHERE `FeedbackID`=?";
		if($stmt2 = mysqli_prepare($conn,$sql2)){
			mysqli_stmt_bind_param($stmt2, "si", $value,$feedback_id);
			
			$feedback_id=substr($key,1);
			
			mysqli_stmt_execute($stmt2);
		}



	}
  
}

mysqli_close($conn);
header('Location: control_panel.php');

?>
