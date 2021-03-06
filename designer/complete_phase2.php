<?php 
	
	session_start();	
		//************* Check Login ****************// 
	$DESIGNER= $_SESSION['designer_id'];
	$EXPERIMENT=$_SESSION["experimentID"]=1;
	if(!$DESIGNER) { header("Location: ../index.php"); die(); }
	//************* End Check Login ****************// 

	$stage=2;
	//if(!$stage) { header("Location: ../index.php"); die(); }

	//Get Designer's Project
	include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/db_utility.php');
		include_once($_SERVER['DOCUMENT_ROOT'].'/reflection/general_information.php');
   	$conn = connect_to_db();
	
$confidence="";
$time="";
$effort="";
$design_quality="";

$degreeOfChange="";
$explain_revision="";
$feedback_useful="";
$reflection_useful="";
$explain_process="";
$explain_reflectionuse="";
$explain_feedbackuse="";


$control_useful="";

if ($stmt = mysqli_prepare($conn, "SELECT * From monitorbehavior WHERE f_DesignerID = ?")) {
  
	mysqli_stmt_bind_param($stmt, "i", $DESIGNER);
	mysqli_stmt_execute($stmt);
	$result = $stmt->get_result();
	$designer = $result->fetch_assoc();  
   	
   	$confidence=$designer['confidence_2']; 
	$time=$designer['design_time_2'];
	$effort=$designer['effort_2']; 
	$design_quality=$designer['quality_2'];

	$degreeOfChange=$designer['degreeOfChange']; 
	$feedback_useful=$designer['feedback_useful']; 
	$reflection_useful=$designer['reflection_useful'];

	$difference_rating=$designer['difference_rating'];

	$control_useful=$designer['control_useful'];  
	
	$breaks = array("<br />");  
	$explain_process = str_ireplace ($breaks, "\r\n", $designer['explain_process']);
	$explain_revision = str_ireplace ($breaks, "\r\n", $designer['explain_revision']);
	$explain_difference= str_ireplace ($breaks, "\r\n", $designer['explain_difference']);
		
	$explain_reflectionuse = str_ireplace ($breaks, "\r\n", $designer['explain_reflectionuse']);
	$explain_feedbackuse=str_ireplace ($breaks, "\r\n", $designer['explain_feedbackuse']);


	mysqli_stmt_close($stmt);

}
	
if ($stmt = mysqli_prepare($conn, "SELECT * From u_Designer WHERE DesignerID = ?")) {
  
	mysqli_stmt_bind_param($stmt, "i", $DESIGNER);
	mysqli_stmt_execute($stmt);
	$result = $stmt->get_result();
	$designer_info = $result->fetch_assoc();  
   	$group=$designer_info['group'];
   
}

if($designer_info['process']>5 ||$designer_info['process']<4)
	{ header("Location: ../index.php"); die(); }

		
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
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>

<div class="main-section">
	<div class="container " style="padding-top:30px">



		<form class="form-horizontal" name="complete_form" id="complete_form" method="post" action="complete_stage2_script.php" enctype="multipart/form-data">
		


		<div class="alert alert-success" style="width:80%;margin:0px auto;padding-right:70px;;padding-left:70px;">
		<h3>Awesome! This is the final step to complete the study </h3>
		<p style="font-size:16px">Please complete the following survey by <span style='color:red'><?php echo $designer_info['second_deadline'];?></span>, and then you are done with the study. If your design ranks in the top five, we will contact you. Your survey answers will NOT affect the compensation. </p>
		</div>
		
		<div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  Please fill out the empty answers.
		</div>
			
			
			<div class="sub_frame" id="div-time" name="div-time">
				<h4 class="nquestion_text"><strong> 1. How many minutes did you spend revising the flyer? </strong> </h4>			
			      <input type="text" class="form-control" name="time" id="time" placeholder="e.g. 50 minutes" maxlength="30" value='<?php print htmlspecialchars($time, ENT_QUOTES); ?>'> 
				
			</div>

			<div class="sub_frame" id="div-effort" name="div-effort">			
				<h4 class="nquestion_text"><strong> 2. How much effort did you invest revising the flyer? </strong> </h4>				
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
				<h4 class="nquestion_text"><strong> 3. How would you rate the quality of the revised flyer?</strong> </h4>				
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
				<h4 class="nquestion_text"><strong> 4. How confident are you that the revised flyer fully satisfied the design goals? </strong> </h4>				
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



			<div class="sub_frame" id="div-revision" name="div-revision">			
				<h4 class="nquestion_text"><strong> 5. Please rate the degree of revision between the initial and revised design. </strong> </h4>				
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
					<td class="radio-label" style="width: 60px" >Minor changes only</td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange1" value="1" <?php if ($degreeOfChange==1) echo 'checked'?> ></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange2" value="2"<?php if ($degreeOfChange==2) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange3" value="3" <?php if ($degreeOfChange==3) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange4" value="4" <?php if ($degreeOfChange==4) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange5" value="5" <?php if ($degreeOfChange==5) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange6" value="6" <?php if ($degreeOfChange==6) echo 'checked'?>></td>
					<td class="radio-cell"><input type="radio" class="radio-inline" name="degreeOfChange" id="degreeOfChange7" value="7" <?php if ($degreeOfChange==7) echo 'checked'?>></td>
					<td class="radio-label" style="width: 200px">Completely Different</td>		
					</tr>
					</table>
			</div>

			<div class="sub_frame" id="div-change" name="div-change"><h4 class="nquestion_text"><strong> 6. Please describe the main revisions you made to the initial design, and why. </strong> </h4>
				 <textarea id="mainChange" name="mainChange" rows="4" cols="52" style="width:100%;"><?php echo htmlspecialchars($explain_revision, ENT_QUOTES); ?></textarea>	
			</div>

			<?php

		
			if ($group=="reflection" || $group=="reflection-feedback")
				include('final_reflection_question7.php');
			else if($group=="feedback" || $group=="feedback-reflection")
				include('final_feedback_question7.php');
			
			if($group=="reflection-feedback")
				include('final_feedback_question8.php');

			if($group=="feedback-reflection")
				include('final_reflection_question8.php');

			if ($group=="control")
				include('control_question.php');

			?>

			

<input type="hidden" id="_group" name="_group" value='<?php echo $group;?>'>
<input type="hidden" name="_stage" id="_stage" value="<?php echo $stage;?>">
				
</form>
<div style="text-align:center;margin-top:20px;">
		<button type="submit" class="btn-submit" id="submit-bn" onclick="submit();">Submit</button> 
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


	$("#mainChange").bind("keydown", function(){
    	$('#div-change').removeClass("has-error");
}	);

	$("#ex_feedback").bind("keydown", function(){
    	$('#div-ex-feedback').removeClass("has-error");
}	);

	$("#ex_reflection").bind("keydown", function(){
    	$('#div-ex-reflection').removeClass("has-error");
}	);

	$('input[type=radio][name=degreeOfChange]').change(function(){
		   $("#div-revision").removeClass("has-error");
	})

	$('input[type=radio][name=feedback]').change(function(){
		   $("#div-feedback").removeClass("has-error");
	})

	$('input[type=radio][name=difference]').change(function(){
		   $("#div-difference").removeClass("has-error");
	})

	$('input[type=radio][name=reflection]').change(function(){
		   $("#div-reflection").removeClass("has-error");
	}) 
	 	
	
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


        if( $("input[name='feedback']").length )         // use this if you are using id to check
		{
		   if ($("input[name='feedback']:checked").size() == 0 ) {
          		isOkay = false;
           		$("#div-feedback").addClass("has-error");
			
       		 }
		}

		if($("input[name='reflection']").length){			
			if ($("input[name='reflection']:checked").size() == 0 ) {
          	isOkay = false;
          	$("#div-reflection").addClass("has-error");			
          }
		}

		if($("input[name='difference']").length){			
			if ($("input[name='difference']:checked").size() == 0 ) {
          		isOkay = false;
          		console.log(difference);
          		$("#div-difference").addClass("has-error");	
          	}
		}

		$('input#time').val($.trim($('input#time').val() )  );		
		if ($('input#time').val() == "") {
			  isOkay = false;
			  $("#div-time").addClass("has-error");
			
		}

		if ($("input[name='degreeOfChange']:checked").size() == 0 ) {
          isOkay = false;
           $("#div-revision").addClass("has-error");
			
        }

    $('#mainChange').val($.trim($('#mainChange').val() ) ); 
    if( $('#mainChange').val() == "" ){
       $('#mainChange').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;

    }

	if($("#ex_feedback").length){
				
	    $('#ex_feedback').val($.trim($('#ex_feedback').val() ) ); 
	    if( $('#ex_feedback').val() == "" ){
	       $('#ex_feedback').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	    }
	}

	if($("#ex_reflection").length){
				
	    $('#ex_reflection').val($.trim($('#ex_reflection').val() ) ); 
	    if( $('#ex_reflection').val() == "" ){
	       $('#ex_reflection').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	    }
	}

	if($("#ex_reflection").length){
	    $('#ex_reflection').val($.trim($('#ex_reflection').val() ) ); 
	    if( $('#ex_reflection').val() == "" ){
	       $('#ex_reflection').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	    }
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