<?php
session_start();
$project_id= $_POST['projectid'];
$task= $_POST['action'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();


if($task=='update_record')
{
  echo $_POST['selected'];

  $sql2 = "UPDATE `Project` SET `better_rate1` =? WHERE `ProjectID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "ii", $better,$project_id);
      $better=$_POST['selected'];
      mysqli_stmt_execute($stmt2);
    }

 
}else if($task=='update_doc'){

    $type= $_POST['type'];

    switch($type)
    {
      case 1: $type='doc_aes_1';
      case 2: $type='doc_concept_1';
    }  
    $sql2 = "UPDATE `Project` SET `".$type."` =? WHERE `ProjectID`=?";
   
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "ii", $better,$project_id);
      $better=$_POST['selected'];
      mysqli_stmt_execute($stmt2);
    }
}


   ?>  