<?php
session_start();
$_SESSION['admin']='gracesnehabrian';
$_SESSION['set']=100;

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM u_Designer WHERE DesignerID <101 ORDER BY DesignerID ASC")) {
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($myrow = $result->fetch_assoc()) {
	    			$designer[]=$myrow;

	    		}

	mysqli_stmt_close($stmt2);
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
</head>
<body>
  <form name='control-form' id='control-form' action='control_panel_script.php' method='post'>
    <table style="text-align:center; border:1px ">
      <tr>
      <th>DesignerID</th>
      <th>Name</th>
      <th>Email</th>
     
    
			<th>Password</th>
      <th>Education</th>
      <th>Experience</th>
      <th>Expertise</th>
      <th>WeightedSum</th>
       <th>Level</th>
      <th>Group</th>
      <th>Process</th> 
      
      <th>1stPay</th>  
       <th>Paypal</th>
      <th>Initial </th> 

      <th>uploadinitial </th> 
     
   	
      <th>Overall </th>
      <th>Aes </th>
      <th>Layout </th> 
     <th>SelectFeedback </th> 
      <th>SentEmail</th>    
			<th>Revised </th>
         <th>2ndPay</th> 
           
    
      </tr>
      <?php
        foreach($designer as  $value)
        {
          echo "<tr id='div-".$value['DesignerID']."'  >";
					// echo "<tr>";
          echo "<td>".$value['DesignerID']."</td>";
          echo "<td>".$value['name']."</td>";
          
          echo "<td>".$value['email']."</td>";
          echo "<td>".$value['password']."</td>";
          echo "<td>".$value['education']."</td>";
          echo "<td>".$value['experience']."</td>";
          echo "<td>".$value['expertise']."</td>";
          $weightedsun=0;
          switch($value['education'])
          {
            case 1:
            case 2:$weightedsun+=1;break;
            case 3:
            case 4:$weightedsun+=2;break;
            case 5:
            case 6:$weightedsun+=3;break;
          }
          switch($value['experience'])
          {
            case 1:
            case 2:$weightedsun+=1;break;
            case 3:$weightedsun+=2;break;
            case 4: 
            case 5:$weightedsun+=3;break;
          }
          switch($value['expertise'])
          {
            case 1:
            case 2:$weightedsun+=1;break;
            case 3:$weightedsun+=2;break;
            case 4: 
            case 5:$weightedsun+=3;break;
          }
          echo "<td>".$weightedsun."</td>";

          switch($weightedsun)
          {
            case 3:
            case 4: echo "<td>1</td>";break;
            case 5:
            case 6: echo "<td>2</td>";break;
            case 9:
            case 7:
            case 8: echo "<td>3</td>";break;
          }
          //Select Group 
          echo "<td><select name='g".$value['DesignerID']."'>";

                echo "<option disabled value='NULL'>Null</option>";
                echo "<option value ='control'"; if($value['group']=='control') echo "selected"; echo ">control</option>";
                echo "<option value ='self_explain'"; if($value['group']=='self_explain') echo "selected"; echo ">self_explain</option>";
                echo "<option value ='reflection'"; if($value['group']=='reflection') echo "selected"; echo ">reflection</option>";
                
               echo "<option value ='explain_reflect'"; if($value['group']=='explain_reflect') echo "selected"; echo ">explain_reflect</option>";
                
          echo "</select></td>";


           //Select Process 
          echo "<td><select name='p".$value['DesignerID']."'>";
          for ($i=0; $i < 7; $i++) {
            if(strval($i) == $value['process']){
              echo "<option selected value='".$i."'>".$i."</option>";
            }
            else{
              echo "<option value='".$i."'>".$i."</option>";
            }
          }
          echo "</select></td>";

         //Pay 1st
          echo "<td><select name='m".$value['DesignerID']."'>";
          echo "<option value ='0' "; if($value['1paid']==0){echo "selected";}   echo ">Not Paid</option>";               
          echo "<option value='1'"; if($value['1paid']==1){echo "selected";} echo ">Paid</option>";
          echo "</select></td>";
         

          echo "<td>".$value['paypal']."</td>";
          
         
         	//get original and revised Designs
					$did = $value['DesignerID'];
          echo "<td>".$value['DesignerID']."</td>";
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=? ORDER BY upload_date DESC LIMIT 1")) {
						$ver = 1;
						mysqli_stmt_bind_param($stmt2, "ii", $did, $ver);
						mysqli_stmt_execute($stmt2);
						$result = $stmt2->get_result();

						if(mysqli_num_rows($result) > 0){
							$design = $result->fetch_assoc();

							echo "<td><a target='_blank' href='../overall.php?mid=".$design['mid']."'>D".$design['DesignID']."</a></td>";
              echo "<td>".$design['upload_date']."</td>";
                //First Paypment
       
                unset($fk_overall);
                unset($fk_layout);
                unset($fk_aes);
                $overall_s=0;
                $aes_s=0;
                $layout_s=0;
                if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Feedback` WHERE `f_DesignID`=? ")) {
                    mysqli_stmt_bind_param($stmt2, "i", $design['DesignID']);
                    mysqli_stmt_execute($stmt2);
                    $result = $stmt2->get_result();
                    while ($myrow = $result->fetch_assoc()) {
                      
                      switch ($myrow['category']){
                        case "overall":
                          if($myrow['ok_to_use']==1)
                            $overall_s++;
                          $fk_overall[]=$myrow;break;
                        case "layout":
                         if($myrow['ok_to_use']==1)
                            $layout_s++;
                          $fk_layout[]=$myrow;break;
                        case "aes":
                         if($myrow['ok_to_use']==1)
                            $aes_s++;
                          $fk_aes[]=$myrow;break;
                        default:
                          $fk_overall[]=$myrow;break;
                      }                    
                    }  
                    $count_overall=count( $fk_overall);
                    $count_aes=count( $fk_aes);
                    $count_layout=count( $fk_layout);
                    echo "<td>".$count_overall."(".$overall_s.")</td>";
                    echo "<td>". $count_aes."(".$aes_s.")</td>";
                    echo "<td>".$count_layout."(".$layout_s.")</td>";
              }
            
           
            echo "<td><a href='set_feedback.php?design_id=".$design['DesignID']."&design_file=".$design['file']."' target='_blank'>SelectFK</a></td>";
       
             
            }					
            else
            {//No feedback yet
              echo "<td></td><td></td><td></td><td></td><td></td><td></td>";
            }
            // mysqli_stmt_close($stmt2);
          }
         
          echo "<td><a href='send_email198713.php?designer_id=".$value['DesignerID']."'>SentEmail</td>";
          echo "<td><a href='second_remind.php?designer_id=".$value['DesignerID']."'>Second Reminder</td>";
        
          /* //Sent backemail
          echo "<td><select name='n".$value['DesignerID']."'>";
          echo "<option value ='0' "; if($value['backemail']==0){echo "selected";}   echo ">Not Sent</option>";               
          echo "<option value='1'"; if($value['backemail']==1){echo "selected";} echo ">Sent</option>";
          echo "</select></td>";
*/

            echo "<td>"; 
            if ($value['backemail']>=1)
              echo "Sent ".$value['backemail'] ;
            echo "</td>";

          echo "<td>";
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=? ORDER BY upload_date DESC LIMIT 1")) {
						$ver = 2;
						mysqli_stmt_bind_param($stmt2, "ii", $did, $ver);
						mysqli_stmt_execute($stmt2);
						$result = $stmt2->get_result();
						if(mysqli_num_rows($result) > 0){
							$design = $result->fetch_assoc();
							echo "<a target='_blank' href='../design/".$design['file']."'>D_".$design['DesignID']."</a>";
						}
						mysqli_stmt_close($stmt2);
					}
      
          echo "</td>";

         
          //Second Paypment
          echo "<td><select name='s".$value['DesignerID']."'>";
          echo "<option value ='0' "; if($value['2paid']==0){echo "selected";}   echo ">Not Paid</option>";               
          echo "<option value='1'"; if($value['2paid']==1){echo "selected";} echo ">Paid</option>";
          echo "</select></td>";


          

					echo "</tr>";
        }
      ?>
    </table>
  </form>

	<button type='submit' class='btn-submit' id='submit-bn' onclick='submit()'>Submit</button>

<script>
 function submit(){
	 document.getElementById("control-form").submit();
 	// 	$("#control-form").submit();
 }

 //function rate() This is an alternative to save ratings
</script>

</body>
</html>
