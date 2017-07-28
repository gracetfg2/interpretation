<?php
error_log($_POST['email']);
//echo "hereeeeee";
include_once('webpage-utility/db_utility.php');
$conn = connect_to_db();

if($stmt = $conn->prepare('SELECT DesignerID FROM u_Designer WHERE email = ?')){
error_log('prepared');
$stmt->bind_param('s', $_POST['email']);
}
else{ error_log('did not prepare'); }

$stmt->execute();
$res = $stmt->get_result();
error_log(mysqli_num_rows($res));
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
