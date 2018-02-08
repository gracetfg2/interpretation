<?php
session_start();
$project_id= $_POST['projectID'];
$designer_id= $_POST['designerID'];
$selected= $_POST['selected'];
$current_rater=$_POST['provider'];
$aspect=$_POST['aspect'];

$aspect_result=['better_version','doc_concept','doc_layout','doc_aes'];



include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();


if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DegreeOfChangeEvaluate` WHERE `f_ProjectID`=? AND `raterID` = ?")) {
          
          mysqli_stmt_bind_param($stmt2, "is", $project_id, $current_rater);
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          $record = $result->fetch_assoc();
  }

if(!$record){

   $sql2 = "INSERT INTO `DegreeOfChangeEvaluate` (f_ProjectID,  f_DesignerID, raterID ,  ".$aspect_result["{$aspect}"].") VALUES(?,?,?,?) ";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iisi",  $project_id, $designer_id, $current_rater, $selected);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Insert went wrong'.$sql2;}

}
else{
   $sql2 = "UPDATE `DegreeOfChangeEvaluate` SET `".$aspect_result["{$aspect}"]."` =?  WHERE `f_ProjectID`=? AND `raterID` =?";
    if($stmt2 = mysqli_prepare($conn,$sql2)){
      mysqli_stmt_bind_param($stmt2, "iis",  $selected, $project_id,  $current_rater);       
      mysqli_stmt_execute($stmt2);
    }
    else{ echo 'Update went wrong';}
}
echo  $sql2 ;
   ?>  