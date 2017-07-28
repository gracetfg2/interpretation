<?php
session_start();
//echo "close to reminder 7/5";

$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
include($_SERVER['DOCUMENT_ROOT'].'/reflection/general_information.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM u_Designer WHERE process>3 AND process<6 AND second_deadline='July 7th at 5 pm (Central Time)' ORDER BY DesignerID ASC")) {
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


    $sql2 = "UPDATE `u_Designer` SET  `second_deadline`=? WHERE `DesignerID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "si",  $current_second_deadline,$designer_id);
      $current_second_deadline='July 15th at 5 pm (Central Time)';
      $designer_id=$value['DesignerID'];
      mysqli_stmt_execute($stmt2);
    }


/*
    $to      = $value['email']; // Send email to our user
    $subject = 'UIUC Design Study'; // Give the email a subject 
    $message = "
    <html> 
    <body>
    <span style='color:#003366'>
    <p>
    Hi ".$value['name'].",
    </p>

    <p> Hope you're well. We notice that you haven't finished the second phase of the study. If you are still interested in participating, we can extend the deadline to 5pm July 15th (Friday) Central Time.
</p>
<p>
To complete the the study, please log in to http://review-my-design.org/reflection/index.php using your account:</span>
    -------------------------------------------<br>
    <b>Username: </b>".$value['email']. "<br>
    <b>Password: </b>".$value['password']."<br>
    --------------------------------------------<br>

</p>

 <p><span style='color:#003366'>Look forward to your submission!</span></p>

  
<p>
    Best,<br>
    Grace Yen<br>
   <span style='color:#73808c'> PhD Candidate<br>
    HCI Group | Department of Computer Science<br>
    University of Illinoise at Urbana-Champaign<br></span>
</p>
</body>
</html>

    "; // Our message 

$headers = "From: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "Reply-To: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subject, $message, $headers); // Send our email



 $to2      = 'design4uiuc@gmail.com'; // Send email to our user
 $subject2 = 'back-up [ Participant '.$designer['DesignerID'].'] Reminder for pass second deadline'; // Give the email a subject 

  mail($to2, $subject2, $message, $headers); // Send our email

*/


}


?>
