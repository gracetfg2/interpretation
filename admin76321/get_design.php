<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `version`=1 ORDER BY f_DesignerID ASC")) {
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($myrow = $result->fetch_assoc()) {
	    			$design[]=$myrow;
	    			
	    		}  
	    		
	mysqli_stmt_close($stmt2);	
}
else {
//No Designs found
	echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
	mysqli_stmt_close($stmt2);
	die();
}





foreach($design as  $value) 
	{	echo " <div><a href='set_feedback.php?design_id=".$value['DesignID']."' target='_blank'>Set</a>; DesignerID".$value['f_DesignerID'].": <a href='../overall.php?mid=".$value['mid']."' value='overall.php?mid=".$value['mid']."''>review-my-design.org/reflection/overall.php?mid=".$value['mid']."</a></div>";
	    	}

?>