<?php
session_start();
$design_id= $_GET['design_id'];

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
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

 if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Feedback` WHERE `f_DesignID`=? ")) {
                    mysqli_stmt_bind_param($stmt2, "i", $design_id);
                    mysqli_stmt_execute($stmt2);
                    $result = $stmt2->get_result();
             while ($myrow = $result->fetch_assoc()) {
                      
                      switch ($myrow['category']){
                        case "overall":
                          $fk_overall[]=$myrow;break;
                        case "layout":
                          $fk_layout[]=$myrow;break;
                        case "aes":
                          $fk_aes[]=$myrow;break;
                        default:
                          $fk_overall[]=$myrow;break;
                      }                    
                    }  
                    $count_overall=count( $fk_overall);
                    $count_aes=count( $fk_aes);
                    $count_layout=count( $fk_layout);
                   
              }
   ?>         

<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php include('../webpage-utility/ele_header.php');?>
     <script type="text/javascript" src="/reflection/js/behavior_for_reviewfeedback.js"></script>

</head>
<body>
<div class="main-section">

<div class="container" style="background-color:white; padding-top:20px;   border-radius: 15px; ">

<a href="<?php echo '../design/'.$design['file'];?>" target='_blank'>img</a>
<form name='control-form' id='control-form' action='set_feedback_script.php' method='post'>
<h3>Overall</h3>
<?php

echo "<table class='table table-hover table-nonfluid'>";
	 echo " <thead><td></td><td width='40%' align='left'></td><td width='40%' align='center'><strong>Used or Not</strong></td><td>Edited</td><td></td><td></td></thead>";
	  echo " <tbody>";   
	  	$count_feedback=1;
         foreach($fk_overall as  $value)
	     {
	     	echo "<tr id='div-".$value['FeedbackID']."' ";
			echo ">";

	     		$content=htmlspecialchars($value['content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   								 
				$edited=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $value['edited_content']);

   				$breaks = array("<br />");
				$edited = str_ireplace ($breaks, "\r\n", $edited);

   				$edited=htmlspecialchars($edited);
   				
   			
	     		echo "<td><strong>#".$value['FeedbackID']."</strong></td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".$content."</td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'><textarea cols=55 rows=10 name='a".$value['FeedbackID']."'>".$edited."</textarea></td><td>".$value['turkerID']."</td>";
	     		echo "";

	     		

	     		  echo "<td><select name='f".$value['FeedbackID']."'>";
		          echo "<option value ='1' "; if($value['ok_to_use']==1){echo "selected";}   echo ">Use</option>";               
		          echo "<option value='0'"; if($value['ok_to_use']==0){echo "selected";} echo ">Not Use</option>";
		          echo "</select></td>";

		          echo "<td><select name='o".$value['FeedbackID']."'>";
		          echo "<option value ='overall' "; if($value['category']=='overall'){echo "selected";}   echo ">Overall</option>";               
		          echo "<option value ='layout' "; if($value['category']=='layout'){echo "selected";}   echo ">Layout</option>"; 
		          echo "<option value ='aes' "; if($value['category']=='aes'){echo "selected";}   echo ">Aes</option>"; 
		          echo "</select></td>";



	     		$count_feedback++;	
		 }
echo " </tbody></table>";



echo "<h3>Layout</h3>";
echo "<table class='table table-hover table-nonfluid'>";
	 echo " <thead><td></td><td width='50%' align='left'></td><td width='25%' align='center'><strong>Used or Not</strong></td><td>Edited</td></thead>";
	  echo " <tbody>";   
	  	$count_feedback=1;
         foreach($fk_layout as  $value)
	     {
	     	echo "<tr id='div-".$value['FeedbackID']."' ";
			echo ">";

	     		$content=htmlspecialchars($value['content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   				
				$breaks = array("<br />"); 
				$edited = str_ireplace ($breaks, "\r\n", $value['edited_content']);

   				$edited=htmlspecialchars($edited);
   				
   				
	     		
	     	echo "<td><strong>#".$value['FeedbackID']."</strong></td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".$content."</td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'><textarea cols=55 rows=10 name='a".$value['FeedbackID']."'>".$edited."</textarea></td><td>".$value['turkerID']."</td>";
	     		echo "";

	     		

	     		  echo "<td><select name='f".$value['FeedbackID']."'>";
		          echo "<option value ='1' "; if($value['ok_to_use']==1){echo "selected";}   echo ">Use</option>";               
		          echo "<option value='0'"; if($value['ok_to_use']==0){echo "selected";} echo ">Not Use</option>";
		          echo "</select></td>";

		             echo "<td><select name='o".$value['FeedbackID']."'>";
		          echo "<option value ='overall' "; if($value['category']=='overall'){echo "selected";}   echo ">Overall</option>";               
		          echo "<option value ='layout' "; if($value['category']=='layout'){echo "selected";}   echo ">Layout</option>"; 
		          echo "<option value ='aes' "; if($value['category']=='aes'){echo "selected";}   echo ">Aes</option>"; 
		          echo "</select></td>";



	     		$count_feedback++;	
		 }
echo " </tbody></table>";



echo "<h3>Aesthetics</h3>";
echo "<table class='table table-hover table-nonfluid'>";
	 echo " <thead><td></td><td width='50%' align='left'></td><td width='25%' align='center'><strong>Used or Not</strong></td><td>Edited</td></thead>";
	  echo " <tbody>";   
	  	$count_feedback=1;
         foreach($fk_aes as  $value)
	     {
	     	echo "<tr id='div-".$value['FeedbackID']."' ";
			echo ">";

	     		$content=htmlspecialchars($value['content']);
				$content=preg_replace('#&lt;(/?(?:br /))&gt;#', '<\1>', $content);
   				
				$breaks = array("<br />"); 
				$edited = str_ireplace ($breaks, "\r\n", $value['edited_content']);

   				$edited=htmlspecialchars($edited);
   				
   				
	     	echo "<td><strong>#".$value['FeedbackID']."</strong></td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'>".$content."</td><td width='40%' style='text-align: justify; padding-bottom:10px; padding-right:25px;' class='table-text'><textarea cols=55 rows=10 name='a".$value['FeedbackID']."'>".$edited."</textarea></td><td>".$value['turkerID']."</td>";
	     		echo "";

	     		

	     		  echo "<td><select name='f".$value['FeedbackID']."'>";
		          echo "<option value ='1' "; if($value['ok_to_use']==1){echo "selected";}   echo ">Use</option>";               
		          echo "<option value='0'"; if($value['ok_to_use']==0){echo "selected";} echo ">Not Use</option>";
		          echo "</select></td>";

   echo "<td><select name='o".$value['FeedbackID']."'>";
		          echo "<option value ='overall' "; if($value['category']=='overall'){echo "selected";}   echo ">Overall</option>";               
		          echo "<option value ='layout' "; if($value['category']=='layout'){echo "selected";}   echo ">Layout</option>"; 
		          echo "<option value ='aes' "; if($value['category']=='aes'){echo "selected";}   echo ">Aes</option>"; 
		          echo "</select></td>";


	     		$count_feedback++;	
		 }
echo " </tbody></table>";



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