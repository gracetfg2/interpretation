<?php
include('general_information.php');

$email='gracetfg2@gmail.com';

    //Send password to new participant
    $to      = $email; // Send email to our user
    $subject = 'Registration confirmation for participant ID 1| Login Information'; // Give the email a subject 
    $message = '
    <html> 
    <body>
    <h2>
    Hi haha,</h2>
<p style="font-size:14px">Thanks for your registration! To begin the study, please login to our design platform () using the following account. The platform will step you through the process. <br>

     <br>
    -------------------------------------------<br>
    <b>Username: </b>'.$email. '<br>
    <b>Password: </b>haha<br>
    --------------------------------------------<br>
    <br>
  
   The due date for the first phase of the study is '.$first_deadline.'. If you have any questions, please contact Grace Yen at '.$admin_email.'.
   When you contact us, please include <b>[ Participant 2] </b>in your email subject. <br>We look forward to your creative solutions! <br>
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

}
?>