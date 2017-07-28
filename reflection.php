<?php


?>
 <html lang="en">
<head>
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<?php include('webpage-utility/ele_header.php');?>
     <script type="text/javascript" src="/reflection/js/reflection_script.js"></script>


    <title>Home </title>
    <!-- Custom styles for this template -->

 <style>
 body{
background-color: #F0F0F0 ;

}
.question-text{
	font-family:Tahoma, Geneva, sans-serif;
	font-size:14px;
}
 .project-description{
	text-align: justify;
	font-size:14px;
}

.img-div{
    float: left;
    padding-right: 30px;
    margin-left: 30px;
    text-align:right;
}
#head_frame{

	padding-right: 30px;
    padding-left: 30px;
	padding-top: 10px;
    padding-bottom: 20px;
    margin-top: 20px;
    border-radius: 20px;

}

.sub_frame{
	background-color: #FAFAFA;
	padding-right: 20px;
    padding-left: 20px;
	padding-top: 5px;
    padding-bottom: 20px;
   margin-top: 10px;
    border-radius: 20px;

}
#submit-bn{
	padding-top:"10px";
	width: "500px";
}
.rating{
	  float: left;
} 
.table-head{
	font-weight: bold;
}


.radio-cell{
	width: 25px;
	text-align: center;
} 
.radio-label{
	width: 50px;
	text-align: center;
} 

.table-nonfluid {
   width: auto;
}

.btn-submit {
  background: #288a5c;
  background-image: -webkit-linear-gradient(top, #288a5c, #305242);
  background-image: -moz-linear-gradient(top, #288a5c, #305242);
  background-image: -ms-linear-gradient(top, #288a5c, #305242);
  background-image: -o-linear-gradient(top, #288a5c, #305242);
  background-image: linear-gradient(to bottom, #288a5c, #305242);
  -webkit-border-radius: 25;
  -moz-border-radius: 25;
  border-radius: 25px;
  -webkit-box-shadow: 1px 3px 5px #666666;
  -moz-box-shadow: 1px 3px 5px #666666;
  box-shadow: 1px 3px 5px #666666;
  font-family: Arial;
  color: #ffffff;
  font-size: 18px;
  padding: 10px 20px 10px 20px;
  text-decoration: none;
}

.btn-submit:hover {
  background:  #a8e6bb;;
  text-decoration: none;

}
.table-text{
 font-size: 14px;

}

#help-text
{
	font-size: 14px;
}

.has-error
{
	background-color:#f2dede ;
}

.has-error-text
{
	color:red ;
}
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
  background-color: #FFFFCC;
}

.help-text{
	color:#34495E  ;
	font-style: italic;
}
</style>
 </head>
 <body>
 <?php include($_SERVER['DOCUMENT_ROOT'].'/reflection/webpage-utility/ele_nav.php');?>
<div class="main-section">

<div class="container" style="background-color:white; padding-top:20px;   border-radius: 15px; ">



<div class="alert alert-info" style='width:80%; text-align:justify ; height:auto ;margin:0px auto; padding-top:0px;padding-left: 25px;padding-right: 15px; font-size:16px;color:black;' >
<h3>Reflection Questions</h3>
<p> Before revising your design, we want you to reflect on the feedback you just received by responding to three questions. Please spend around <strong>15 minutes </strong>thinking and answering all the questions. After that, please click SUBMIT to continue to the next step.
	<p><br>
	<a href= 'view_initial.php?mid=<?php echo $mid;?>' target="_blanck"> See design description and my initial design</a>
	</p>
</p>
</div>

<div class="row" style="width:80%; height:auto ;margin:0px auto;">

<div class="col-md-12">
	
	
	
	<form name='reflection-form' id='reflection-form' action='save_reflection.php?design_id=<?php echo $design_id;?>' method='post'>	

	<div class="alert alert-danger" role="alert" id="error_alert" name="error_alert" style="display:none; margin-top:10px">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					 Please answer each question with at least 20 words.
		</div>		
	<div class="sub_frame required" id="div-designconcept">				
		<h4 class="question-text"><strong>1. What do I feel about the feedback?
 &nbsp</strong><em style="color:red;"></em></h4>
		 <textarea id="designconcept" name="designconcept" rows="5" cols="62" onkeyup="onTextKeyUp(this.id)" onkeydown="onTextKeyDown(this.id,event)" style="width:100%;"><?php echo htmlspecialchars($designconcept); ?></textarea>
		<span id="for-concept" name="for-concept" class="help-text" style='display:none'> Please elaborate more on this answer. (Min: 20 words). Current word count: <span id="word-designconcept"></span>	</span>
	</div>

	<div class="sub_frame required" id="div-good">				
		<h4 class="question-text"><strong>2. What do I think about the feedback?</strong><em style="color:red;"> (required)</em></h4>
		 <textarea id="good" name="good" rows="5" cols="62" onkeyup="onTextKeyUp(this.id)" onkeydown="onTextKeyDown(this.id,event)" style="width:100%;"><?php echo htmlspecialchars($good); ?></textarea>	
		<span id="for-good" name="for-good" class="help-text" style='display:none'> Please elaborate more on this answer. (Min: 20 words). Current word count: <span id="word-good"></span>	</span>
	</div>

	<div class="sub_frame required" id="div-bad">				
		<h4 class="question-text"><strong>3. Based on the feedback, what actions could I take to improve my design?&nbsp</strong><em style="color:red;"> (required)</em></h4>
		 <textarea id="bad" name="bad" rows="5" cols="62" onkeyup="onTextKeyUp(this.id)" onkeydown="onTextKeyDown(this.id,event)" style="width:100%;"><?php echo htmlspecialchars($bad); ?></textarea>	
		<span id="for-bad" name="for-bad" class="help-text" style='display:none'> Please elaborate more on this answer. (Min: 20 words). Current word count: <span id="word-bad"></span></span>	
	</div>



		<input type="hidden" id="_designconcept" name="_designconcept" value=""/>
		<input type="hidden" id="_good" name="_good" value=""/>
		<input type="hidden" id="_bad" name="_bad" value=""/>


		<input type="hidden" id="startTime" name="startTime" value=""/>
		<input type="hidden" id="submitTime" name="submitTime" value=""/>
		<input type="hidden" id="prepareTime" name="prepareTime" value=""/>
		<input type="hidden" id="taskTime" name="taskTime" value=""/> 	
		<input type="hidden" id="_behavior" name="_behavior" value=""/>
		<input type="hidden" id="numberOfPause" name="numberOfPause" value=""/>
		<input type="hidden" id="numberOfDel" name="numberOfDel" value=""/>

	</form>

	<div style='text-align:center ;margin-top:20px;margin-bottom:20px'>
		 <button type='submit' class='btn-submit' id='submit-bn' onclick='submit();'>Submit</button> 
	</div>

	
	
</div><!--end of col-med-8-->

</div><!--end of row-->



</div><!-- ENd of container-->

</div><!-- ENd of main-section-->

<script>
function toggleDelayed() {
    var isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed == "1")
        isDelayed = "0";
    else
        isDelayed = "1";
    localStorage.setItem("isDelayed", isDelayed);
    location.reload();
}

function submit() {

        window.location.href = "second_stage.php";

}

$(document).ready(function(){
    var isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed != "1")
        //document.getElementById("reprint").innerHTML = "<br>Your design has been reprinted several times for your ease of reference.";
    
    isDelayed = localStorage.getItem("isDelayed");
    if(isDelayed == "1") {
        $("#response2").hide();
        $("#response3").hide();
    }
});
</script>


 </body>



</html>

