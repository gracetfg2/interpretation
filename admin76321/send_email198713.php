<?php 

session_start();
$designer_id= $_GET['designer_id'];

include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');
include_once('../webpage-utility/db_utility.php');
$conn = connect_to_db();

$current_second_deadline='December 4th at 11:59 pm (Central Time)';

	$sql="SELECT * FROM u_Designer WHERE DesignerID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$designer_id);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$designer=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	

	}


   $to      = $designer['email']; // Send email to our user
    $subject = '[ Participant '.$designer['DesignerID'].'] Your Second Phase of the Study is Ready!'; // Give the email a subject 
    $message = '
    <html> 
    <body>
    <h3>
    Hi '.$designer['name'].',</h3>
<p style="font-size:14px"> In the second phase, you have to revise your initial design to better achieve the stated design goal. Please prepare your initial design in the tool and login to our design platform (http://review-my-design.org/interpretation/index.php). You should complete the second phase by '.$current_second_deadline.'. After completing this phase, we will check the submission and distribute the $30 through your Paypal address. Please block out 1.5 hour to finish the stage. More importantly, we hope you enjoy the study! <br>

     <br>
    -------------------------------------------<br>
    <b>Username: </b>'.$designer['email']. '<br>
    <b>Password: </b>'.$designer['password'].'<br>
    --------------------------------------------<br>
    <br>
  
  If you have any questions, please contact Grace Yen at '.$admin_email.'.
   When you contact us, please include <b>[ Participant '.$designer['DesignerID'].'] </b>in your email subject. Thank you!<br>
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



 $to2      = 'design4uiuc@gmail.com'; // Send email to our user
 $subject2 = 'back-up [ Participant '.$designer['DesignerID'].'] Your Second Phase of the Study is Ready!'; // Give the email a subject 

  mail($to2, $subject2, $message, $headers); // Send our email



$sql2 = "UPDATE `u_Designer` SET `backemail` =?,  `second_deadline`=? WHERE `DesignerID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "isi", $tmp, $current_second_deadline,$designer_id);
      $tmp=1;
      $designer_id=$designer['DesignerID'];
      mysqli_stmt_execute($stmt2);
    }





mysqli_close($conn);
switch($current_set)
{
  case 100:
    header('Location: control_panel_100.php');
    break;
  case 200:
    header('Location: control_panel_200.php');
    break;
  case 300:
    header('Location: control_panel_300.php');
    break;
  default:
      header('Location: control_panel.php');
    break;
}

?>