<?php 
session_start();

 $mid=$_GET['image'];
 $dfolder="design/";
 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
 $conn = connect_to_db();
 	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

 //Get Design
 if ($stmt = mysqli_prepare($conn, "SELECT file From Design WHERE mid = ?")) {
     /* bind parameters for markers */
     mysqli_stmt_bind_param($stmt, "s", $mid);
     /* execute query */
     mysqli_stmt_execute($stmt);
     /* bind result variables */
     $stmt->store_result();

 	if($stmt->num_rows > 0) {
 	    mysqli_stmt_bind_result($stmt,$file);
 	    /* fetch value */
 	    mysqli_stmt_fetch($stmt);
 	    /* close statement */
 	    mysqli_stmt_close($stmt);
 	} else {
 	    //No Designs found
 	    header('Location: feedback_error.php');
 	}
  
 }
?>

<html>
	<body style="background:#E6E6E6;">
		<img width="700px" src="<?php echo $dfolder.$file?>" >
	</body>
</html>