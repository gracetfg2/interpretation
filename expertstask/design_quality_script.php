<?php
session_start();
$project_id= $_POST['projectid'];
$designer_id= $_POST['designer'];
$version= $_POST['version'];
$selected= $_POST['selected'];
$current_rater=$_POST['provider'];
$aspect=$_POST['aspect'];

$field='';

switch($version){
  case 1: 
        $field='initial';
        break;
  case 2: 
        $field='revised';
        break;
} 

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
 
global $initial;
global $revised;
global $better_iteration;

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DesignQualityEvaluate` WHERE `f_ProjectID`=? AND `raterID` = ?")) {
          
          mysqli_stmt_bind_param($stmt2, "is", $project_id, $current_rater);
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          $record = $result->fetch_assoc();
  }

if(!$record){

   $sql2 = "INSERT INTO `DesignQualityEvaluate` (f_ProjectID,  f_DesignerID, raterID ,  ".$field."_".$aspect.") VALUES(?,?,?,?) ";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iisi",  $project_id, $designer_id, $current_rater, $selected);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Insert went wrong'.$sql2;}

}
else{
   $sql2 = "UPDATE `DesignQualityEvaluate` SET `".$field."_".$aspect."` =?  WHERE `f_ProjectID`=? AND `raterID` =?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iis",  $selected, $project_id,  $current_rater);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Update went wrong';}
}
echo "success";
   ?>  