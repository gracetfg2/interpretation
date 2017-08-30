<?php 
	
	session_start();	
		//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************// 

	$stage=1;
	//if(!$stage) { header("Location: ../index.php"); die(); }

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
   	$conn = connect_to_db();
	
$confidence="";
$time="";
$effort="";
$design_quality="";


	$sql10="SELECT * FROM u_Designer WHERE DesignerID=?";
		if($stmt6=mysqli_prepare($conn,$sql10))
		{
			mysqli_stmt_bind_param($stmt6,"i",$DESIGNER);
			mysqli_stmt_execute($stmt6);
			$result = $stmt6->get_result();
			$designer_info=$result->fetch_assoc() ;		 	
		 
		}

	if($designer_info['process']>2)
	{
		 header("Location: homepage.php"); die(); 
	}	


if ($stmt = mysqli_prepare($conn, "SELECT * From monitorbehavior WHERE f_DesignerID = ?")) {
  
	mysqli_stmt_bind_param($stmt, "i", $DESIGNER);
	mysqli_stmt_execute($stmt);
	$result = $stmt->get_result();
	$designer = $result->fetch_assoc();  
   	
   	$confidence=$designer['confidence_1']; 
	$time=$designer['design_time_1'];
	$effort=$designer['effort_1']; 
	$design_quality=$designer['quality_1'];
	mysqli_stmt_close($stmt);

}
	
	
 ?>
<html lang="en">
<head>
    
 	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
 	<?php include('../webpage-utility/ele_header.php');?>
    <title>Home </title>
    <!-- Custom styles for this template -->
     <link rel="stylesheet" type="text/css" href="/interpretation/css/feedback_form_tmp.css">
<style>
.nquestion_text{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
}
.sub_frame{
	background-color: #FAFAFA;
	padding-right: 30px;
    padding-left: 30px;
	padding-top: 10px;
    padding-bottom: 20px;
    margin-top: 20px;
    border-radius: 20px;

}
.has-error
{
	background-color:#f2dede;
}
</style>
 </head>

 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/ele_nav.php');?>

<div class="main-section">
	<div class="container " style="padding-top:20px;">



		<form class="form-horizontal" name="complete_form" id="complete_form" method="post" action="complete_stage1_script.php" enctype="multipart/form-data">

		<div class="alert alert-success" style="width:90%;margin:0px auto;padding-right:70px;;padding-left:70px;">
		<div style="text-align:center"><h3>Awesome! We have received your design. </h3></div>
		<p style="font-size:16px"> As the last step of this phase, we would like to know a little more about your design process. Please answer the following questions to complete the first phase of the study.</p>
		<p style="font-size:16px;color:#848484;">Note: Your answers will NOT affect the compensation. </p>		
		</div>


		<h3> </h3>
		<div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  Please fill out the empty answers.
		</div>
			

			<div class="sub_frame" id="div-time" name="div-time">
				<h4 class="nquestion_text"><strong> 1. How many minutes did you spend designing the flyer? </strong> </h4>			
			      <input type="text" class="form-control" name="time" id="time" placeholder="e.g. 50 minutes" maxlength="30" value='<?php print htmlspecialchars($time, ENT_QUOTES); ?>'> 
				
			</div>

			<div class="sub_frame" id="div-effort" name="div-effort">			
				<h4 class="nquestion_text"><strong> 2. How much effort did you invest designing the flyer? </strong> </h4>				
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
						<td class="radio-label" style="width: 60px" >Low Effort</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort1" value="1" <?php if ($effort==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort2" value="2"<?php if ($effort==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort3" value="3" <?php if ($effort==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort4" value="4" <?php if ($effort==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort5" value="5" <?php if ($effort==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort6" value="6" <?php if ($effort==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="effort" id="effort7" value="7" <?php if ($effort==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 140px">High Effort</td>		
					</tr>
					</table>
			</div>

			<div class="sub_frame" id="div-quality">			
				<h4 class="nquestion_text"><strong> 3. How would you rate the quality of the flyer?</strong> </h4>				
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
						<td class="radio-label" style="width: 60px" >Low Quality</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality1" value="1" <?php if ($design_quality==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality2" value="2"<?php if ($design_quality==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality3" value="3" <?php if ($design_quality==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality4" value="4" <?php if ($design_quality==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality5" value="5" <?php if ($design_quality==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality6" value="6" <?php if ($design_quality==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="design_quality" id="design_quality7" value="7" <?php if ($design_quality==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 140px">High Quality</td>		
					</tr>
					</table>
			</div>

			<div class="sub_frame" id="div-confidence">			
				<h4 class="nquestion_text"><strong> 4. How confident are you that the flyer satisfied all of the design goals? </strong> </h4>				
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
						<td class="radio-label" style="width: 60px" >Low Confidence</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence1" value="1" <?php if ($confidence==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence2" value="2"<?php if ($confidence==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence3" value="3" <?php if ($confidence==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence4" value="4" <?php if ($confidence==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence5" value="5" <?php if ($confidence==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence6" value="6" <?php if ($confidence==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="confidence" id="confidence7" value="7" <?php if ($confidence==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 140px">High Confidence</td>		
					</tr>

					</table>
			</div>

			

			




<input type="hidden" name="_stage" id="_stage" value="<?php echo $stage;?>">
				
</form>
<div style="text-align:center;margin-top:20px;">
		<button type="submit" class="btn-submit" id="submit-bn" onclick="submit();"><?php if ($stage==1) echo "Submit";else echo "Complete Second Stage ";?></button> 
</div>



	</div>
	
</div>


<script>
	 	
	$('input[type=radio][name=effort]').change(function(){
		   $("#div-effort").removeClass("has-error");
	})
	$('input[type=radio][name=design_quality]').change(function(){
		   $("#div-quality").removeClass("has-error");
	})
	$('input[type=radio][name=confidence]').change(function(){
	   $("#div-confidence").removeClass("has-error");
	})
	$("#time").bind("keydown", function(){
    	$('#div-time').removeClass("has-error");
}	);



	 	
	
function submit() {
		
		var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		var isOkay = true;

	    if ($("input[name='confidence']:checked").size() == 0 ) {
          isOkay = false;
           $("#div-confidence").addClass("has-error");
			  

        }
        if ($("input[name='effort']:checked").size() == 0 ) {
          isOkay = false;
           $("#div-effort").addClass("has-error");
			
        }
        if ($("input[name='design_quality']:checked").size() == 0 ) {
          isOkay = false;
           $("#div-quality").addClass("has-error");
			
        }
		$('input#time').val($.trim($('input#time').val() )  );		
		if ($('input#time').val() == "") {
			  isOkay = false;
			  $("#div-time").addClass("has-error");
			
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