<?php
session_start();		

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
mt_srand('214');
$order = array_map(create_function('$val', 'return mt_rand();'), range(1, count($designs)));
array_multisort($order, $designs);
//shuffle($designs);

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


</style>
</head>

<body>

<div class="container">

  <?php 
		$initial_msg=0;
		$distance[];
		foreach($designs as $design)
		{
			$design_id=$design['DesignID'];		
			$project_id=$design['f_ProjectID'];	

			echo "<div id='p".$design_id."' class='pagecontent' style='display:none;'>";
			

			//Get Designs 
			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DesignQualityEvaluate` WHERE `f_ProjectID`=? ")) {
			    
			    global $rate_concept_t;
				global $rate_layout_t;
				global $rate_aes_t;

				global $rate_concept_e;
				global $rate_layout_e;
				global $rate_aes_e;

				global $concept_distance;
				global $layout_distance;
				global $aes_distance;

			    mysqli_stmt_bind_param($stmt2, "i", $project_id);
			    mysqli_stmt_execute($stmt2);
			  	$result = $stmt2->get_result();

			    while ($myrow = $result->fetch_assoc()) 
			    {
			      	 switch($myrow['raterID']){
			      	 	case 'erinupwork': 
			          		$erin=$myrow;
			          		break;
			          	case 'teresaqpal': 
			          		$teresa=$myrow;
			          		break;
			  			}

			     }//end while
 
							

				switch($design['version']){

					case 1: 
							$concept_distance=abs($erin['initial_concept']-$teresa['initial_concept']); 
							$layout_distance=abs($erin['initial_layout']-$teresa['initial_layout']); 
							$aes_distance=abs($erin['initial_aes']-$teresa['initial_aes']); 
							$rate_concept_t=$teresa['initial_concept'];
							$rate_layout_t=$teresa['initial_layout'];
							$rate_aes_t=$teresa['initial_aes'];
							$rate_layout_e=$erin['initial_layout'];
							$rate_aes_e=$erin['initial_aes'];
							break;
					case 2: $concept_distance=abs($erin['revised_concept']-$teresa['revised_concept']); 
							$layout_distance=abs($erin['revised_layout']-$teresa['revised_layout']); 
							$aes_distance=abs($erin['revised_aes']-$teresa['revised_aes']); 
							$rate_concept_t=$teresa['revised_concept']; 
							$rate_layout_t=$teresa['revised_layout']; 
							$rate_aes_t=$teresa['revised_aes']; 
							$rate_concept_e=$erin['revised_concept'];
							$rate_layout_e=$erin['revised_layout'];
							$rate_aes_e=$erin['revised_aes'];
							break;			  
				} //end switch design version
			$object = new stdClass();
			$object->concept_distance = $concept_distance;
			$object->layout_distance = $layout_distance;
			$object->aes_distance = $aes_distance;
			$distance[] = $object;
			//array_push( $distance, [ $concept_distance, $layout_distance, $aes_distance ]);
		    //Display
		   
		    echo "<div style='padding-top:50px'></div>";
		    echo "<div class='row'>
		    		       
		        <img width=450px style='border: 1px solid #A4A4A4;float:left;cursor: pointer;' src='../design/".$design['file']."' onclick=\"viewPic('".$design['mid']."')\";>

				<div class='col-md-6' >
					<div style='padding-left:10px'>
					 1. Please rate how well the <b><span style='color:#003399'>overall direction/concept</span> </b> of the design addresses the design brief. 
					</div>
					<table style='width:500px;text-align:center;' border='0' cellpadding='5' cellspacing='0'>
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
							<td class='radio-label' width='100px'><strong>Rater 1: Very Bad</strong> </td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_t==1){echo "checked ";} echo "onclick='rate( 1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_t==2){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_t==3){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_t==4){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_t==5){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_t==6){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept1".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_t==7){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very Good</strong></td>		
						</tr>
						<tr>Erin</tr>
						<tr>
							<td class='radio-label' width='100px'><strong>Rater 2: Very Bad</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_e==1){echo "checked ";} echo "onclick='rate( 1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_e==2){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_e==3){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_e==4){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_e==5){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_e==6){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='concept".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_e==7){echo "checked ";} echo "onclick='rate(1,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very Good</strong></td>		
						</tr>
						</table>


<hr>
					<div style='margin-top:30px; padding-left:10px'>
					2. Please rate the quality of the design in terms of the <b><span style='color:#003399'>layout and composition</span> </b>of the elements in the design. 
					</div>
					<table style='width:500px;text-align:center;' border='0' cellpadding='5' cellspacing='0'>
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
							<td class='radio-label' width='100px'><strong>Rater 1: Very Low</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_t==1){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_t==2){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_t==3){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_t==4){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_t==5){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_t==6){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout1".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_t==7){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very High</strong></td>		
						</tr>

						<tr>
							<td class='radio-label' width='100px'><strong>Rater 2: Very Low</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_e==1){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_e==2){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_e==3){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_e==4){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_e==5){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_e==6){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='layout".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_e==7){echo "checked ";} echo "onclick='rate(2,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very High</strong></td>		
						</tr>
						</table>
<hr>

				<div style='margin-top:20px; padding-left:10px'>
					3. Please rate the quality of the design in terms of the font type, size, and color choices <b><span style='color:#003399'>(aesthetics)</span></b> of surface-level elements in the design. 
					</div>
					<table style='width:500px;text-align:center;' border='0' cellpadding='5' cellspacing='0'>
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
							<td class='radio-label' width='100px'><strong>Rater 1: Very Low</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_t==1){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_t==2){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_t==3){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_t==4){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_t==5){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_t==6){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_t==7){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very High</strong></td>		
						</tr>

						<tr>
							<td class='radio-label' width='100px'><strong>Rater 2: Very Low</strong></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."1'  value='1' "; if ($rate_concept_e==1){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",1);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."2'  value='2' "; if ($rate_concept_e==2){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",2);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."3'  value='3' "; if ($rate_concept_e==3){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",3);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."4'  value='4' "; if ($rate_concept_e==4){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",4);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."5'  value='5' "; if ($rate_concept_e==5){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",5);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."6'  value='6' "; if ($rate_concept_e==6){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",6);'></td>
							<td class='radio-cell'><input type='radio' class='radio-inline' name='aes".$design['DesignID']."' id='".$design['DesignID']."7'  value='7' "; if ($rate_concept_e==7){echo "checked ";} echo "onclick='rate(3,".$design['DesignID'].",".$design['f_ProjectID'].",".$design['version'].",".$design['f_DesignerID'].",7);'></td>
							<td class='radio-label' width='100px'><strong>Very High</strong></td>		
						</tr>
						</table>


				</div>

			</div>";

			echo "</div>";
						
		}// End if getting records for this design
	}//end looping all designs
		
		echo "</form>";

	?>

	
<hr>

<div id='check-result' name='check-result'> </div>

<div style='padding-top:20px'></div>
<nav>
  <ul class="pagination">
  	

     <?php 
		$index=1;
		
		foreach($distances as $value)
		{
			$project_id=$value['f_ProjectID'];
			$current_class='indicator';

			if (($value[0]+$value[1]+$value[2])>3) 	
				$current_class='incomplete';
			
			//if( $rate_concept && $rate_layout && $rate_aes) $current_class='indicator finish';
		
	
				echo " <li class='".$current_class."' id='li".$value['DesignID']."' name='li".$value['DesignID']."'><a onclick='showUI(".$value['DesignID'].")';>".$index."</a></li>";
				$index++;
	
			// End getting design quality evaluate results
			
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





	</script>
</html>
