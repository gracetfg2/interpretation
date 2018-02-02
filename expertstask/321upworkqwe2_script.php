<?php
session_start();
$project_id= $_POST['projectid'];
$designer_id= $_POST['designer'];
$version= $_POST['version'];
$selected= $_POST['selected'];
        
$current_rater='rate1';
$field='';  

switch($version){
  case 1: $field='initial_'.$current_rater;break;
  case 2: $field='revised_'.$current_rater;break;
} 

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
 
global $initial;
global $revised;
global $better_iteration;

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Evaluate` WHERE `f_ProjectID`=? ")) {
          mysqli_stmt_bind_param($stmt2, "i", $project_id);
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          $myrow = $result->fetch_assoc();
}

if(!$myrow){

   $sql2 = "INSERT INTO `Evaluate` (f_ProjectID,  f_DesignerID, ".$field.") VALUES(?,?,?) ";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iii",  $project_id, $designer_id, $selected);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Insert went wrong'.$sql2;}

}
else{
   $sql2 = "UPDATE `Evaluate` SET `".$field."` =?  WHERE `f_ProjectID`=?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "ii",  $selected, $project_id);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Update went wrong';}
}
echo "success";
   ?>  