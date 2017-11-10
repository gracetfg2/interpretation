<?php
session_start();
//echo "Close the reminder now";
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
include($_SERVER['DOCUMENT_ROOT'].'/reflection/general_information.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM u_Designer WHERE process<3 AND DesignerID>19 ORDER BY DesignerID ASC")) {
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($myrow = $result->fetch_assoc()) {
	    			$designer[]=$myrow;

	    		}

	mysqli_stmt_close($stmt2);
}
else {
//No Designers found
	echo "Our system has no designers yet";
	mysqli_stmt_close($stmt2);
	die();
}


foreach($designer as  $value)
{
	echo $value['DesignerID']." PROCESS=".$value['process'];
	echo "<br>";

    $to      = $value['email']; // Send email to our user
    $subject = '[Participant '.$value['DesignerID'].' ] Still interested in participating? '; // Give the email a subject 
    $message = '
    <html> 
    <body>
    <h3>
    Hi '.$value['name'].',</h3>
<p style="font-size:14px"> We are now accpeting more submissions. The deadline for completing the first phase of the study will be Since you haveIf you need more time, please let me know.
<br>  <br>  
To complete the first phase, please login to our design platform (http://review-my-design.org/reflection/index.php) using the following account. The platform will step you through the process. <br>

     <br>
    -------------------------------------------<br>
    <b>Username: </b>'.$value['email']. '<br>
    <b>Password: </b>'.$value['password'].'<br>
    --------------------------------------------<br>
    <br>
Look forward to your submission!
<br>
  
   
<br>
    Best Regards,<br>
    Yu-Chun (Grace) Yen<br>
    PhD Candidate<br>
    HCI Group | Department of Computer Science<br>
    University of Illinoise at Urbana-Champaign<br>
</body>
</html>

    '; // Our message 

$headers = "From: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "Reply-To: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subject, $message, $headers); // Send our email




$sql2 = "UPDATE `u_Designer` SET `remind_first` =? WHERE `DesignerID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "ii", $tmp, $designer_id);
      $tmp=1;
      $designer_id=$value['DesignerID'];
      mysqli_stmt_execute($stmt2);
    }



}


?>
