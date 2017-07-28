<?php

session_start();

include_once('webpage-utility/db_utility.php');
$conn = connect_to_db();

if($stmt = $conn->prepare('SELECT DesignerID FROM u_Designer WHERE paypal = ?')){

$stmt->bind_param('s', $_POST['paypal']);
}
else{ error_log('Check Paypal Error'); }

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

mysqli_close($conn);

?>
