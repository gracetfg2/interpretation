<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
$conn = connect_to_db();

if ($stmt2 = mysqli_prepare($conn, "SELECT * FROM `Design` WHERE `version`=2 ORDER BY f_DesignerID ASC")) {
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
<script src="jquery.twbsPagination.js"></script>
<script src="jquery.twbsPagination.js"></script>

   <link rel="stylesheet" type="text/css" href="/reflection/dist/css/bootstrap.min.css">
	
</head>

<body>
	 <?php 
		
		
	?>
 <div id="myCarousel" class="carousel" data-ride="carousel">
 

  <!-- Wrapper for slides -->
	<div class="carousel-inner" role="listbox">
    
  	 <?php 
		$first=0;
		foreach($projects as $value)
		{
			
			echo "<div class='item "; if($first==0) {echo "active"; $first=1;} echo "'   >
        			<img src='/reflection/design/".$value['file']."' height=770>
					<input type='text' >
      				</div>";
        
			
		}
	?>

  </div>

  <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>


     <!-- Indicators -->
   <ol class="carousel-indicators">

 <?php 
		$index=0;
		$first=0;
		foreach($projects as $value)
		{
			if($first==0)
			{
				echo "<li data-target='#myCarousel' data-slide-to='".$index."' class='active'></li>";
				$first=1;
			}
			else
			{
				echo "<li data-target='#myCarousel' data-slide-to='".$index."'></li>";
		
			}
			$index++;
		}
?>

  </ol>
  </div>
</div>



<script>
    $('#pagination-demo').twbsPagination({
        totalPages: 35,
        visiblePages: 7,
        onPageClick: function (event, page) {
            $('#page-content').text('Page ' + page);
        }
    });
</script>





</body>
</html>