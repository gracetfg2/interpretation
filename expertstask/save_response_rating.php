<?php
session_start();
echo '$feedback_id'.$feedback_id.'$task'.$task.'$provider'.'$rating'.$rating;
$feedback_id= $_POST['feedbackid'];
$task= $_POST['action'];
$provider=  $_POST['provider'];
$rating=  $_POST['rating'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if($task=='update_rating')
{

if (!($stmt = mysqli_prepare($conn, "INSERT INTO ResponseRating (raterID, f_FeedbackID, rating) VALUES (?, ?, ?)

  ON DUPLICATE KEY UPDATE
  rating = VALUES(rating)"))) {
    echo "SendData Global prepare failed: (" . $conn->errno . ") " . $conn->error;
  }


$raterID = $provider;
$f_FeedbackID = $feedback_id;
$_rating = $rating;

$stmt->bind_param("sii", $raterID, $f_FeedbackID, $_rating);
$stmt->execute();
mysqli_stmt_close($stmt);

}else{
  echo "something went wrong";
}


   ?>  