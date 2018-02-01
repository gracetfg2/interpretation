<?php
session_start();
$feedback_id= $_POST['feedbackid'];
$action= $_POST['action'];
$provider=  $_POST['provider'];
$rating=  $_POST['rating'];


include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if($action=='update_rating')
{

if (!($stmt = mysqli_prepare($conn, "INSERT INTO ResponseRating (raterID, f_FeedbackID, rating) VALUES (?, ?, ?)

  ON DUPLICATE KEY UPDATE
  rating = ?"))) {
    echo "SendData Global prepare failed: (" . $conn->errno . ") " . $conn->error;
  }

$stmt->bind_param("siii", $raterID, $f_FeedbackID, $_rating, $_rating);
$stmt->execute();
mysqli_stmt_close($stmt);

}else{
  echo "something went wrong";
}


?>  