<?php
session_start();
echo "close to reminder 7/6";
/*
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
include($_SERVER['DOCUMENT_ROOT'].'/reflection/general_information.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM u_Designer WHERE process>3 AND process<6 AND second_deadline='July 6th at 5 pm (Central Time)' ORDER BY DesignerID ASC")) {
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
    $subject = '[Participant '.$value['DesignerID'].' ] Reminder: Please complete the second phase of the study by today.'; // Give the email a subject 
    $message = "
    <html> 
    <body>
    <h3>
    Hi ".$value['name'].",</h3>
<p style='font-size:14px'> Don't forget to complete the second phase of the study by 5pm today! Please login to the platform and complete the activities that were designed to help you revise the initial design. We have received many creative solutions, and are looking forward to seeing yours! If you need more time, please contact us and let us know. 

<br>
<br>
Thanks!
<br>
  
   
<br>
    Best Regards,<br>
    Grace (Yu-Chun) Yen<br>
    PhD Candidate<br>
    HCI Group | Department of Computer Science<br>
    University of Illinoise at Urbana-Champaign<br>
</body>
</html>

    "; // Our message 

$headers = "From: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "Reply-To: UIUC Design Competition <".$admin_email.">\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

mail($to, $subject, $message, $headers); // Send our email


}
*/

?>
