<?php
 session_start();

 $mid=$_GET['mid'];
 $dfolder="design/";
 $type="overall";

 if(!$mid){header('Location: feedback_error.php');}

 include_once($_SERVER['DOCUMENT_ROOT'].'/interpretation/webpage-utility/db_utility.php');
 $conn = connect_to_db();
 	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
 }

 //Get Design
 if ($stmt = mysqli_prepare($conn, "SELECT time_spent, file, DesignID From Design WHERE mid = ?")) {
     /* bind parameters for markers */
     mysqli_stmt_bind_param($stmt, "s", $mid);
     /* execute query */
     mysqli_stmt_execute($stmt);
     /* bind result variables */
     $stmt->store_result();

 	if($stmt->num_rows > 0) {
 	    mysqli_stmt_bind_result($stmt, $time_spent,$file , $design_id);
 	    /* fetch value */
 	    mysqli_stmt_fetch($stmt);
 	    /* close statement */
 	    mysqli_stmt_close($stmt);
 	} else {
 	    //No Designs found
 	    header('Location: feedback_error.php');
 	}
  
 }

 /************ Get Provider IP ****************/
 if(!$_SERVER['REMOTE_ADDR']){$ip="0";}
 else{	$ip=$_SERVER['REMOTE_ADDR'];}

 if(!$_SERVER['HTTP_X_FORWARDED_FOR']){	$proxy="0";}
 else{	$proxy=$_SERVER['HTTP_X_FORWARDED_FOR'];}

 $_ip = mysqli_real_escape_string($conn, $ip);
 $_proxy = mysqli_real_escape_string($conn, $proxy);

?>

<!DOCTYPE html>
<html>
<head>
	<script src="js/jquery-1.11.3.min.js"></script>
  <?php include('webpage-utility/ele_header.php'); ?>
  <title> Review My Design </title>
   

   <link rel="stylesheet" type="text/css" href="dist/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="overall.css">

</head>
<body >
<div class="main-section" style="padding-top:50px;padding-right:50px;padding-left:50px">


		<div class="container">

			<!-- Instructions -->
			<div class="well" id="instructions" style="width:100%; font-size:16px; margin:0px auto;text-align:justify;padding-left:50px;padding-right:50px;background:#F2F2F2">				
				<h3 style="color:black;">
					<strong>
						Task Instructions
					</strong>
				</h3>
				<p >
					You will need to review a graphic design and its goals for at least one minute and provide feedback on the design. Your feedback should span three categories: 

					<ol>
						<li style="text-indent:20px"><b>Overall concept </b> of the design.</li>
	   					<li style="text-indent:20px"><b>Layout and composition </b>of the visual elements in the design.</li>
	   					<li style="text-indent:20px"><b>Aesthetics</b> of the design such as the color, font, and imagery choices.</li>
					</ol>

					For each category, you need to address both strengths (what you like) and weaknesses (what you don’t like) about that category of the design. Please limit the feedback within 150 words.</p>
				

					<div id="turker-div" name="turker-div"><strong> Enter your name to start :</strong> <input type="text" id="turkerID" name="turkerID"><em style="color:red;"> (required)*</em>
					<p><em style="color:grey">This is for the purpose of payment. </em></p>
					</div>

			</div>


			<div id="info" name="info" style="display:none"><span style='color:red'>You don't have the access to work on this task.</span></div>
			<div id='survey-part' style="display:none">

			<!--Design image and brief section-->
			<div class="row" style="width:100%;padding-top: 20px;  margin:auto;">
				
			<!--Design -->		
			<!--<div class="row" style="width:40%;padding-top: 20px;  margin:auto;">-->
					<div id="image" style="margin-top:20px">		
						 <div class="img-div" onmouseover="" style=" cursor: pointer; margin-right:20px; " >

						 <img style="border: 1px solid #A4A4A4; width:300px; " id="picture" name="picture" src="<?php echo $dfolder.$file ?>" onClick="view('<?php echo $mid;?> ');" >
						 <p><em style="color:grey">* Click on the image to enlarge </em></p>
						</div>
					</div>
			<!--</div>-->
			
					<h3>Design Goals</h3> 


					This is the first draft of a flyer created for a charity jazz concert featuring the band "Smooth Digital", a group of four alumni from the School of Music at the University of Illinois. The concert will take place on October 12th from 6:00 PM - 9:00 PM on the Main Quad. Tickets are $10 per person, and food and drink will also be available for purchase. All proceeds will be used to support music programs at local elementary schools. Tickets can be purchased in the Illini Union Building in Room 208. The goal of the flyer is to encourage participation, be visually appealing, and convey the event details.

					<p><br>You can click on the image to enlarge.</p></span>
			</div>
			<!--End Design image and brief section-->
			
			<hr>

			<div class="row" id="survey-part">	
				<div class="sub_frame">	
					<div id="qual_div">
						<h4 class="question-text"><strong>1. How would you rate the degree to which the flyer satisfied all of the design goals?</strong> <em style="color:red;"> (required)</em></h4>				
						<table border="0" cellpadding="5" cellspacing="0" id="entry_1519429516" style="text-align: center;width:30%;">
							<tr aria-hidden="true">
								<td  class="radio-label" ></td>
								<td><label class="radio-cell">1</label></td> 
								<td><label class="radio-cell">2</label></td> 
								<td><label class="radio-cell">3</label></td> 
								<td><label class="radio-cell">4</label></td>
								<td><label class="radio-cell">5</label></td>  
								<td><label class="radio-cell">6</label></td>  
								<td><label class="radio-cell">7</label></td>  
								<td  class="radio-label" ></td>
							</tr>
							<tr>
								<td class="radio-label" >Low</td>
								<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios1" value="1"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios2" value="2"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios3" value="3"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios4" value="4"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="5"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="6"></td>
							<td class="radio-cell"><input type="radio" class="radio-inline" name="qualRadios" id="qualRadios5" value="7"></td>
							<td class="radio-label">High</td>		
							</tr>
						</table>
					</div>
				</div>
				
				<div class="sub_frame">	
					<div id="fbk_div">
					<h4 class="question-text required"><strong>2. Enter your feedback to the design including both its strengths and weaknesses and spans three categories of the design (i.e. overall concept, layout and aesthetics). &nbsp</strong><em style="color:red;"> (required)</em></h4>
					 <textarea id="text" name="text" rows="10" onkeyup="onTextKeyUp()" onkeydown="onTextKeyDown(event)" style="width:100%;"></textarea>
					 
					</div>
				</div>

					<div style="text-align:center;margin-top:20px;" ><button type="submit" class="btn-submit" name="submit-bn" id="submit-bn" onclick="verified();">	Submit</button> </div>
				


				<form action="webpage-utility/save_feedback.php?mid=<?php echo $mid;?>" method="post" id="feedback_form" name="feedback_form">
					<input type="hidden" name="_fbk-text">
					<input type="hidden" name="_age">
					<input type="hidden" name="_expertL">
					<input type="hidden" name="_gender">
					<input type="hidden" name="_quality">
					<input type="hidden" name="_behavior">
					<input type="hidden" name="_turkerID">
					<input type="hidden" name="_ip" value="<?php echo $ip;?>">
					<input type="hidden" name="_proxy" value="<?php echo $proxy;?>">


					<input type="hidden" name="_type" id="_type" value="<?php echo $type;?>">
					<input type="hidden" name="_designID" id="_designID" value="<?php echo $design_id;?>">
					<input type="hidden" id="startTime" name="startTime" value=""/>
					<input type="hidden" id="submitTime" name="submitTime" value=""/>
	        		<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
	        		<input type="hidden" id="taskTime" name="taskTime" value=""/>
	        		<input type="hidden" id="numberOfOps" name="numberOfOps" value=""/>
	        		<input type="hidden" id="numberOfPause" name="numberOfPause" value=""/>
	        		<input type="hidden" id="numberOfDel" name="numberOfDel" value=""/>
	        		<input type="hidden" id="timeStamps" name="timeStamps" value=""/>        	
	        		<input type="hidden" id="eventHistory" name="eventHistory" value=""/>
	        		
				
				</form>

				

				
	
			</div><!--END OF survey part-->


	</div><!--end container-->

</div><!--end main-section-->
<script>
var provider_ok=1;
var isOkay=1;

var hitStartTime;

var annoStartTime;
var annoEndTime;

var opsCount = 0;
var typingTimer;
var doneTypingInterval = 1000;
var pauseCount = 0;
var delCount = 0;

var annotationFlag = false;
var delFlag = false;

var prevStroke;
var eventLogs = [];

function view(mid) {

window.open("viewpic.php?image="+mid);

//viewwin = window.open(imgsrc.src,'viewwin', 'width=1000,height=auto'); 
}

//Check TurkID 
document.getElementById('turkerID').focusout = function(e){  	
	if ($('#turkerID').val() != "") {
		$('#survey-part').show();
	}

};


function logAction(action, param) {
  console.log(action);
  if (typeof param === "undefined") {
    eventLogs.push([(new Date()).getTime(), action]);
  }
  else {
    eventLogs.push([(new Date()).getTime(), action, param])
  }
}



$(document).ready(function() {
  // var task_params = document.getElementById("survey").href.substring(56).toString();
  // (new Image).src = 'http://128.174.241.28:8080/?' + task_params;
 
		  hitStartTime = (new Date()).getTime();
		  logAction("init");

		 $('textarea').bind('cut copy paste', function (e) {
		    e.preventDefault(); //disable cut,copy,paste
		});


		  $(window).focus(function() {
		    logAction("focus");
		  });

		  $(window).blur(function() {
		    logAction("blur");
		  });

		$('input[type=radio][name=qualRadios]').change(function(){
			  logAction("quality");
			  $("#qual_div").removeClass("has-error-text");
		})


		$("#text").bind("keydown", function(){			
	    	$('#fbk_div').removeClass("has-error-text");
		}
		);

		$("#turkerID").bind("keydown", function(){
	    	$('#turker-div').removeClass("has-error-text");
		}
		);


 
});




function counting(textvalue){
  // var value = $('#text').val();
  var value = textvalue;
    var regex = /\s+/gi;
    var wordCount = value.trim().replace(regex, ' ').split(' ').length;
    var totalChars = value.length;
    var charCount = value.trim().length;
    var charCountNoSpace = value.replace(regex, '').length;
    return wordCount; 
}

function onTextKeyUp() {

  clearTimeout(typingTimer);
  typingTimer = setTimeout(recordPause, doneTypingInterval);
  //$('#word-good').html(counting(document.getElementById('text').value));
  logAction("text_update", document.getElementById("text").value);
}

function onTextKeyDown(e) {

  if (annotationFlag == false) {
   	annoStartTime = (new Date()).getTime();
    annotationFlag = true;
    logAction("start");
  }



  clearTimeout(typingTimer);

  var unicode = e.keyCode ? e.keyCode : e.charCode;
  if (unicode == 8 || unicode == 46) {
    if (!delFlag) {
      delCount += 1;
      delFlag = true;
    }
  }
  else if (delFlag) {
    delFlag = false;
  }
}

function recordPause() {
  pauseCount += 1;
}

function getParameterByName(name) {
  name = name.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
  results = regex.exec(location.search);
  return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}



function verified(){
		
		var errorMsg='';
	  	$("#error_alert").hide();
		$(".has-error").removeClass("has-error");
		 var isOkay = true;


	if ($('#turkerID').val() == "") {
		 $("#error_alert").show();
		 errorMsg=errorMsg+'\n'+"Provide your name to get your compensation.";
		 $('#turker-div').addClass("has-error-text");
		 isOkay = false;
		}
		//var multiline= $('#text').val().replace(/\r?\n/g, '<br />');
	 	//$('#text').val( $.trim( multiline ));

		if ($('#text').val() == "") {
			 $("#error_alert").show();
			 $('#fbk_div').addClass("has-error-text");
			 isOkay = false;
			 errorMsg=errorMsg+'\n'+"Provide your feedback.";
		}
		else{
			if(counting(document.getElementById('text').value)<3)
			{	
				 errorMsg=errorMsg+'\n'+"You feedback is too short. Please elaborate on your comments more.";
				$('#fbk_div').addClass("has-error-text");
				 isOkay = false;
			}
		}



	    if ($("input[name='qualRadios']:checked").size() == 0 ) {
          $("#qual_div").addClass("has-error-text");
          errorMsg=errorMsg+'\n'+"Rate your perceive quality of the design.";
			 
          isOkay = false;
        }
	
		if(isOkay==true && provider_ok==1){
			logAction("submit");
			$("#feedback_form [name=_fbk-text]").val( $("#text").val() );
			$("#feedback_form [name=_quality]").val($('input[name="qualRadios"]:checked').val() );
			$("#feedback_form [name=_turkerID]").val( $("#turkerID").val() );
			$("#feedback_form").submit();
			
		}
		else
		{
			$("#error_alert").show();
		   alert("Before submitting, your response should: "+errorMsg);
		}
}



</script>

</body>
</html>