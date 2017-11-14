<?php
session_start();
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

 if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `u_Designer` WHERE `process`>? AND `DesignerID`>? ")) {
          mysqli_stmt_bind_param($stmt2, "ii", $process, $range);
          $process = 5;
          $range=17;
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
 <title> Explain Reflect </title>

</head>
<body>
  <form name='control-form' id='control-form' action='control_panel_script.php' method='post'>
    <table style="text-align:center;" border='1'>
      <tr>
      <th>DesignerID</th>
      <th>Expertise</th>
      <th>Initial </th>
      <th>Feedback </th>  	
  		<th>Revised </th>   
      <th>Usefulness of Explanation</th>
      <th>Explain the use of Explanation</th> 
      <th>Usefulness of Reflection</th>
      <th>Explain the use of Reflection</th>  
           
      </tr>
      <?php
        foreach($explain_reflect as $value)
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
                //First Paypment       


              if ($stmt4 = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID`=? AND `ok_to_use`=? ORDER BY FeedbackID ASC")) {
                mysqli_stmt_bind_param($stmt4, "ii", $design_id, $ok_to_use);
                $design_id=$design['DesignID'];
                $ok_to_use=1;
                mysqli_stmt_execute($stmt4);
                $result = $stmt2->get_result();
                while ($myrow = $result->fetch_assoc()) {
                    $feedback[]=$myrow;
                }  
                 
                 foreach ($feedback as $tmp)
                  {
                     $feedbackNum += 1;
                     $content=htmlspecialchars($tmp['interpretation']);
                     $original=htmlspecialchars($tmp['edited_content']);
                     // $content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);

                      echo "<table><tr id='div-".$tmp['FeedbackID']."' >
                              <td><strong>#".$feedbackNum."</strong></td>
                      
                              <td style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".nl2br($content)."
                              <div style='margin-top:20px'><a data-toggle='collapse' href='#collapseExample".$feedbackNum."' aria-expanded='false' aria-controls='collapseExample".$feedbackNum."'>Read original feedback</a>


                              <div class='collapse' id='collapseExample".$feedbackNum."'>  
                                  <div class='card card-block'>
                                  ".nl2br($original)."
                                  </div>
                               </div>

                      </td> 
                    </tr></table";

                  }

            }		
          }			
            else
            {//No feedback yet
              echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            }
             mysqli_stmt_close($stmt2);
          }
     
          echo "<td>";
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=?")) {
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
            
            mysqli_stmt_bind_param($stmt3, "i", $did);
            $did= $value['DesignerID'];
          
            mysqli_stmt_execute($stmt3);
            $result2 = $stmt3->get_result();
            $survey_result = $result2->fetch_assoc();  
            echo "<td>".$survey_result['effort_1']."</td>";          
            echo "<td>".$survey_result['effort_2']."</td>";
            echo "<td>".$survey_result['confidence_1']."</td>";
            echo "<td>".$survey_result['confidence_2']."</td>";
            echo "<td>".$survey_result['design_time_1']."</td>";
            echo "<td>".$survey_result['design_time_2']."</td>";
            echo "<td>".$survey_result['explain_useful']."</td>";
            echo "<td>".$survey_result['explain_selfexplain']."</td>";
            echo "<td>".$survey_result['reflection_useful']."</td>";
            echo "<td>".$survey_result['explain_reflectionuse']."</td>";
              
          }
        


 
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
