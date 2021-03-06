<?php
session_start();		

$providerName = $_GET['ID'];
$seed = $_GET['seed'];

if(!$providerName){
     die("Ask for your ID before performing the task");
}
include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
$conn = connect_to_db();
include($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');



if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Project` WHERE `total_version`=2 AND `ok`=1 AND `f_DesignerId`>20 ORDER BY ProjectID ASC")) {
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


switch($seed){

	case '1qpwoei': //jason
		mt_srand('397');break;
	case '2qpwoei': //jennifer
		mt_srand('384');break;
	case '3qpwoei': 
		mt_srand('198');break;
	case '4qpwoei': //teresa, erin
		mt_srand('214');break;
		
}

$order = array_map(create_function('$val', 'return mt_rand();'), range(1, count($projects)));
array_multisort($order, $projects);


?>


<!DOCTYPE html>
<html>
<head>
	<script src="/interpretation/js/jquery-1.11.3.min.js"></script>
	<?php include('../webpage-utility/ele_header.php'); ?>
	<title> Review My Design </title>


	<link rel="stylesheet" type="text/css" href="/interpretation/dist/css/bootstrap.min.css">
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
.tablelabel{
	font-weight: bold;
	font-size:16px;
	color:#154360;
}

</style>
</head>

<body>

<div class="container">



  <?php 
		$initial_msg=0;
		foreach($projects as $value)
		{
			 $current_better='';
			 $current_aes='';
			 $current_concept='';
			 $current_layout='';

			$project_id=$value['ProjectID'];
			$designer_id=$value['f_DesignerID'];
			
		
			echo "<div id='p".$value['ProjectID']."' class='pagecontent' style='display:none;'>";
			
			//Get current rating
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DegreeOfChangeEvaluate` WHERE `f_ProjectID`=? AND `raterID`=?")) {
				mysqli_stmt_bind_param($stmt2, "is", $project_id, $providerName);
				mysqli_stmt_execute($stmt2);
				$result = $stmt2->get_result();
				while ($current_project = $result->fetch_assoc()) {
					
					$current_better= $current_project['better_version'];
					$current_aes= $current_project['doc_aes'];
					$current_concept= $current_project['doc_concept'];
					$current_layout= $current_project['doc_layout'];
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

		   	echo "<div style='padding-top:10px'></div>";
		   
		  
		     echo "
		     	<div class='well' width='80%'>
					<h4>Task instructions: </h4>
<span>For each design project, you need to answer four questions. The first question asks you to select which design better addresses the design brief. The remaining three questions ask you to rate the degree of change between the two iterations.<br><br>
1. You can navigate through all the design projects using the indicators on the bottom of the page. Or the interface will automatically direct you to the next project once you finish ratings for the current design. <br><br>
 
2. For each design project, you will be presented with both the initial and revised design. The order of the iteration presented is randomized. </span>
					<h4>Design Brief: </h4>
					<span>The flyers are for a charity concert featuring <a href='https://taylorswift.com/' target='_blank'>Taylor Swift</a>. The concert will take place on November 29th from 6:00 PM - 9:00 PM at <a href='https://krannertcenter.com/' target='_blank'>Krannert Center </a>at University of Illinois at Urbana-Champaign. Tickets are $40 per person, and food and drink will also be available for purchase. All proceeds will be used to support music programs at local elementary schools. Tickets can be purchased in the Illini Union Building in Room 208. The goal of the flyer is to encourage participation, be visually appealing, and convey the event details.
					</span><br><br>
					<h4>You can click the image to enlarge. </h4>
 				
				

					
				</div>
		     	 
		     	 <table>
		     	 <td><img class='left' width=300px height=480px  style='border: 1px solid #A4A4A4;float:left;cursor: pointer;' src='../design/".$left['file']."'  onclick=\"viewPic('".$left['mid']."')\";></td>		            	
			     <td width='40%'></td>       
				 <td><img class='right' width=300px height=480px  style='border: 1px solid #A4A4A4;float:left;cursor: pointer;' src='../design/".$right['file']."' onclick=\"viewPic('".$right['mid']."')\";></td>
				 
				 </table>
           

		     	<div style='margin-top:30px;'>
 				<h4>1. Please select which design you believe more effectively achieves the <a href='design_brief.php'>design goals</a>:</h4>
 				</div>

		     	<table style='text-align:center;'>
			        <tr>
			        <td width='5%'></td>
			            <td>
			            	<label class='radio-inline'>
		  	 			<input type='radio' name='better".$project_id."' value='".$left['version']."' onclick='rate(0,".$left['f_ProjectID'].",".$left['f_DesignerID'].",".$left['version'].")'"; 
				              if($current_better==$left['version']) 
				              {
				              	echo 'checked';
				              } 
				              echo "> The design on the left.
		        		</label>
			           
			            </td>
			            <td width=20%></td>
			            <td>
			            <label class='radio-inline'>
		      			<input type='radio' name='better".$project_id."' value='".$right['version']."' onclick='rate(0,".$right['f_ProjectID'].",".$right['f_DesignerID'].",".$right['version'].")'"; 
		              		if($current_better==$right['version']) {echo 'checked';}echo "> The design on the right.
		        		</label>
			            
			            </td>
			        </tr>		         
		        </table>	        

		  	 ";

 			echo " <hr>
 			<div style='margin-top:30px;'>
 				
 				<h4>2. Please rate the degree of change between the two designs in terms of the theme of the design :</h4>
 				
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
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."1'  value='1' "; if ($current_concept==1){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."2'  value='2' "; if ($current_concept==2){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."3'  value='3' "; if ($current_concept==3){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."4'  value='4' "; if ($current_concept==4){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."5'  value='5' "; if ($current_concept==5){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."6'  value='6' "; if ($current_concept==6){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$project_id."' id='".$project_id."7'  value='7' "; if ($current_concept==7){echo "checked ";} echo "onclick='rate(1, ".$project_id.",".$designer_id.",7);'></td>
							<td class='radio-label' width='200px'><strong>Significant difference</strong></td>		
						</tr>
					</table>
 				</div>
 			<hr>	
 			<div style='margin-top:30px;'>
 			
 				<h4>	3. Please rate the degree of change between the two designs in terms of the layout and composition of the elements in the design:</h4>
 			
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
							
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."1'  value='1' "; if ($current_layout==1){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",1);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."2'  value='2' "; if ($current_layout==2){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",2);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."3'  value='3' "; if ($current_layout==3){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",3);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."4'  value='4' "; if ($current_layout==4){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",4);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."5'  value='5' "; if ($current_layout==5){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",5);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."6'  value='6' "; if ($current_layout==6){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",6);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$project_id."' id='".$project_id."7'  value='7' "; if ($current_layout==7){echo "checked ";} echo "onclick='rate(2, ".$project_id.",".$designer_id.",7);'></td>
						<td class='radio-label' width='200px'><strong>Significant difference</strong></td>	
					 	</tr>
				</table>
				
			</div>
			<hr>
			<div style='margin-top:30px;'>
 			
 					<h4>4. Please rate the degree of change between the two designs in terms of the font, size, or color choices of surface-level elements in the design:</h4>
	
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
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."1'  value='1' "; if ($current_aes==1){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",1);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."2'  value='2' "; if ($current_aes==2){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",2);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."3'  value='3' "; if ($current_aes==3){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",3);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."4'  value='4' "; if ($current_aes==4){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",4);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."5'  value='5' "; if ($current_aes==5){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",5);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."6'  value='6' "; if ($current_aes==6){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",6);'></td>
						<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$project_id."' id='".$project_id."7'  value='7' "; if ($current_aes==7){echo "checked ";} echo "onclick='rate(3, ".$project_id.",".$designer_id.",7);'></td>
						<td class='radio-label' width='200px'><strong>Significant difference</strong></td>
						</tr>					
			</table>
			</div>



";


		   

			echo "</div>";

						
		}
		
		echo "</form>";

	?>


<div id='check-result' name='check-result'> </div>

<div style='padding-top:20px'></div>
<nav>
  <ul class="pagination">
  	

     <?php 
		$index=1;
		foreach($projects as $value)
		{
			//$current_class='indicator';

			 $current_better='';
			 $current_aes='';
			 $current_concept='';
			 $current_layout='';


			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DegreeOfChangeEvaluate` WHERE `f_ProjectID`=? AND `raterID`=?")) {
				mysqli_stmt_bind_param($stmt2, "is", $value['ProjectID'], $providerName);
				mysqli_stmt_execute($stmt2);
				$result = $stmt2->get_result();
				while ($current_project = $result->fetch_assoc()) {
					
					$current_better= $current_project['better_version'];
					$current_aes= $current_project['doc_aes'];
					$current_concept= $current_project['doc_concept'];
					$current_layout= $current_project['doc_layout'];
				}

   		 	}

			//Both not selected
			//if( !$value['better_rate'] && !$value['doc_aes'] && !$value['doc_concept']) $current_class='indicator';
			//Both selected
			$current_class='indicator';
			if( $current_better>0 && $current_aes>0 && $current_concept>0 && $current_layout>0)
			$current_class='indicator finish';
		 

			echo " <li class='".$current_class."' id='li".$value['ProjectID']."' name='li".$value['ProjectID']."'><a onclick='showUI(".$value['ProjectID'].")';>".$index."</a></li>";
			$index++;
		}
	?>

  </ul>
</nav>
<!--<a class="btn btn-warning" onclick="check()">Check Complete</a>-->

<input type='hidden' name='provider' id='provider' value='<?php  echo $providerName; ?>'>


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

	function showUI(_id){
		$('#check-result').html();  

		$('.indicator').removeClass('active');
		
		$('#li'+_id).addClass('active');
		$('.pagecontent').hide();
		$('#p'+_id).show();			
    }



function viewPic(mid) {

window.open("../viewpic.php?image="+mid);

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
}

    function rate(_aspect, _idx,_designerID, number){
	
    	$.ajax({
        	type: "POST",
            url:'degree_of_change2_script.php',
            data: { aspect:_aspect, projectID: _idx , designerID:_designerID,  selected: number, provider: $('#provider').val()},
            success: function (data) {

            	  // alert(data);
            	$('#check-result').html('Degree of differences is saved!');         
            	
            	//complete
            	if ( $('input[name=better'+_idx+']:checked').size() > 0 && $('input[name=aes'+_idx+']:checked').size() > 0 && $('input[name=concept'+_idx+']:checked').size() > 0 && $('input[name=layout'+_idx+']:checked').size() > 0 )
				{	
					$('#li'+_idx).removeClass('active');
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