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

			if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `DesignQualityEvaluate` WHERE `f_ProjectID`=? AND `raterID` = ?")) {
			    
			    mysqli_stmt_bind_param($stmt2, "is", $project_id, $providerName);
			    mysqli_stmt_execute($stmt2);
			    $result = $stmt2->get_result();
			    $record = $result->fetch_assoc();
 
				global $rate;

				switch($value['version']){

					case 1: 
							$rate_concept=$record['initial_concept'];
							$rate_layout=$record['initial_layout'];
							$rate_aes=$record['initial_aes'];
							break;
					case 2: $rate_concept=$record['revised_concept'];
							$rate_layout=$record['revised_layout'];
							$rate_aes=$record['revised_aes'];
							break;
				  
				} 
				
				$current_class='indicator';
				if( $rate_concept && $rate_layout && $rate_aes) $current_class='indicator finish';
		
	
				echo " <li class='".$current_class."' id='li".$value['DesignID']."' name='li".$value['DesignID']."'><a onclick='showUI(".$value['DesignID'].")';>".$index."</a></li>";
				$index++;
	
			}
			
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
