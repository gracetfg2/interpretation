<?php
session_start();
$_SESSION['admin']='gracesnehabrian';
include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

 if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `u_Designer` WHERE `group`=? ")) {
          mysqli_stmt_bind_param($stmt2, "s", $groupname);
          $groupname='feedback-reflection';
          mysqli_stmt_execute($stmt2);
          $result = $stmt2->get_result();
          while ($myrow = $result->fetch_assoc()) {
            $designer[]=$myrow;
           
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
 <title> Fee--re </title>

</head>
<body>
  <form name='control-form' id='control-form' action='control_panel_script.php' method='post'>
    <table style="text-align:center;" border='1'>
      <tr>
      <th>DesignerID</th>
      <th>Name</th>
     
      <th>Education</th>
      <th>Experience</th>
      <th>Expertise</th>
   
      <th>Process</th> 
    <th>Initial </th> 

      <th>uploadinitial </th> 
     
   	
  		<th>Revised </th>
           
    
      </tr>
      <?php
        foreach($designer as  $value)
        {
          echo "<tr id='div-".$value['DesignerID']."'  style='padding-top=10px'>";
					// echo "<tr>";
          echo "<td>".$value['DesignerID']."</td>";
          echo "<td>".$value['name']."</td>";
          
          echo "<td>".$value['education']."</td>";
          echo "<td>".$value['experience']."</td>";
          echo "<td>".$value['expertise']."</td>";



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

          
         
         	//get original and revised Designs
					$did = $value['DesignerID'];
          
					if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM Design WHERE f_DesignerID=? AND version=? ORDER BY upload_date DESC LIMIT 1")) {
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

         
      

					echo "</tr>";
        }
      ?>
    </table>
  </form>

	<button type='submit' class='btn-submit' id='submit-bn' onclick='submit()'>Submit</button>

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
