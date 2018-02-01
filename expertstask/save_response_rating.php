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

  $sql="SELECT * FROM ResponseRating WHERE raterID =? AND f_FeedbackID=?";

  if($stmt=mysqli_prepare($conn,$sql))
  {
    mysqli_stmt_bind_param($stmt,"si",$provider, $feedback_id);
    mysqli_stmt_execute($stmt);
    $result = $stmt->get_result();
    while ($myrow = $result->fetch_assoc()) {
      $record[]=$myrow;
    }
    mysqli_stmt_close($stmt1);

    if(count($record) > 0){

        $sql="UPDATE ResponseRating SET rating= ? WHERE raterID =? AND f_FeedbackID=?";

        $stmt=$conn->prepare($sql); 
        $stmt->bind_param("isi",  $rating, $provider, $feedback_id);
        $stmt->execute();
        mysqli_stmt_close($stmt);


    }


  }else{
  echo "something went wrong 1";
  }



}

















?>  