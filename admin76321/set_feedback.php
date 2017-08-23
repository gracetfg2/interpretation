<?php
session_start();
$design_id= $_GET['design_id'];

include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();

	$sql="SELECT * FROM Design WHERE DesignID=?";
	if($stmt=mysqli_prepare($conn,$sql))
	{
		mysqli_stmt_bind_param($stmt,"i",$design_id);
		mysqli_stmt_execute($stmt);
		$result = $stmt->get_result();
		$design=$result->fetch_assoc() ;		 	
	    mysqli_stmt_close($stmt);	

	}

 			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `ExpertFeedback` WHERE `f_DesignID`=? ")) {
                    mysqli_stmt_bind_param($stmt2, "i", $design_id);
                    mysqli_stmt_execute($stmt2);
                    $result = $stmt2->get_result();
             		
             		while ($myrow = $result->fetch_assoc() ) {
     
                          $fk_overall[]=$myrow;
                     
                      }                    
                      
                    $count_overall=count( $fk_overall);
                   
              }
   ?>         

<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php include('../webpage-utility/ele_header.php');?>
     <script type="text/javascript" src="/interpretation/js/behavior_for_reviewfeedback.js"></script>

</head>
<body>
<div class="main-section">

<div class="container" style="background-color:white; padding-top:20px;   border-radius: 15px; ">

<a href="<?php echo '../design/'.$design['file'];?>" target='_blank'>img</a>

<form name='control-form' id='control-form' action='set_feedback_script.php' method='post'>
<h3>Overall</h3>
<?php

echo "<table class='table table-hover table-nonfluid'>";
	 echo " <tr>
	 			<th width='5%'></th>
	 			<th width='500px' align='left'>Content</th>
	 			<th width='10%' align='center'><strong>Used or Not</strong></th>
	 			<th width='40%'>Edited</th>
	 			<th width='15%'>Provider</th>
	 			<th></th>
	 		</tr>";
	 
	  	$count_feedback=1;
         foreach($fk_overall as  $value)
	     {
	     	echo "<tr id='div-".$value['FeedbackID']."'> ";
		

	     		$content=htmlspecialchars($value['content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   								 
				$edited=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $value['edited_content']);

   				$breaks = array("<br />");
				$edited = str_ireplace ($breaks, "\r\n", $edited);

   				$edited=htmlspecialchars($edited);
   				
   			
	     		echo "
	     		<td><strong>#".$value['FeedbackID']."</strong></td>
	     		<td style='text-align: justify; padding-bottom:10px; padding-right:25px;'>".$content."</td>";

		     	echo "<td><select name='f".$value['FeedbackID']."'>";
		        echo "<option value ='1' "; if($value['ok_to_use']==1){echo "selected";}   echo ">Use</option>";
		        echo "<option value='0'"; if($value['ok_to_use']==0){echo "selected";} echo ">Not Use</option>";
		        echo "</select></td>";
		        echo "<td style='text-align: justify; padding-bottom:10px; padding-right:25px;'>
		        	<textarea cols=55 rows=10 name='a".$value['FeedbackID']."'>".$edited."</textarea></td>

		        	<td>".$value['f_ProviderID']."</td>";

	     		$count_feedback++;	
	     		echo "</tr>";
		 }
echo " </table>";




?>

	<button type='submit' class='btn-submit' id='submit-bn' onclick='submit()'>Submit</button>


</form>

</div></div>
<script>
 function submit(){
	 document.getElementById("control-form").submit();
 	// 	$("#control-form").submit();
 }
</script>
</body>
</html>