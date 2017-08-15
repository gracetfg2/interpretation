<?php 
//************ Save Reflection

echo "action_plan_time=".$_POST['action_plan_time'];
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
	$conn = connect_to_db();
	 	if (!$conn) {
	     die("Connection failed: " . mysqli_connect_error());
	 }

	
	$stmt = $conn->prepare("INSERT INTO PilotTest (mid, interprete1,interprete2,interprete3, actionplan, f1_rating, f2_rating, f3_rating, prepareTime, taskTime, numberOfPause, numberOfDel, action_plan_time, reviewDesignTime) VALUES ( ?,?,?,?,?,?,?,?,?,?,?,?,?,?)");


	$stmt->bind_param("sssssiiiiiiiii", $mid, $f1, $f2, $f3, $action, $f1_rating, $f2_rating, $f3_rating, $prepareTime, $taskTime, $numberOfPause, $numberOfDel, $action_plan_time,$reviewDesignTime);
	

		 $mid=  $_POST['_mid'];
		 $f1=  $_POST['f1'];
		 $f2= $_POST['f2'];
		 $f3= $_POST['f3'];	
		 $f1_rating= $_POST['feedback1_rating'];	
		 $f2_rating= $_POST['feedback2_rating'];	
		 $f3_rating= $_POST['feedback3_rating'];	
		 $action= $_POST['action_plan'];	

		 $action_plan_time= $_POST['action_plan_time'];		
		 $prepareTime=$_POST['prepareTime'];
		 $taskTime=$_POST['taskTime'];

		 $reviewDesignTime=$_POST['reviewDesignTime'];
		 $numberOfPause=$_POST['numberOfPause'];
		 $numberOfDel=$_POST['numberOfDel'];

	
	

		
	$success = $stmt->execute();
	if(!$success){
		    echo "Error: " .$stmt->error; die();
	}else
	{
		echo "The submission code is <strong>N6SGKUBhs8F6T</strong>. <br>Please copy the code and paste it to the HIT page to receive your compensation. ";

	}
	
	
?>