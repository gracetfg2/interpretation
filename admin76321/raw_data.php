<?php
session_start();
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

 if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `u_Designer` WHERE `process`>? ")) {
          mysqli_stmt_bind_param($stmt2, "i", $process);
          $process = 3;
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();

          while ($myrow = $result->fetch_assoc()) {
            $designer[]=$myrow;
            switch ($myrow['group']){
              case "self_explain":
                $self_explain[]=$myrow;break;
              case "control":
                $control[]=$myrow;break;
              case "explain_reflect":
                $explain_reflect[]=$myrow;break;
              case "reflection":
                $reflection[]=$myrow;break;
              default:
                $break;

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
 <title> Design </title>

</head>
<body>
  <form name='control-form' id='control-form' action='control_panel_script.php' method='post'>
    <table style="text-align:center;" border='1'>
      <tr>
      <th>DesignerID</th>
      <th>Expertise</th>
      <th>Initial </th>   	
  		<th>Revised </th>
      <th>Initial Effort</th>
      <th>Revised Effort</th> 
      <th>Initial Confidence</th> 
      <th>Revised Confidence</th>
      <th>Initial Design Time</th> 
      <th>Revised Design Time</th>  
           
      </tr>
      <?php
        foreach($control as $value)
        {
          echo "<tr id='div-".$value['DesignerID']."'  style='padding-top=10px'>";
					// echo "<tr>";
          echo "<td>".$value['DesignerID']."</td>";
          echo "<td>".$value['expertise']."</td>";
         
         	//get original and revised Designs
					$did = $value['DesignerID'];
          
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=?")) {
						$ver = 1;
						mysqli_stmt_bind_param($stmt2, "ii", $did, $ver);
						mysqli_stmt_execute($stmt2);
						$result = $stmt2->get_result();

						if(mysqli_num_rows($result) > 0){
							$design = $result->fetch_assoc();
							echo "<td><a href='../design/".$design['file']."' target='_blank'><img width= 200px src='../design/".$design['file']."'></img></a></td>";
              echo "<td>".$design['upload_date']."</td>";
                //First Paypment            
            }					
            else
            {//No feedback yet
              echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            }
             mysqli_stmt_close($stmt2);
          }
     
          echo "<td>";
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=? ORDER BY upload_date DESC LIMIT 1")) {
						$ver = 2;
						mysqli_stmt_bind_param($stmt2, "ii", $did, $ver);
						mysqli_stmt_execute($stmt2);
						$result = $stmt2->get_result();
						if(mysqli_num_rows($result) > 0){
							$design = $result->fetch_assoc();
							echo "<a href='../design/".$design['file']."' target='_blank'><img width= 200px src='../design/".$design['file']."'></img></a>";
						}
						mysqli_stmt_close($stmt2);
					}
      
          echo "</td>";

            if ($stmt3 = mysqli_prepare($conn, "SELECT * From monitorbehavior WHERE f_DesignerID = ?")) {
            
            mysqli_stmt_bind_param($stmt3, "i", $value['DesignerID']);
            mysqli_stmt_execute($stmt);
            $result2 = $stmt3->get_result();
            $survey_result = $result2->fetch_assoc();  
              
          }else {
        //No Designs found
          echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
          mysqli_stmt_close($stmt2);
          die();
        } 
          echo "<td>".$survey_result['effort_1']."</td>";          
          echo "<td>".$survey_result['effort_2']."</td>";
          echo "<td>".$survey_result['confidence_1']."</td>";
          echo "<td>".$survey_result['confidence_2']."</td>";
          echo "<td>".$survey_result['design_time_1']."</td>";
          echo "<td>".$survey_result['design_time_2']."</td>";




					echo "</tr>";
        }
      ?>
    </table>
  </form>

<script>
function view(mid) {
alert(mid);
window.open("../viewpic.php?image="+mid);

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
}

 //function rate() This is an alternative to save ratings
</script>

</body>
</html>
