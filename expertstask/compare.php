<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Project` WHERE `total_version`=2 ORDER BY f_DesignerID ASC")) {
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
.finsihed{
	color:blue;
}
</style>
</head>

<body>

<div class="container" style="text-align:center">


  <?php 
		$initial_msg=0;
		foreach($projects as $value)
		{
			if($initial_msg==0)
			{
				echo "<h1 id='message'>Please select the project id</h1>";
				$initial_msg=1;
			}

			echo "<div id='p".$value['ProjectID']."' class='pagecontent' style='display:none;text-align:center'></div>";


						
		}
	?>


<nav>
  <ul class="pagination">
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>

     <?php 
		$index=1;
		foreach($projects as $value)
		{
			echo " <li class='indicator' id='li".$value['ProjectID']."' name='li".$value['ProjectID']."'><a onclick='showUI(".$value['ProjectID'].")';>".$index."</a></li>";
			$index++;
		}
	?>

    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
</nav>





</div>



</body>

<script type="text/javascript" src="jquery-1.3.2.js"></script>
	<script type="text/javascript">

	function showUI(_id){
			$('.pagecontent').hide();
			$('.indicator').removeClass('active');
			$('#li'+_id).addClass('active');
			$.ajax({
        	type: "POST",
            url:'get_project.php',
            data: {projectid: _id ,action:'get_data'},
            success: function (data) {
            	
            	$('#p'+_id).html(data);
            	$('#p'+_id).show();
        	},
            error: function () {
            }
        });
    }

    function save(_idx){
    	$.ajax({
        	type: "POST",
            url:'get_project.php',
            data: {projectid: _idx ,action:'update_record',  selected: $('input[name=project'+_idx+']:checked').val() },
            success: function (data) {
            	$('#li'+_idx).addClass('disabled');
            	
        	},
            error: function () {
            }
        });
    }



	</script>
</html>