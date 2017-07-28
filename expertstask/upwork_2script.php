<?php
session_start();
$project_id= $_POST['projectid'];
$task= $_POST['action'];

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();
 
global $initial;
global $revised;
global $better_iteration;

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `f_ProjectID`=? ")) {
          mysqli_stmt_bind_param($stmt2, "i", $project_id);
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          while ($myrow = $result->fetch_assoc()) {
            switch($myrow['version']){
              case 1: $initial=$myrow;
              case 2: $revised=$myrow;
            }

          }
}

if($task=='update_record')
{

  $sql2 = "UPDATE `Project` SET `better_rate2` =? ,`better_version_rate2`=? WHERE `ProjectID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iii", $better, $better_iteration, $project_id);      
      $better=$_POST['selected'];  
     
      switch($better)
      {
        case $initial['DesignID']: 
            $better_iteration=1;  
            break;
        case $revised['DesignID']: 
            $better_iteration=2;  
            break;
    
      }
 
      mysqli_stmt_execute($stmt2);

    }else{ echo 'something went wrong';}

 
}else if($task=='update_doc'){

  
    $sql2 = "UPDATE `Project` SET `degreeOfChange_rate2` =? WHERE `ProjectID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "ii", $better,$project_id);
      $better=$_POST['selected'];
      mysqli_stmt_execute($stmt2);
    }
}


   ?>  