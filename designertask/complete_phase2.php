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
	include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
		include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/general_information.php');
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


$explain_useful="";
$explain_selfexplain="";

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

	$control_useful=$designer['control_useful'];  

	$explain_useful=$designer['explain_useful'];  

	
	$breaks = array("<br />");  
	$explain_process = str_ireplace ($breaks, "\r\n", $designer['explain_process']);
		
	$explain_reflectionuse = str_ireplace ($breaks, "\r\n", $designer['explain_reflectionuse']);
	$explain_feedbackuse=str_ireplace ($breaks, "\r\n", $designer['explain_feedbackuse']);

	$explain_difficult=str_ireplace ($breaks, "\r\n", $designer['explain_difficult']);


	$explain_selfexplain = str_ireplace ($breaks, "\r\n", $designer['explain_selfexplain']);
	//$explain_feedbackuse=str_ireplace ($breaks, "\r\n", $designer['explain_feedbackuse']);

	$difference_rating=$designer['difference_rating']; 

	$explain_difference=$designer['explain_difference']; 



	$explain_revision = $designer['explain_revision'];
	//$changelist[]= var_dump(json_decode($explain_revision));

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
     <link rel="stylesheet" type="text/css" href="/interpretation/css/feedback_form_tmp.css">
       <link rel="stylesheet" type="text/css" href="/interpretation/css/to_do.css">
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
	<div class="container" style="padding-top:30px">



		<form class="form-horizontal" name="complete_form" id="complete_form" method="post" action="complete_stage2_script.php" enctype="multipart/form-data">
		
		<div class="alert alert-success" style="width:90%;margin:0px auto; padding-right:70px;;padding-left:70px;">
		<h3>Awesome! This is the final step to complete the study </h3>
		<p style="font-size:16px">Please complete the following survey by <span style='color:red'><?php echo $designer_info['second_deadline'];?></span>, and then you are done with the study. If your design ranks in the top ten, we will contact you and give you the additional reward. Your survey answers will NOT affect the compensation. </p>
		</div>
		
		<div class="alert alert-danger" role="alert" id="error_alert" style="display:none;">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  Please fill out the empty answers.
		</div>
		<div style='height: 20px'></div>
		<div class="alert alert-warning" role="alert" style="width:90%;margin:0px auto;padding-right:70px;">
		<h4><strong>Part I : </strong> Questions about your final design and the change between the initial and the revised design.</h4>
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



<div class="sub_frame" id="div-change" name="div-change">
	<h4 class="nquestion_text"><strong> 6 Please list the main revisions between the initial and the revised design. You can click the 'Add' button to add more items.</strong> </h4>
	<div id="myDIV" class="header">
  		
  		<input type="text" id="myInput" style="border: 1px solid #AEB6BF "  placeholder="e.g. 1. I changed the background color from yellow to pink because....">
  		<button type="button" class="btn" onclick="newElement()">Add</button>
</div>


<ul id="myUL" style='margin-top: 10px'>
<?php 
	echo $explain_revision;
?>
</ul>

</div>


		<div class="alert alert-warning" role="alert" style="width:90%;margin:0px auto;padding-right:70px;">
		<h4><strong>Part II : </strong> Questions about the activities you experienced in the design process.</h4>
		</div>	

			<?php

		

			if($group=="self_explain" || $group=="explain_reflect")
				include('final_explain_question7.php');			
		
			if($group=="reflection")
				include('final_reflection_question7.php');

			if($group=="explain_reflect")
				include('final_reflection_question8.php');

			if ($group=="control")
				include('final_feedback_question7.php');

			?>

	
<div class="sub_frame" id="div-difficult" name="div-difficult"><h4 class="nquestion_text"><strong> (Optional) Is there any issues that you felt uncertain or not sure how to fix it? Please describe the situation, if any.  </strong> </h4>
 <textarea id="explain_difficult" name="explain_difficult" rows="4" cols="52" style="width:100%;"><?php echo htmlspecialchars($explain_difficult, ENT_QUOTES); ?></textarea>	
</div>		

<input type="hidden" id="_group" name="_group" value='<?php echo $group;?>'>
<input type="hidden" name="_stage" id="_stage" value="<?php echo $stage;?>">
<input type="hidden" name="change_list" id="change_list" value="">				
</form>
<div style="text-align:center;margin-top:20px;">
		<button type="submit" class="btn-submit" id="submit-bn" onclick="submit();">Submit</button> 
</div>



	</div>
	
</div>


<script>

var changes = [];	 	

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
	});


	$("#ex_feedback").bind("keydown", function(){
    	$('#div-ex-feedback').removeClass("has-error");
	});

	$("#ex_reflection").bind("keydown", function(){
    	$('#div-ex-reflection').removeClass("has-error");
	});

	$("#ex_difference").bind("keydown", function(){
    	$('#div-ex-difference').removeClass("has-error");
	});

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


            console.log("1");
           $("#div-confidence").addClass("has-error");
        }

        if ($("input[name='effort']:checked").size() == 0 ) {
          isOkay = false;
           console.log("2");
           $("#div-effort").addClass("has-error");			
        }
        if ($("input[name='design_quality']:checked").size() == 0 ) {
          isOkay = false;
           console.log("3");
           $("#div-quality").addClass("has-error");
			
        }


        if( $("input[name='feedback']").length )         // use this if you are using id to check
		{
		   if ($("input[name='feedback']:checked").size() == 0 ) {
          		isOkay = false;
          		 console.log("4");
           		$("#div-feedback").addClass("has-error");
			
       		 }


		}


		if($("input[name='reflection']").length){
			
			if ($("input[name='reflection']:checked").size() == 0 ) {
          	isOkay = false;
          	 console.log("5");
          	$("#div-reflection").addClass("has-error");
			
          }
		}

		if($("input[name='difference']").length){
			
			if ($("input[name='difference']:checked").size() == 0 ) {
          	isOkay = false;
          	 console.log("5");
          	$("#div-difference").addClass("has-error");
			
          }
		}

		if($("input[name='explain']").length){
			
			if ($("input[name='explain']:checked").size() == 0 ) {
          	isOkay = false;
          	 console.log("6");
          	$("#div-explain").addClass("has-error");
			
          }
		}

		$('input#time').val($.trim($('input#time').val() )  );		
		if ($('input#time').val() == "") {
			  isOkay = false;
			   console.log("7");
			  $("#div-time").addClass("has-error");
			
		}

		if ($("input[name='degreeOfChange']:checked").size() == 0 ) {
          isOkay = false;
           console.log("8");
           $("#div-revision").addClass("has-error");
			
        }

  /*  $('#mainChange').val($.trim($('#mainChange').val() ) ); 
    if( $('#mainChange').val() == "" ){
       $('#mainChange').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;
         console.log("9");
 		alert('mainChange');
    }*/

    if(document.getElementById("myUL").children.length==0 || !$("#myUL").children().is(':visible')) {

    	$('#myDIV').parents('.sub_frame:first').addClass("has-error");
        isOkay = false;
		alert('Please list at least one change you made to the design.');
    }

	if($("#ex_feedback").length) {
				
	    $('#ex_feedback').val($.trim($('#ex_feedback').val() ) ); 
	    if( $('#ex_feedback').val() == "" ){
	       $('#ex_feedback').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	         console.log("10");
	           alert('ex_feedback');
	    }
	}

	if($("#ex_explain").length){
				
	    $('#ex_explain').val($.trim($('#ex_explain').val() ) ); 
	    if( $('#ex_explain').val() == "" ){
	       $('#ex_explain').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
 console.log("11");
	         alert('ex_explain');
	    }
	}

	if($("#ex_reflection").length){
	    $('#ex_reflection').val($.trim($('#ex_reflection').val() ) ); 
	    if( $('#ex_reflection').val() == "" ){
	       $('#ex_reflection').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	         console.log("12");
	        alert('ex_reflection');
	    }
	}


	if($("#ex_difference").length){
	    $('#ex_difference').val($.trim($('#ex_difference').val() ) ); 
	    if( $('#ex_difference').val() == "" ){
	       $('#ex_difference').parents('.sub_frame:first').addClass("has-error");
	        isOkay = false;
	         console.log("13");
	       
	    }
	}

	console.log("isOkay="+isOkay);

	if(isOkay==true){
		$("#complete_form [name=change_list]").val(  $('#myUL').html());
		//alert(JSON.stringify(changes));	
		$("#complete_form").submit();
		
	}
	else
	{
		 $("#error_alert").show();
	}


}




// Create a "close" button and append it to each list item
var myNodelist = document.getElementsByTagName("LI");
var i;
for (i = 0; i < myNodelist.length; i++) {
  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  myNodelist[i].appendChild(span);
}

// Click on a close button to hide the current list item
var close = document.getElementsByClassName("close");
var i;
for (i = 0; i < close.length; i++) {
  close[i].onclick = function() {
    var div = this.parentElement;
    div.style.display = "none";
  }
}

// Add a "checked" symbol when clicking on a list item
var list = document.querySelector('ul');
list.addEventListener('click', function(ev) {
  if (ev.target.tagName === 'LI') {
    ev.target.classList.toggle('checked');
  }
}, false);

// Create a new list item when clicking on the "Add" button
function newElement() {
  var li = document.createElement("li");
  var inputValue = document.getElementById("myInput").value;
  var t = document.createTextNode(inputValue);
  li.appendChild(t);
  if (inputValue === '') {
    alert("You must write something!");
  } else {
    document.getElementById("myUL").appendChild(li);
  }
  document.getElementById("myInput").value = "";

  var span = document.createElement("SPAN");
  var txt = document.createTextNode("\u00D7");
  span.className = "close";
  span.appendChild(txt);
  li.appendChild(span);

  for (i = 0; i < close.length; i++) {
    close[i].onclick = function() {
      var div = this.parentElement;
      div.style.display = "none";
    }
  }
}


</script>


 	
 </body>



</html>