<?php
session_start();
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

 if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `u_Designer` WHERE process=6 ")) {
          mysqli_stmt_bind_param($stmt2, "s", $groupname);
          
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          while ($myrow = $result->fetch_assoc()) {
            
            switch($myrow['group'])
            {
              case 'reflection':
                $reflection[]=$myrow;break;
              case 'feedback':
                $feedback[]=$myrow;break;
              case 'reflection-feedback':
                $rf[]=$myrow;break;
              case 'feedback-reflection':
                $rf[]=$myrow;break;
            }
           
          }  
}
else {
//No Designers found
	echo "Our system has no designers yet";
	mysqli_stmt_close($stmt2);
	die();
}



?>

<!DOCTYPE html>
<html>
<head>
 <title> Reflection </title>
 <tr>
      <th></th>
      <th>Group</th>
      <th>Count</th>
  </tr>
  <?php 


    $groups=array("Reflection","Feedback","Reflection-feedback","Feedback-Reflection");
    foreach ($groups as $value)
    {
        echo "<tr >";
        echo "<td>".$value."</td>";
        echo "<td>". printcount($value)."</td>";
       
    
        echo "</tr>";

    }



function printcount(group_value){

  switch(group_value)
  {
      case 'Reflection': return count($reflection);break; 
      case 'Feedback': return count($feedback);break; 
      case 'Reflection-Feedback': return count($rf);break; 
      case 'Feedback-Reflection': return count($reflection);break; 
  }
}
?>

</head>
<body>
  <table style="text-align:center;" border='1'>
  </table>   
   
        

</body>
</html>
