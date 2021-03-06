<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Project` WHERE `total_version`=2 AND `ok`=1 ORDER BY ProjectID ASC")) {
	    		mysqli_stmt_execute($stmt2);
	    		$result = $stmt2->get_result();
	    		while ($myrow = $result->fetch_assoc()) {
	    			$projects[]=$myrow;
	    			
	    		}  
	    		
	mysqli_stmt_close($stmt2);	
}
else {
//No Designs found
	echo "Our system encounter some problems, please contact our staff Grace at yyen4@illinois.edu with error code: SHOWFEEDBACK";
	mysqli_stmt_close($stmt2);
	die();
}




?>


<!DOCTYPE html>
<html>
<head>
	<script src="/reflection/js/jquery-1.11.3.min.js"></script>
	<?php include('../webpage-utility/ele_header.php'); ?>
	<title> Review My Design </title>


	<link rel="stylesheet" type="text/css" href="/reflection/dist/css/bootstrap.min.css">
<style>
.pagination  li{   
  	cursor: pointer;
}
.pagination .finish a{
    background-color: #ccffcc;
  
    color:#336600;
}

.pagination li.active a{
    background-color: rgb(51,122,183);

    color: white;
}



.pagination .incomplete a{
    background-color: #ffcccc;

     color:#993333;
}


</style>
</head>

<body>

<div class="container">



  <?php 
		$initial_msg=0;
		foreach($projects as $value)
		{
			$project_id=$value['ProjectID'];
			
		
			echo "<div id='p".$value['ProjectID']."' class='pagecontent' style='display:none;'>";
			
			//Get current rating
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Project` WHERE `ProjectID`=? ")) {
				mysqli_stmt_bind_param($stmt2, "i", $project_id);
				mysqli_stmt_execute($stmt2);
				$result = $stmt2->get_result();
				while ($current_project = $result->fetch_assoc()) {
					global $id;
					global $current_better;
					global $current_doc;
					$current_better= $current_project['better_rate2'];
					$current_doc= $current_project['degreeOfChange_rate2'];
					$id=$current_project['ProjectID'];
				}

   		 	}


			//Get Designs 
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `f_ProjectID`=? ")) {
			      mysqli_stmt_bind_param($stmt2, "i", $project_id);
			      mysqli_stmt_execute($stmt2);
			      $result = $stmt2->get_result();
			      while ($myrow = $result->fetch_assoc()) {
			        switch($myrow['version']){
			          case 1: $initial=$myrow;
			          case 2: $revised=$myrow;
			        }

			      }
			}

			//Randomize the design order
			$left=$initial;
			$right=$revised;
			$tmp = $right;
			$value=rand()% 2;

		    if ($value == 0) {
		        $right = $left;
		        $left = $tmp;
		    }
		    //Display
		   
		    echo "<div style='padding-top:50px'></div>";
		    echo "<table style='text-align:center;'>
		       

		          <tr>
		            <td><img class='left' width=400px height=600px style='border: 1px solid #A4A4A4;' src='../design/".$left['file']."'></td>
		            <td width=40%></td>
		            <td><img class='right' width=400px height=600px style='border: 1px solid #A4A4A4;' src='../design/".$right['file']."'></td>
		          </tr>
		         
		        </table>";

		 
		    echo "<form style='padding-top:50px'>";
		  
		    echo "<h4>1. Please select which design you believe more effectively achieves the design goals (the placement is randomized):</h4>
		  	 	<div class='form-group'>
				<label class='radio-inline'>
		  	 	&nbsp&nbsp&nbsp<input type='radio' name='project".$id."' value='".$left['DesignID']."' onclick='save(".$id.")'"; 
		              if($current_better==$left['DesignID']) {echo 'checked';} echo "> The design on the left.
		        </label>
		        <label class='radio-inline'>
		      	<input type='radio' name='project".$id."' value='".$right['DesignID']."' onclick='save(".$id.")'"; 
		              if($current_better==$right['DesignID']) {echo 'checked';}echo "> The design on the right.
		        </label>
		        </div>";


		    echo "<hr><div style='padding-top:20px'></div>";
		    echo "<h4>2. Please rate the degree of difference between the two designs:</h4>
		    <div class='sub_frame'> 
		    
		   <table>
 				<tr>
 				<td>
	 				<table style='width:600px;text-align:center;' border='0' cellpadding='5' cellspacing='0'>
						<tr aria-hidden='true'>
							<td  class='radio-label'></td>
							<td><label class='radio-cell'>1</label></td> 
							<td><label class='radio-cell'>2</label></td> 
							<td><label class='radio-cell'>3</label></td> 
							<td><label class='radio-cell'>4</label></td>
							<td><label class='radio-cell'>5</label></td> 
							<td><label class='radio-cell'>6</label></td>
							<td><label class='radio-cell'>7</label></td> 
							<td  class='radio-label' ></td>
						</tr>
				
						<tr>
							<td class='radio-label' width='150px'><strong>Minor difference</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."1'  value='1' "; if ($current_doc==1){echo "checked ";} echo "onclick='rate(".$id.",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."2'  value='2' "; if ($current_doc==2){echo "checked ";} echo "onclick='rate(".$id.",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."3'  value='3' "; if ($current_doc==3){echo "checked ";} echo "onclick='rate(".$id.",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."4'  value='4' "; if ($current_doc==4){echo "checked ";} echo "onclick='rate(".$id.",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."5'  value='5' "; if ($current_doc==5){echo "checked ";} echo "onclick='rate(".$id.",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."6'  value='6' "; if ($current_doc==6){echo "checked ";} echo "onclick='rate(".$id.",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$id."' id='".$id."7'  value='7' "; if ($current_doc==7){echo "checked ";} echo "onclick='rate(".$id.",7);'></td>
							<td class='radio-label' width='200px'><strong>Significant difference</strong></td>		
						</tr>

					</table>
				</td>
				</tr>
			</table>";

			echo "</div></div>";


						
		}
		
		echo "</form>";

	?>

	
<hr>

<div id='check-result' name='check-result'> </div>

<div style='padding-top:20px'></div>
<nav>
  <ul class="pagination">
  	

     <?php 
		$index=1;
		foreach($projects as $value)
		{
			$current_class='indicator incomplete';

			//Both not selected
			if( !$value['better_rate2'] && !$value['degreeOfChange_rate2']) $current_class='indicator';
			//Both selected
			if( $value['better_rate2'] && $value['degreeOfChange_rate2'])$current_class='indicator finish';

			echo " <li class='".$current_class."' id='li".$value['ProjectID']."' name='li".$value['ProjectID']."'><a onclick='showUI(".$value['ProjectID'].")';>".$index."</a></li>";
			$index++;
		}
	?>

  </ul>
</nav>
<!--<a class="btn btn-warning" onclick="check()">Check Complete</a>-->


</div>



</body>

<script type="text/javascript" src="jquery-1.3.2.js"></script>
	<script type="text/javascript">



$(document).ready(function() {
  // var task_params = document.getElementById("survey").href.substring(56).toString();
  // (new Image).src = 'http://128.174.241.28:8080/?' + task_params;
	showUI(3);
});


	function showUI(_id){
		$('#check-result').html();  

		$('.indicator').removeClass('active');
		
		$('#li'+_id).addClass('active');
		$('.pagecontent').hide();
		$('#p'+_id).show();			
    }


    function save(_idx){
    	$.ajax({
        	type: "POST",
            url:'upwork_2script.php',
            data: {projectid: _idx ,action:'update_record',  selected: $('input[name=project'+_idx+']:checked').val() },
            success: function (data) {

            	
            	$('#li'+_idx).removeClass('active');
            	$('#li'+_idx).removeClass('incomplete');
            	$('#check-result').html('Selection saved!');   
            	if ( $('input[name=doc'+_idx+']:checked').size() == 0 )
				{
					
					$('#li'+_idx).addClass('incomplete');
					$('#li'+_idx).addClass('active');
				}
				else
            	{
            		$('#li'+_idx).addClass('finish');
            		//$('#li'+_idx).addClass('active');
            		if(!$('#li'+_idx).is(':last-child'))
            		{
            			$('#li'+_idx).next().addClass('active');
	            		$('#check-result').html();  
						$('.pagecontent').hide();
						$('#p'+_idx).next().show();

            		}
            		else
            		{
            			$('#li'+_idx).addClass('active');
            			$('#check-result').html('Selection saved! This is the last project!');
            		}
            		
            	}
            	
            	     	
        	},
            error: function () {
            }
        });
    }



    function rate(_idx, number){
	
    	$.ajax({
        	type: "POST",
            url:'upwork_2script.php',
            data: {projectid: _idx ,action:'update_doc',  selected: number },
            success: function (data) {

            	$('#li'+_idx).removeClass('active');
            	$('#li'+_idx).removeClass('incomplete');    
            	$('#check-result').html('Degree of differences for the project is saved!');         
            	if ($('input[name=project'+_idx+']:checked').size() == 0 )
				{				
					$('#li'+_idx).addClass('incomplete');
					$('#li'+_idx).addClass('active');

				}
				else
            	{
            		$('#li'+_idx).addClass('finish');
            		//$('#li'+_idx).addClass('active');
            		if(!$('#li'+_idx).is(':last-child'))
            		{
            			$('#li'+_idx).next().addClass('active');
	            		$('#check-result').html();  
						$('.pagecontent').hide();
						$('#p'+_idx).next().show();

            		}
            		else
            		{
            			$('#li'+_idx).addClass('active');
            			$('#check-result').html('Selection saved! This is the last project!');
            		}
            		
            	}
            	      	
        	},
            error: function () {
            }

	
		});
	}


	</script>
</html>