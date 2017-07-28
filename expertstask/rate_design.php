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

foreach($projects as $value)
{
			$project_id=$value['ProjectID'];

			//Get Designs 
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `f_ProjectID`=? ")) {
			      mysqli_stmt_bind_param($stmt2, "i", $project_id);
			      mysqli_stmt_execute($stmt2);
			      $result = $stmt2->get_result();
			      while ($myrow = $result->fetch_assoc()) {
			          $designs[]=$myrow;

			      }
			}
}

shuffle($designs);

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
		foreach($designs as $design)
		{
			$design_id=$design['DesignID'];		
			$project_id=$design['f_ProjectID'];	
			echo "<div id='p".$design_id."' class='pagecontent' style='display:none;'>";
			


			//Get Designs 
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Evaluate` WHERE `f_ProjectID`=? ")) {
			    
			    mysqli_stmt_bind_param($stmt2, "i", $project_id);
			    mysqli_stmt_execute($stmt2);
			    $result = $stmt2->get_result();
			    $record = $result->fetch_assoc();
 
				global $rate;

				switch($design['version']){

					case 1: $rate=$record['initial_rate1'];break;
					case 2: $rate=$record['revised_rate1'];break;
				  
				} 
			}

		    //Display
		   
		    echo "<div style='padding-top:50px'></div>";
		    echo "<div class='row'>
		    		       
		        <img width=450px style='border: 1px solid #A4A4A4;float:left;cursor: pointer;' src='../design/".$design['file']."' onclick=\"viewPic('".$design['mid']."')\";>
					<div class='col-md-6' >
					<div style='padding-left:20px'>
						<h4>  How would you rate the quality of the design based on the goals stated in the design brief? </h4>
					</div>
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
							<td class='radio-label' width='100px'><strong>Very Low</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate==1){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate==2){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate==3){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate==4){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate==5){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate==6){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='doc".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate==7){echo "checked ";} echo "onclick='rate(".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very High</strong></td>		
						</tr>
						</table>
				</div>

			</div>";

			echo "</div>";


						
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
		
		foreach($designs as $value)
		{
			$project_id=$value['f_ProjectID'];
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Evaluate` WHERE `f_ProjectID`=? ")) {
			    
			    mysqli_stmt_bind_param($stmt2, "i", $project_id);
			    mysqli_stmt_execute($stmt2);
			    $result = $stmt2->get_result();
			    $record = $result->fetch_assoc();
 
				global $rate;

				switch($value['version']){

					case 1: $rate=$record['initial_rate1'];break;
					case 2: $rate=$record['revised_rate1'];break;
				  
				} 
				
				$current_class='indicator';
				if($rate) $current_class='indicator finish';
		
	
				echo " <li class='".$current_class."' id='li".$value['DesignID']."' name='li".$value['DesignID']."'><a onclick='showUI(".$value['DesignID'].")';>".$index."</a></li>";
				$index++;
	
			}
			
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
	$('.pagecontent:first').show();
	$('li:first').addClass('active');

});

function viewPic(mid) {

window.open("../viewpic.php?image="+mid);

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
}

	function showUI(_id){
		$('#check-result').html();  

		$('.indicator').removeClass('active');
		
		$('#li'+_id).addClass('active');
		$('.pagecontent').hide();
		$('#p'+_id).show();			
    }





    function rate(_idx, project_id, version, _designer, number){

		$.ajax({
        	type: "POST",
            url:'save_quality_score.php',
            data: { projectid: project_id , designid:_idx, version: version, designer:_designer, selected: number },
            
            success: function (data) {
            	
            	$('#li'+_idx).removeClass('active');
   
            	$('#check-result').html('Rating saved!');  

            	if ($('input[name=doc'+_idx+']:checked').size() > 0 )
				{				
					$('#li'+_idx).addClass('finish');
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
