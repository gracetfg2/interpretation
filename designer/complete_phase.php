<?php 
	
	session_start();	
		//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"]=1;
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************// 

	$stage=$_GET['stage'];
	if(!$stage) { header("Location: ../index.php"); die(); }

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	
$confidence="";
$time="";


if ($stmt = mysqli_prepare($conn, "SELECT confidence_".$stage." , design_time_".$stage." From monitorbehavior WHERE f_DesignerID = ?")) {
  
    mysqli_stmt_bind_param($stmt, "i", $DESIGNER);
    mysqli_stmt_execute($stmt);
    $stmt->store_result();
	if($stmt->num_rows > 0) {
	    mysqli_stmt_bind_result($stmt, $confidence, $time);
	    mysqli_stmt_fetch($stmt);
	    mysqli_stmt_close($stmt);
	}
	 else {
	    //No Record Yet
	
	}
}
	
	
 ?>
<html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	<?php include('../webpage-utility/ele_header.php');?>
    <title>Home </title>
    <!-- Custom styles for this template -->
     <link rel="stylesheet" type="text/css" href="/reflection/css/feedback_form_tmp.css">
<style>
.nquestion_text{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:16px;
}
</style>
 </head>

 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>

<div class="main-section">
	<div class="container " style="padding-top:20px;">



		<form class="form-horizontal" name="complete_form" id="complete_form" method="post" action="complete_stage_script.php" enctype="multipart/form-data">
		<h3>Please answer the following questions to complete this phase. </h3>
		<div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  Please fill out the empty answers.
		</div>
			
			<div class="sub_frame" style="background-color:#E6E6E6">
				<h4 class="nquestion_text-text"><strong> <?php if($stage==1) echo "Approximately, how much time did I spend on the flyer? (in minutes)"; else if ($stage==2) echo "How much time did I spend on revising the design?";?> </strong> </h4>			
			      <input type="text" class="form-control" name="time" id="time" placeholder="e.g. 50 minutes" maxlength="30" value='<?php print htmlspecialchars($time, ENT_QUOTES); ?>'> 
				
			</div>

			<div class="sub_frame" style="background-color:#E6E6E6">			
				<h4 class="nquestion_text-text"><strong> I am confident that the current flyer will encourage participation, is visually appealing, and convey the event detail. </strong> </h4>				
				<table border="0" cellpadding="5" cellspacing="0" id="entry_1519429516">
					<tr aria-hidden="true">
						<td  class="radio-label" style="width: 140px"></td>
						<td><label class="radio-cell">1</label></td> 
						<td><label class="radio-cell">2</label></td> 
						<td><label class="radio-cell">3</label></td> 
						<td><label class="radio-cell">4</label></td>
						<td><label class="radio-cell">5</label></td> 
						<td><label class="radio-cell">6</label></td>
						<td><label class="radio-cell">7</label></td>  
						<td  class="radio-label" style="width: 140px"></td>
					</tr>
					
					<tr>
						<td class="radio-label" style="width: 60px" >Strongly Disagree</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence1" value="1" <?php if ($confidence==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence2" value="2"<?php if ($confidence==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence3" value="3" <?php if ($confidence==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence4" value="4" <?php if ($confidence==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence5" value="5" <?php if ($confidence==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence6" value="6" <?php if ($confidence==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence7" value="7" <?php if ($confidence==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 140px">Strongly Agree</td>		
					</tr>
					</table>
					</div>




<input type="hidden" name="_stage" id="_stage" value="<?php echo $stage;?>">
				
</form>
<div style="text-align:center;margin-top:20px;">
		<button type="submit" class="btn-submit" id="submit-bn" onclick="submit();"><?php if ($stage==1) echo "Complete First Stage ";else echo "Complete Second Stage ";?></button> 
</div>



	</div>
	
</div>


<script>
	 	
	
function submit() {
		
		var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		var isOkay = true;

	    if ($("input[name='confidence']:checked").size() == 0 ) {
          isOkay = false;
        }
		$('input#time').val($.trim($('input#time').val() )  );		
		if ($('input#time').val() == "") {
			  isOkay = false;
		}

		if(isOkay==true){
			$("#complete_form").submit();
			
		}
		else
		{
			 $("#error_alert").show();
		}


}

</script>


 	
 </body>



</html>