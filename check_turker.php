<?php

//echo "hereeeeee";
include_once('webpage-utility/db_utility.php');
$conn = connect_to_db();

if($stmt = $conn->prepare('SELECT FeedbackID FROM Feedback WHERE turkerID = ?')){

	$stmt->bind_param('s', $_POST['turker']);
}
else{ }

$stmt->execute();
$res = $stmt->get_result();

if(mysqli_num_rows($res) > 0){
	echo "exists";
	// $result = "exists";
}
else{
	echo "success";
	// $result = "success";
}

// echo json_encode($result);

// echo json_encode(array('exists' => $query->rowCount() > 0));

mysqli_close($conn);

?>
