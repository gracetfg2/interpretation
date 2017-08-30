<?php

session_start();

if(!$_GET['mid'] ){header('Location: ../feedback_error.php');}
$mid =$_GET['mid'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($stmt = mysqli_prepare($conn, "SELECT DesignID, mturk_code From Design WHERE mid = ?")) {
    /* bind parameters for markers*/ 
    mysqli_stmt_bind_param($stmt, "s", $mid);
    /* execute query */
    mysqli_stmt_execute($stmt);
    /* bind result variables*/ 
    mysqli_stmt_bind_result($stmt, $design_id, $mturk_code);
    /* fetch value */
    mysqli_stmt_fetch($stmt);
    /* close statement */
    mysqli_stmt_close($stmt);
}




$stmt = $conn->prepare("INSERT INTO ExpertFeedback (f_designID, f_providerID, content, design_quality) VALUES ( ?,?,?,?)");
    
    $stmt->bind_param("issi", $design_id, $_turkerID, $fbktext,  $design_quality);  
    
    $_turkerID=$_POST['_turkerID']; 
    $fbktext=nl2br($_POST['_fbk-text']);
    $design_quality=$_POST['_quality'];
 

    $success = $stmt->execute();
    if(!$success){
        $isOkay=false;
        echo "Error: " .$stmt->error; die();
    }
mysqli_close($conn);

echo "The verification code is <strong>".$mturk_code."</strong>. <br>Please keep the codes of all the designs you reviewed";

?>

