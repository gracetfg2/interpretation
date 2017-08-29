<?php
session_start();

include_once('webpage-utility/db_utility.php');
$conn = connect_to_db();

include('general_information.php');

$name = $email = $gender = $age = $expertise = $password = $target_file = $wherefrom=$ip=$proxy="";


//$target_dir = "consentforms/";
//$file_name = test_input(basename($_FILES["fileToUpload"]["name"]));
$uploadOk = 1;
//$FileType = pathinfo($file_name,PATHINFO_EXTENSION);

$isOkay = 1;

//Safe Backend
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
/*
//Check if file is okay
if ($_FILES['fileToUpload']['error'] != UPLOAD_ERR_OK) {
    $isOkay = 0;
    // $msg="Upload failed with error " . $_FILES['fileToUpload']['error'];
    $msg = "upload_form_error";
}
*/
 
//everything is okay, so                     
if($isOkay == 1){
    $stmt = $conn->prepare("INSERT INTO u_Designer(name, email, password ,expertise,gender,age, process,education,experience,paypal,wherefrom,ip,proxy) VALUES ( ?, ?, ?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->bind_param("sssissiiissss",  $name, $email, $password, $expertise,$gender,$age,$process,$education,$experience,$paypal,$wherefrom,$ip,$proxy);
    $process=1;
    $name = test_input($_POST["name"]);
    $email = test_input($_POST["email"]);
    $gender = test_input($_POST["gender"]);
    $age = test_input($_POST["age"]);
    $expertise = test_input($_POST["expertise"]);
    $password = generateRandomString();
    $education = test_input($_POST["education"]);
    $experience = test_input($_POST["experience"]);
    $paypal = test_input($_POST["paypal"]);
    $wherefrom = test_input($_POST["wherefrom"]);
    $ip = test_input($_POST["_source"]);
    $proxy = test_input($_POST["_proxy"]);
    $success = $stmt->execute();
    if(!$success){
        echo $stmt->error;
        echo "Oops. The platform encounters some errors. Please contact Grace Yen at ".$admin_email;
        $isOkay = 0;
        die();
    }

    //get ID
    $stmt = $conn->prepare("SELECT DesignerID FROM u_Designer WHERE email = ?");
    $stmt->bind_param("s",  $email);
    $email = test_input($_POST["email"]);
    $success = $stmt->execute();
    $res = $stmt->get_result();
    $did = $res->fetch_row()[0];
/*
    $target_file = $target_dir ."s".  $did ."_".$name ."." .$FileType;
    //Try to move the file
    if (!move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target_file)){       
        echo "Oops. The platform encounters an error (CODE: SIGNUP_MOVE_UPDATE_FILE). Please contact Grace Yen at yyen4@illinois.edu";
         echo $stmt->error;
        $isOkay = 0;
        die();
    }

    $stmt = $conn->prepare("UPDATE u_Designer SET consent_file = ? WHERE DesignerID = ?");
    $stmt->bind_param("si",  $target_file, $did);
    $target_file = $target_dir ."s".  $did ."_".$name ."." .$FileType;
  
    $success = $stmt->execute();
    //look for error 1062 for duplicate email error
    if(!$success){      
        echo "Oops. The platform encounters an error (CODE: SIGNUP_UPDATECONSENT). Please contact Grace Yen at yyen4@illinois.edu";
        $isOkay = 0;
        echo $stmt->error;
        die();
    }*/
}
else
{ 
    echo "Oops. The platform encounters an error (CODE: SIGNUP_ISOK). Please contact Grace Yen at ".$admin_email;
    die();
}

if($isOkay == 1){ //send message

    //Send password to new participant
    $to      = $email; // Send email to our user
    $subject = 'Registration confirmation for participant ID '.$did.'| Login Information'; // Give the email a subject 
    $message = '
    <html> 
    <body>
    <h2>
    Hi '.$name.',</h2>
<p style="font-size:14px">Thanks for your registration! To begin the study, please login to our design platform (http://review-my-design.org/'.$folder.'/index.php) using the following account. The platform will step you through the process. <br>

     <br>
    -------------------------------------------<br>
    <b>Username: </b>'.$email. '<br>
    <b>Password: </b>'.$password.'<br>
    --------------------------------------------<br>
    <br>
  
   The due date for the first phase of the study is '.$first_deadline.'. If you have any questions, please contact Grace Yen at '.$admin_email.'.
   When you contact us, please include <b>[ Participant '.$did.'] </b>in your email subject. <br>We look forward to your creative solutions! <br>
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


function generateRandomString($length = 7) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
//
mysqli_close($conn);

?>

<!DOCTYPE html>
<html>
<head> 
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo.png">
  <script src="js/jquery-1.11.3.min.js"></script>
 <!-- Bootstrap core CSS and js -->
     <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>

<!-- JQuery and Google font-->
    <link href='https://fonts.googleapis.com/css?family=Exo:100,400' rel='stylesheet' type='text/css'>

  <title> Sign Up for Online Design Study </title>


  <?php 
    include('webpage-utility/ele_header.php'); 
    ?>
  

</head>
<body>
    
<nav class="navbar navbar-fixed-top navbar-inverse" style="background:#002058">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" style="color:#E87722" href=".interpretation/index.php">CRAFT</a>
            </div>
         
        </div>
      
  </nav>

<div class="main-section">
    <div class="container">
        <div class="col-xs-12 col-sm-8 col-md-8 col-sm-offset-2 col-md-offset-2" style="padding-top: 50px">       
            <div class="alert alert-success" role="alert">
                <h2 style="padding-left: 15px;padding-right: 15px">Thanks for your registration. </h2>
                <div style="font-size:20px; color: #173B0B;padding-left: 15px;padding-right: 15px">
                   A confirmation email including the next steps for the competition has been sent to <b><?php echo test_input($_POST["email"]);?></b>. You may need to check the spam box if you do not receive it. <br>If you still have problem receiving the confirmtion email, please contact Grace Yen at <a href="mailto:<?php echo $admin_email;?>?Subject=No Confirmation Email Received" target="_top"><?php echo $admin_email;?></a>
                </div>
            </div>    
        </div>
    </div>
</div><!--end main-section-->


</body>
</html>


