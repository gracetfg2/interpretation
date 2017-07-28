<?php 
	
	session_start();	
	//check session
	$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"]=1;
	if(!$DESIGNER) { header("Location: ./index.php"); die(); }
		
	
	include_once('../webpage-utility/db_utility.php');
   	$conn = connect_to_db();
 ?>
 <html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	<?php include('../webpage-utility/ele_header.php');?>
    <title>Home </title>
    <!-- Custom styles for this template -->
 </head>
 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>
 <div class="main-section">
 <div class="container"><div class="alert alert-warning" role="alert">
 <span style="font-size:20px">This is the final step before claiming your reward&nbsp!
 <div> Please fill out the form with your subject code: <b><?php echo "S".$DESIGNER; ?></b> </div>
 </span>
 </div>
<iframe src="https://docs.google.com/forms/d/1DTUM_uCZ_YWhvHV4KRiW3il_5S1bETTjqzl-3ldIGiA/viewform?embedded=true" width="100%" height="100%" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
 	</div>
 </div>
 </body>



</html>